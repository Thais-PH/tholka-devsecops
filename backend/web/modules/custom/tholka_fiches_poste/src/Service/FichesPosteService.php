<?php

namespace Drupal\tholka_fiches_poste\Service;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\node\Entity\Node;

/**
 * Service pour la gestion des fiches de poste.
 */
class FichesPosteService {

  protected $entityTypeManager;
  protected $currentUser;

  public function __construct(EntityTypeManagerInterface $entity_type_manager, AccountInterface $current_user) {
    $this->entityTypeManager = $entity_type_manager;
    $this->currentUser = $current_user;
  }

  /**
   * B1 & B6 - Récupérer la liste des fiches de poste avec filtres.
   */
  public function getFichesPoste($filters = [], $sort = [], $page = 0, $limit = 20) {
    $query = $this->entityTypeManager->getStorage('node')->getQuery()
      ->condition('type', 'job_description')
      ->accessCheck(TRUE);

    // Filtres par statut
    if (!empty($filters['status'])) {
      $status_query = $this->entityTypeManager->getStorage('taxonomy_term')->getQuery()
        ->condition('vid', 'job_description_status')
        ->condition('field_taxo_system_name', $filters['status'])
        ->accessCheck(TRUE);
      $status_tids = $status_query->execute();
      
      if (!empty($status_tids)) {
        $query->condition('field_job_description_status', array_values($status_tids), 'IN');
      } else {
        $query->condition('nid', 0, '<'); // Statut inexistant = résultat vide
      }
    }

    // Filtre par recherche textuelle
    if (!empty($filters['search'])) {
      $group = $query->orConditionGroup()
        ->condition('title', '%' . $filters['search'] . '%', 'LIKE')
        ->condition('field_job_missions', '%' . $filters['search'] . '%', 'LIKE')
        ->condition('field_job_responsibilities', '%' . $filters['search'] . '%', 'LIKE');
      $query->condition($group);
    }

    // Filtre par entreprise
    if (!empty($filters['company_id'])) {
      $query->condition('field_parent_company', $filters['company_id']);
    }

    // Filtre par compétences
    if (!empty($filters['skills'])) {
      $skills_array = is_array($filters['skills']) ? $filters['skills'] : explode(',', $filters['skills']);
      $query->condition('field_job_required_skills', $skills_array, 'IN');
    }

    // Tri
    if (!empty($sort['field']) && !empty($sort['direction'])) {
      $direction = strtoupper($sort['direction']) === 'DESC' ? 'DESC' : 'ASC';
      
      switch ($sort['field']) {
        case 'title':
          $query->sort('title', $direction);
          break;
        case 'created':
          $query->sort('created', $direction);
          break;
        case 'updated':
          $query->sort('changed', $direction);
          break;
        default:
          $query->sort('created', 'DESC');
      }
    } else {
      $query->sort('created', 'DESC');
    }

    // Pagination
    $query->range($page * $limit, $limit);

    $nids = $query->execute();
    $nodes = $this->entityTypeManager->getStorage('node')->loadMultiple($nids);

    $results = [];
    foreach ($nodes as $node) {
      $results[] = $this->formatFichePosteForApi($node);
    }

    // Count query avec mêmes filtres
    $count_query = $this->entityTypeManager->getStorage('node')->getQuery()
      ->condition('type', 'job_description')
      ->accessCheck(TRUE);

    // Appliquer les mêmes filtres pour le count
    if (!empty($filters['status'])) {
      $status_query = $this->entityTypeManager->getStorage('taxonomy_term')->getQuery()
        ->condition('vid', 'job_description_status')
        ->condition('field_taxo_system_name', $filters['status'])
        ->accessCheck(TRUE);
      $status_tids = $status_query->execute();
      
      if (!empty($status_tids)) {
        $count_query->condition('field_job_description_status', array_values($status_tids), 'IN');
      } else {
        $count_query->condition('nid', 0, '<');
      }
    }

    if (!empty($filters['search'])) {
      $group = $count_query->orConditionGroup()
        ->condition('title', '%' . $filters['search'] . '%', 'LIKE')
        ->condition('field_job_missions', '%' . $filters['search'] . '%', 'LIKE')
        ->condition('field_job_responsibilities', '%' . $filters['search'] . '%', 'LIKE');
      $count_query->condition($group);
    }

    if (!empty($filters['company_id'])) {
      $count_query->condition('field_parent_company', $filters['company_id']);
    }

    if (!empty($filters['skills'])) {
      $skills_array = is_array($filters['skills']) ? $filters['skills'] : explode(',', $filters['skills']);
      $count_query->condition('field_job_required_skills', $skills_array, 'IN');
    }

    $total = $count_query->count()->execute();

    return [
      'data' => $results,
      'total' => $total,
      'page' => $page,
      'limit' => $limit,
      'pages' => ceil($total / $limit),
    ];
  }

  /**
   * B2 - Récupérer une fiche de poste par ID.
   */
  public function getFichePoste($id) {
    $node = $this->entityTypeManager->getStorage('node')->load($id);
    
    if (!$node || $node->bundle() !== 'job_description') {
      throw new \Exception('Fiche de poste introuvable');
    }

    return $this->formatFichePosteForApi($node, TRUE);
  }

  /**
   * B3 - Créer une nouvelle fiche de poste.
   */
  public function createFichePoste($data) {
    // Validation des données requises
    if (empty($data['title'])) {
      throw new \Exception('Le titre du poste est requis');
    }

    if (empty($data['missions'])) {
      throw new \Exception('Les missions principales sont requises');
    }

    if (!empty($data['required_skills']) && !empty($data['company_id'])) {
      $valid_skills = $this->validateSkillsForCompany($data['required_skills'], $data['company_id']);
      if (!$valid_skills) {
        throw new \Exception('Une ou plusieurs compétences ne sont pas valides pour cette entreprise');
      }
    }

    if (empty($data['company_id'])) {
      throw new \Exception('L\'entreprise parente est requise');
    }

    // Récupérer le statut par défaut (Brouillon)
    $default_status = $this->getJobDescriptionStatusId('Brouillon');
    if (!$default_status) {
      throw new \Exception('Statut par défaut introuvable');
    }

    // Créer la fiche de poste
    $fiche_data = [
      'type' => 'job_description',
      'title' => $data['title'],
      'field_job_missions' => ['value' => $data['missions'], 'format' => 'basic_html'],
      'field_job_required_skills' => $data['required_skills'],
      'field_job_description_status' => $default_status,
      'field_parent_company' => $data['company_id'],
    ];

    // Champs optionnels
    if (!empty($responsibilities)) {
      $fiche_data['field_job_responsibilities'] = ['value' => $data['responsibilities'], 'format' => 'basic_html'];
    }

    if (!empty($desired_profile)) {
      $fiche_data['field_job_desired_profile'] = ['value' => $data['desired_profile'], 'format' => 'basic_html'];
    }

    $fiche = Node::create($fiche_data);
    $fiche->save();

    return $this->formatFichePosteForApi($fiche, TRUE);
  }

  /**
   * Valider que les compétences appartiennent à l'entreprise.
   */
  private function validateSkillsForCompany($skill_ids, $company_id) {
    $query = $this->entityTypeManager->getStorage('taxonomy_term')->getQuery()
      ->condition('vid', 'skills')
      ->condition('tid', $skill_ids, 'IN')
      ->condition('field_parent_company', $company_id)
      ->accessCheck(TRUE);
    
    $valid_tids = $query->execute();
    
    // Vérifier que toutes les compétences demandées sont valides
    return count($valid_tids) === count($skill_ids);
  }

  // /**
  //  * Formater les textes longs (listes → ul/li, paragraphes).
  //  */
  // private function formatLongText($text) {
  //   if (empty($text)) return '';
    
  //   // Détecter si c'est une liste (lignes commençant par • ou -)
  //   $lines = explode("\n", trim($text));
  //   $is_list = false;
    
  //   foreach ($lines as $line) {
  //     $line = trim($line);
  //     if (!empty($line) && (strpos($line, '•') === 0 || strpos($line, '-') === 0)) {
  //       $is_list = true;
  //       break;
  //     }
  //   }
    
  //   if ($is_list) {
  //     // Convertir en liste HTML
  //     $html = '<ul>';
  //     foreach ($lines as $line) {
  //       $line = trim($line);
  //       if (!empty($line)) {
  //         // Enlever les puces • ou -
  //         $line = preg_replace('/^[•\-]\s*/', '', $line);
  //         $html .= '<li>' . htmlspecialchars($line) . '</li>';
  //       }
  //     }
  //     $html .= '</ul>';
  //     return $html;
  //   } else {
  //     // Convertir les sauts de ligne en paragraphes
  //     $paragraphs = explode("\n\n", trim($text));
  //     $html = '';
  //     foreach ($paragraphs as $paragraph) {
  //       $paragraph = trim($paragraph);
  //       if (!empty($paragraph)) {
  //         // Remplacer les simples sauts de ligne par <br>
  //         $paragraph = nl2br(htmlspecialchars($paragraph));
  //         $html .= '<p>' . $paragraph . '</p>';
  //       }
  //     }
  //     return $html;
  //   }
  // }

  /**
   * B4 - Modifier une fiche de poste.
   */
  public function updateFichePoste($id, $data) {
    $fiche = $this->entityTypeManager->getStorage('node')->load($id);
    
    if (!$fiche || $fiche->bundle() !== 'job_description') {
      throw new \Exception('Fiche de poste introuvable');
    }

    if (isset($data['required_skills']) && isset($data['company_id'])) {
      $valid_skills = $this->validateSkillsForCompany($data['required_skills'], $data['company_id']);
      if (!$valid_skills) {
        throw new \Exception('Une ou plusieurs compétences ne sont pas valides pour cette entreprise');
      }
    }

    // Mise à jour des champs modifiables
    if (isset($data['title'])) {
      $fiche->set('title', $data['title']);
    }

    if (isset($data['missions'])) {
      $fiche->set('field_job_missions', ['value' => $data['missions'], 'format' => 'basic_html']);
    }

    if (isset($data['required_skills'])) {
      $fiche->set('field_job_required_skills', $data['required_skills']);
    }

    if (isset($data['responsibilities'])) {
      $fiche->set('field_job_responsibilities', ['value' => $data['responsibilities'], 'format' => 'basic_html']);
    }

    if (isset($data['desired_profile'])) {
      $fiche->set('field_job_desired_profile', ['value' => $data['desired_profile'], 'format' => 'basic_html']);
    }

    if (isset($data['status'])) {
      $status_id = $this->getJobDescriptionStatusId($data['status']);
      if ($status_id) {
        $fiche->set('field_job_description_status', $status_id);
      }
    }

    if (isset($data['company_id'])) {
      $fiche->set('field_parent_company', $data['company_id']);
    }

    $fiche->save();

    return $this->formatFichePosteForApi($fiche, TRUE);
  }

  /**
   * B5 - Supprimer une fiche de poste.
   */
  public function deleteFichePoste($id) {
    $fiche = $this->entityTypeManager->getStorage('node')->load($id);
    
    if (!$fiche || $fiche->bundle() !== 'job_description') {
      throw new \Exception('Fiche de poste introuvable');
    }

    // Supprimer la fiche (sans affecter les données liées)
    $fiche->delete();

    return TRUE;
  }

  /**
   * Formater une fiche de poste pour l'API.
   */
  private function formatFichePosteForApi($node, $detailed = FALSE) {
    $data = [
      'id' => $node->id(),
      'title' => $node->getTitle(),
      'status' => $this->getJobDescriptionStatusName($node->get('field_job_description_status')->target_id),
      'created' => $node->getCreatedTime(),
      'updated' => $node->getChangedTime(),
    ];

    // Informations entreprise
    if ($node->hasField('field_parent_company') && !$node->get('field_parent_company')->isEmpty()) {
      $company = $node->get('field_parent_company')->entity;
      if ($company) {
        $data['company'] = [
          'id' => $company->id(),
          'name' => $company->getTitle(),
        ];
      }
    }

    // Compétences requises (toujours afficher)
    $skills = [];
    if ($node->hasField('field_job_required_skills') && !$node->get('field_job_required_skills')->isEmpty()) {
      foreach ($node->get('field_job_required_skills')->referencedEntities() as $skill_term) {
        // Vérifier que c'est bien de la taxonomie skills
        if ($skill_term->bundle() === 'skills') {
          $skills[] = [
            'id' => $skill_term->id(),
            'name' => $skill_term->getName(),
          ];
        }
      }
    }
    $data['required_skills'] = $skills;

    // Détails complets si demandé
    if ($detailed) {
      $data['missions'] = $node->hasField('field_job_missions') ? 
        $node->get('field_job_missions')->value : '';
      
      $data['responsibilities'] = $node->hasField('field_job_responsibilities') ? 
        $node->get('field_job_responsibilities')->value : '';
        
      $data['desired_profile'] = $node->hasField('field_job_desired_profile') ? 
        $node->get('field_job_desired_profile')->value : '';
    }

    return $data;
  }

  /**
   * Récupérer les compétences disponibles pour une entreprise.
   */
  public function getSkillsForCompany($company_id) {
    $query = $this->entityTypeManager->getStorage('taxonomy_term')->getQuery()
      ->condition('vid', 'skills')
      ->condition('field_parent_company', $company_id)
      ->accessCheck(TRUE)
      ->sort('name');
    
    $tids = $query->execute();
    $terms = $this->entityTypeManager->getStorage('taxonomy_term')->loadMultiple($tids);
    
    $skills = [];
    foreach ($terms as $term) {
      $skills[] = [
        'id' => $term->id(),
        'name' => $term->getName(),
      ];
    }
    
    return $skills;
  }

  /**
   * Récupérer l'ID d'un statut de fiche de poste par nom.
   */
  private function getJobDescriptionStatusId($status_name) {
    $query = $this->entityTypeManager->getStorage('taxonomy_term')->getQuery()
      ->condition('vid', 'job_description_status')
      ->condition('name', $status_name)
      ->accessCheck(TRUE);
    
    $tids = $query->execute();
    return !empty($tids) ? reset($tids) : NULL;
  }

  /**
   * Récupérer le nom d'un statut de fiche de poste par ID.
   */
  private function getJobDescriptionStatusName($status_id) {
    if (!$status_id) return '';
    
    $term = $this->entityTypeManager->getStorage('taxonomy_term')->load($status_id);
    return $term ? $term->getName() : '';
  }

  /**
   * Récupérer les templates de fiches de poste pour B3.
   */
  public function getJobDescriptionTemplates() {
    // Templates pré-définis pour la création
    return [
      [
        'id' => 'developpeur',
        'name' => 'Développeur Full Stack',
        'template' => [
          'missions' => "Développer et maintenir des applications web\n Collaborer avec l'équipe produit\n Participer aux phases de conception technique",
          'responsibilities' => "Développement front-end et back-end\n Tests et débogage\n Documentation technique",
          'desired_profile' => "Formation en informatique (Bac+3/5)\n Expérience en développement web\n Maîtrise des technologies modernes",
          'required_skills' => ['JavaScript', 'PHP', 'HTML/CSS', 'Base de données']
        ]
      ],
      [
        'id' => 'manager',
        'name' => 'Manager d\'équipe',
        'template' => [
          'missions' => "Manager une équipe de 5-10 personnes\n Définir les objectifs et suivre les performances\n Accompagner le développement des collaborateurs",
          'responsibilities' => "Gestion d'équipe\n Reporting et suivi des indicateurs\n Recrutement et formation",
          'desired_profile' => "Formation supérieure (Bac+5)\n Expérience managériale de 3+ ans\n Leadership et communication",
          'required_skills' => ['Management', 'Communication', 'Gestion de projet', 'Leadership']
        ]
      ]
    ];
  }
}