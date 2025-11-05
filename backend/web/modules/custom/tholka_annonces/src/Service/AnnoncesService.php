<?php

namespace Drupal\tholka_annonces\Service;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\node\Entity\Node;

/**
 * Service pour la gestion des annonces.
 */
class AnnoncesService {

  protected $entityTypeManager;
  protected $currentUser;

  public function __construct(EntityTypeManagerInterface $entity_type_manager, AccountInterface $current_user) {
    $this->entityTypeManager = $entity_type_manager;
    $this->currentUser = $current_user;
  }

  /**
   * Récupère la liste des annonces avec filtres.
   */
  public function getAnnonces($filters = [], $sort = [], $page = 0, $limit = 20) {
    $query = $this->entityTypeManager->getStorage('node')->getQuery()
      ->condition('type', 'job_posting')
      ->accessCheck(TRUE);

    // Filtres par statut (draft/published/archived)
    if (!empty($filters['status'])) {
      $status_query = $this->entityTypeManager->getStorage('taxonomy_term')->getQuery()
        ->condition('vid', 'job_posting_status')
        ->condition('field_taxo_system_name', $filters['status'])
        ->accessCheck(TRUE);
      $status_tids = $status_query->execute();
      
      if (!empty($status_tids)) {
        $query->condition('field_posting_status', array_values($status_tids), 'IN');
      }
    }

    // Filtre par recherche textuelle
    if (!empty($filters['search'])) {
      $group = $query->orConditionGroup()
        ->condition('title', '%' . $filters['search'] . '%', 'LIKE')
        ->condition('field_posting_ia_description', '%' . $filters['search'] . '%', 'LIKE');
      $query->condition($group);
    }

    // Filtre par localisation
    if (!empty($filters['localisation'])) {
      $query->condition('field_posting_localization', '%' . $filters['localisation'] . '%', 'LIKE');
    }

    // Filtre par entreprise
    if (!empty($filters['company_id'])) {
      $query->condition('field_parent_company', $filters['company_id']);
    }

    // Filtres par date
    if (!empty($filters['date_from'])) {
      $query->condition('created', strtotime($filters['date_from']), '>=');
    }

    if (!empty($filters['date_to'])) {
      $query->condition('created', strtotime($filters['date_to']), '<=');
    }

    // Tri
    if (!empty($sort['field']) && !empty($sort['direction'])) {
      $query->sort($sort['field'], $sort['direction']);
    } else {
      $query->sort('created', 'DESC');
    }

    // Pagination
    $query->range($page * $limit, $limit);

    $nids = $query->execute();
    $nodes = $this->entityTypeManager->getStorage('node')->loadMultiple($nids);

    $results = [];
    foreach ($nodes as $node) {
      $results[] = $this->formatAnnonceForApi($node);
    }

    // Compte total pour la pagination
    $count_query = $this->entityTypeManager->getStorage('node')->getQuery()
      ->condition('type', 'job_posting')
      ->accessCheck(TRUE);
    
    // Réappliquer les mêmes filtres pour le compte
    if (!empty($filters['status'])) {
      $status_query = $this->entityTypeManager->getStorage('taxonomy_term')->getQuery()
        ->condition('vid', 'job_posting_status')
        ->condition('field_taxo_system_name', $filters['status'])
        ->accessCheck(TRUE);
      $status_tids = $status_query->execute();
      
      if (!empty($status_tids)) {
        $count_query->condition('field_posting_status', array_values($status_tids), 'IN');
      }
    }

    // Filtre par recherche textuelle
    if (!empty($filters['search'])) {
      $group = $count_query->orConditionGroup()
        ->condition('title', '%' . $filters['search'] . '%', 'LIKE')
        ->condition('field_posting_ia_description', '%' . $filters['search'] . '%', 'LIKE');
      $count_query->condition($group);
    }

    // Filtre par localisation
    if (!empty($filters['localisation'])) {
      $count_query->condition('field_posting_localization', '%' . $filters['localisation'] . '%', 'LIKE');
    }

    // Filtre par entreprise
    if (!empty($filters['company_id'])) {
      $count_query->condition('field_parent_company', $filters['company_id']);
    }

    // Filtres par date
    if (!empty($filters['date_from'])) {
      $count_query->condition('created', strtotime($filters['date_from']), '>=');
    }

    if (!empty($filters['date_to'])) {
      $count_query->condition('created', strtotime($filters['date_to']), '<=');
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
   * Récupère une annonce par ID.
   */
  public function getAnnonce($id) {
    $node = $this->entityTypeManager->getStorage('node')->load($id);
    
    if (!$node || $node->bundle() !== 'job_posting') {
      return NULL;
    }

    return $this->formatAnnonceForApi($node, TRUE);
  }

  /**
   * Crée une nouvelle annonce.
   */
  public function createAnnonce($data) {
    // Récupérer l'ID du terme de statut par défaut (draft)
    $default_status_tid = $this->getStatusTermId('draft');
    
    $node_data = [
      'type' => 'job_posting',
      'title' => $data['title'],
      'uid' => $this->currentUser->id(),
      'field_posting_status' => $default_status_tid,
    ];

    // Mapping des champs
    $field_mapping = [
      'description' => 'field_posting_ia_description',
      'localisation' => 'field_posting_localization',
      'postes_a_pourvoir' => 'field_posting_job_vacancies',
      'liens_web_requis' => 'field_required_web_links',
      'lettre_motivation_requise' => 'field_required_cover_letter',
      'url_partage' => 'field_posting_url_share',
      'entreprise_id' => 'field_parent_company',
    ];

    foreach ($field_mapping as $api_field => $drupal_field) {
      if (isset($data[$api_field])) {
        $node_data[$drupal_field] = $data[$api_field];
      }
    }

    // Gestion des champs personnalisés (paragraphes)
    if (!empty($data['champs_personnalises'])) {
      $paragraphs = [];
      foreach ($data['champs_personnalises'] as $question) {
        $paragraph = \Drupal::entityTypeManager()
          ->getStorage('paragraph')
          ->create([
            'type' => 'custom_question',
            'field_question_label' => $question['label'],
            'field_question_type' => $question['type'],
            'field_required_question' => $question['required'] ?? FALSE,
          ]);
        $paragraph->save();
        $paragraphs[] = $paragraph;
      }
      $node_data['field_posting_custom_fields'] = $paragraphs;
    }

    $node = Node::create($node_data);
    $node->save();

    // Générer automatiquement l'URL de partage après création
    if (empty($data['url_partage'])) {
      $share_url = "/candidature?offre=" . $node->id();
      $node->set('field_posting_url_share', $share_url);
      $node->save();
    }

    return $this->formatAnnonceForApi($node, TRUE);
  }

  /**
   * Met à jour une annonce.
   */
  public function updateAnnonce($id, $data) {
    $node = $this->entityTypeManager->getStorage('node')->load($id);
    
    if (!$node || $node->bundle() !== 'job_posting') {
      throw new \Exception('Annonce introuvable');
    }

    // Mapping des champs pour mise à jour
    $field_mapping = [
      'title' => 'title',
      'description' => 'field_posting_ia_description',
      'localisation' => 'field_posting_localization',
      'postes_a_pourvoir' => 'field_posting_job_vacancies',
      'liens_web_requis' => 'field_required_web_links',
      'lettre_motivation_requise' => 'field_required_cover_letter',
      'url_partage' => 'field_posting_url_share',
    ];

    foreach ($field_mapping as $api_field => $drupal_field) {
      if (isset($data[$api_field])) {
        $node->set($drupal_field, $data[$api_field]);
      }
    }

    // Mise à jour du statut si fourni
    if (!empty($data['status'])) {
      $status_tid = $this->getStatusTermId($data['status']);
      if ($status_tid) {
        $node->set('field_posting_status', $status_tid);
      }
    }

    $node->save();

    return $this->formatAnnonceForApi($node, TRUE);
  }

  /**
   * Supprime une annonce.
   */
  public function deleteAnnonce($id) {
    $node = $this->entityTypeManager->getStorage('node')->load($id);
    
    if (!$node || $node->bundle() !== 'job_posting') {
      throw new \Exception('Annonce introuvable');
    }

    $node->delete();
    
    return ['message' => 'Annonce supprimée avec succès'];
  }

  /**
   * Génère une annonce avec l'IA.
   */
  public function generateAnnonce($prompt_data) {
    // TODO: Intégrer avec votre service d'IA
    // Récupérer le contexte de l'entreprise
    $company_context = '';
    if (!empty($prompt_data['company_id'])) {
      $company = $this->entityTypeManager->getStorage('node')->load($prompt_data['company_id']);
      if ($company) {
        $company_context = $company->getTitle();
      }
    }
    
    // Pour l'instant, on retourne un exemple
    $generated_content = [
      'title' => $prompt_data['titre_poste'] ?? 'Nouvelle annonce',
      'description' => "Contenu généré par l'IA pour " . $company_context . "...",
      'localisation' => $prompt_data['localisation'] ?? '',
      'postes_a_pourvoir' => $prompt_data['nb_postes'] ?? 1,
    ];

    return $generated_content;
  }

  /**
   * Duplique une annonce.
   */
  public function duplicateAnnonce($id) {
    $original = $this->entityTypeManager->getStorage('node')->load($id);
    
    if (!$original || $original->bundle() !== 'job_posting') {
      throw new \Exception('Annonce introuvable');
    }

    $duplicate = $original->createDuplicate();
    $duplicate->set('title', '(Copie) ' . $original->getTitle());

    // Remettre en brouillon
    $draft_status_tid = $this->getStatusTermId('draft');
    $duplicate->set('field_posting_status', $draft_status_tid);
    
    $duplicate->set('created', time());
    $duplicate->save();

    // Générer une URL de partage pour la copie
    $share_url = "/candidature?offre=" . $duplicate->id();
    $duplicate->set('field_posting_url_share', $share_url);
    $duplicate->save();

    return $this->formatAnnonceForApi($duplicate, TRUE);
  }

  /**
   * Récupère l'ID d'un terme de statut.
   */
  private function getStatusTermId($status_name) {
    $query = $this->entityTypeManager->getStorage('taxonomy_term')->getQuery()
      ->condition('vid', 'job_posting_status')
      ->condition('field_taxo_system_name', $status_name)
      ->accessCheck(TRUE);
    
    $tids = $query->execute();
    return !empty($tids) ? reset($tids) : NULL;
  }

  /**
   * Récupère le nom système d'un terme de statut.
   */
  private function getStatusSystemName($tid) {
    $term = $this->entityTypeManager->getStorage('taxonomy_term')->load($tid);
    if ($term && $term->hasField('field_taxo_system_name')) {
      return $term->get('field_taxo_system_name')->value;
    }
    return 'draft';
  }

  /**
   * Formate une annonce pour l'API.
   */
  private function formatAnnonceForApi($node, $detailed = FALSE) {
    // Récupération du statut
    $status = 'draft';
    if ($node->hasField('field_posting_status') && !$node->get('field_posting_status')->isEmpty()) {
      $status_tid = $node->get('field_posting_status')->target_id;
      $status = $this->getStatusSystemName($status_tid);
    }

    // Récupération de l'entreprise
    $company = NULL;
    if ($node->hasField('field_parent_company') && !$node->get('field_parent_company')->isEmpty()) {
      $company_node = $node->get('field_parent_company')->entity;
      if ($company_node) {
        $company = [
          'id' => $company_node->id(),
          'name' => $company_node->getTitle(),
        ];
      }
    }

    $data = [
      'id' => $node->id(),
      'title' => $node->getTitle(),
      'status' => $status,
      'created' => date('c', $node->getCreatedTime()),
      'updated' => date('c', $node->getChangedTime()),
      'localisation' => $node->hasField('field_posting_localization') ? $node->get('field_posting_localization')->value : '',
      'postes_a_pourvoir' => $node->hasField('field_posting_job_vacancies') ? (int) $node->get('field_posting_job_vacancies')->value : 1,
      'url_partage' => $node->hasField('field_posting_url_share') ? $node->get('field_posting_url_share')->uri : '',
      'company' => $company,
    ];

    if ($detailed) {
      // Récupération des champs personnalisés (paragraphes)
      $custom_fields = [];
      if ($node->hasField('field_posting_custom_fields') && !$node->get('field_posting_custom_fields')->isEmpty()) {
        foreach ($node->get('field_posting_custom_fields')->referencedEntities() as $paragraph) {
          $custom_fields[] = [
            'label' => $paragraph->get('field_question_label')->value,
            'type' => $paragraph->get('field_question_type')->value,
            'required' => (bool) $paragraph->get('field_required_question')->value,
          ];
        }
      }

      // Récupération des liens web requis
      $web_links = [];
      if ($node->hasField('field_required_web_links') && !$node->get('field_required_web_links')->isEmpty()) {
        foreach ($node->get('field_required_web_links')->getValue() as $link) {
          $web_links[] = $link['value'];
        }
      }

      $data += [
        'description' => $node->hasField('field_posting_ia_description') ? $node->get('field_posting_ia_description')->value : '',
        'champs_personnalises' => $custom_fields,
        'liens_web_requis' => $web_links,
        'lettre_motivation_requise' => $node->hasField('field_required_cover_letter') ? (bool) $node->get('field_required_cover_letter')->value : FALSE,
      ];
    }

    return $data;
  }
}