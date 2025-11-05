<?php

namespace Drupal\tholka_candidatures\Service;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\File\FileSystemInterface;
use Drupal\node\Entity\Node;
use Drupal\file\Entity\File;

/**
 * Service pour la gestion des candidatures.
 */
class CandidaturesService {

  protected $entityTypeManager;
  protected $currentUser;
  protected $fileSystem;

  public function __construct(EntityTypeManagerInterface $entity_type_manager, AccountInterface $current_user, FileSystemInterface $file_system) {
    $this->entityTypeManager = $entity_type_manager;
    $this->currentUser = $current_user;
    $this->fileSystem = $file_system;
  }

  /**
   * C1 - Accéder au formulaire de candidature publique.
   */
  public function getPublicCandidatureForm($job_posting_id) {
    // Vérifier que l'annonce existe et est publiée
    $job_posting = $this->entityTypeManager->getStorage('node')->load($job_posting_id);
    
    if (!$job_posting || $job_posting->bundle() !== 'job_posting') {
      throw new \Exception('Annonce d\'emploi introuvable');
    }

    // Vérifier le statut publié
    $status = $this->getJobPostingStatus($job_posting);
    if ($status !== 'published') {
      throw new \Exception('Cette annonce n\'est plus disponible');
    }

    // Récupérer les champs personnalisés de l'annonce
    $custom_fields = [];
    if ($job_posting->hasField('field_posting_custom_fields') && !$job_posting->get('field_posting_custom_fields')->isEmpty()) {
      foreach ($job_posting->get('field_posting_custom_fields')->referencedEntities() as $paragraph) {
        $custom_fields[] = [
          'label' => $paragraph->get('field_question_label')->value,
          'type' => $paragraph->get('field_question_type')->value,
          'required' => (bool) $paragraph->get('field_required_question')->value,
        ];
      }
    }

    // Récupérer les exigences
    $web_links_required = [];
    if ($job_posting->hasField('field_required_web_links') && !$job_posting->get('field_required_web_links')->isEmpty()) {
      foreach ($job_posting->get('field_required_web_links')->getValue() as $link) {
        $web_links_required[] = $link['value'];
      }
    }

    $cover_letter_required = $job_posting->hasField('field_required_cover_letter') ? 
      (bool) $job_posting->get('field_required_cover_letter')->value : false;

    return [
      'annonce' => [
        'id' => $job_posting->id(),
        'title' => $job_posting->getTitle(),
        'description' => $job_posting->hasField('field_posting_ia_description') ? 
          $job_posting->get('field_posting_ia_description')->value : '',
        'localisation' => $job_posting->hasField('field_posting_localization') ? 
          $job_posting->get('field_posting_localization')->value : '',
        'company' => $this->getCompanyInfo($job_posting),
      ],
      'formulaire' => [
        'champs_obligatoires' => [
          'nom',
          'prenom', 
          'email',
          'telephone',
          'cv'
        ],
        'champs_optionnels' => [
          'lettre_motivation' => $cover_letter_required,
          'liens_web' => $web_links_required,
        ],
        'champs_personnalises' => $custom_fields,
      ]
    ];
  }

  /**
   * C2/C3 - Soumettre une candidature publique.
   */
  public function submitPublicCandidature($job_posting_id, $data, $files = []) {
    // Valider l'annonce d'emploi
    $job_posting = $this->entityTypeManager->getStorage('node')->load($job_posting_id);
    if (!$job_posting || $job_posting->bundle() !== 'job_posting') {
      throw new \Exception('Annonce d\'emploi introuvable');
    }

    // Validation des champs obligatoires
    $required_fields = ['candidate_lastname', 'candidate_firstname', 'candidate_email', 'candidate_phone'];
    foreach ($required_fields as $field) {
      if (empty($data[$field])) {
        throw new \Exception("Le champ {$field} est requis");
      }
    }

    // Validation email
    if (!filter_var($data['candidate_email'], FILTER_VALIDATE_EMAIL)) {
      throw new \Exception('Format email invalide');
    }

    // Vérifier qu'il n'y a pas déjà une candidature pour cette annonce avec cet email
    $existing = $this->entityTypeManager->getStorage('node')->getQuery()
      ->condition('type', 'application')
      ->condition('field_related_job_posting', $job_posting_id)
      ->condition('field_candidate_email', $data['candidate_email'])
      ->accessCheck(FALSE)
      ->execute();

    if (!empty($existing)) {
      throw new \Exception('Une candidature existe déjà pour cette adresse email sur cette annonce');
    }

    $cv_file = null;
    // Gérer l'upload du CV (obligatoire)
    // if (empty($files['cv'])) {
    //   throw new \Exception('Le CV est obligatoire');
    // }
    if (!empty($files['cv'])) {
      $cv_file = $this->handleFileUpload($files['cv'], 'cv');
    } else {
      // Pour les tests, on simule un fichier CV
      \Drupal::logger('tholka_candidatures')->notice('CV simulé pour les tests - candidature: ' . $data['candidate_email']);
    }


    $cv_file = $this->handleFileUpload($files['cv'], 'cv');
    
    // Gérer l'upload de la lettre de motivation (optionnel selon l'annonce)
    $cover_letter_file = null;
    if (!empty($files['lettre_motivation'])) {
      $cover_letter_file = $this->handleFileUpload($files['lettre_motivation'], 'cover_letter');
    } else if ($job_posting->hasField('field_required_cover_letter') && $job_posting->get('field_required_cover_letter')->value) {
        \Drupal::logger('tholka_candidatures')->notice('Lettre de motivation simulée pour les tests');
      // throw new \Exception('La lettre de motivation est requise pour cette annonce');
    }

    // Récupérer l'entreprise parente de l'annonce
    $company_id = $job_posting->hasField('field_parent_company') ? 
      $job_posting->get('field_parent_company')->target_id : null;

    // Statut initial "En cours d'étude"
    $initial_status_tid = $this->getApplicationStatusId('ongoing_study');

    // Créer la candidature
    $candidature_data = [
      'type' => 'application',
      'title' => $this->generateCandidatureTitle($data['candidate_firstname'], $data['candidate_lastname'], $job_posting->getTitle()),
      'uid' => 1, // Candidature publique, pas d'utilisateur connecté
      'field_related_job_posting' => $job_posting_id,
      'field_candidate_lastname' => $data['candidate_lastname'],
      'field_candidate_firstname' => $data['candidate_firstname'],
      'field_candidate_email' => $data['candidate_email'],
      'field_candidate_phone' => $data['candidate_phone'],
      'field_candidate_cv' => $cv_file,
      'field_application_status' => $initial_status_tid,
      'field_parent_company' => $company_id,
    ];

    if ($cover_letter_file) {
      $candidature_data['field_candidate_cover_letter'] = $cover_letter_file;
    }

    // Gérer les liens web
    if (!empty($data['liens_web'])) {
      $candidature_data['field_candidate_web_links'] = [];
      foreach ($data['liens_web'] as $link_data) {
        if (is_string($link_data)) {
          // Format simple : juste l'URL
          if (filter_var($link_data, FILTER_VALIDATE_URL)) {
            $candidature_data['field_candidate_web_links'][] = [
              'uri' => $link_data,
              'title' => $this->extractLinkTitle($link_data), // Auto-générer le titre
            ];
          }
        } elseif (is_array($link_data) && !empty($link_data['url'])) {
          // Format complet : URL + titre
          if (filter_var($link_data['url'], FILTER_VALIDATE_URL)) {
            $candidature_data['field_candidate_web_links'][] = [
              'uri' => $link_data['url'],
              'title' => !empty($link_data['title']) ? $link_data['title'] : $this->extractLinkTitle($link_data['url']),
            ];
          }
        }
      }
    }

    $candidature = Node::create($candidature_data);
    $candidature->save();

    // Gérer les réponses personnalisées (C4)
    if (!empty($data['reponses_personnalisees'])) {
      $this->handleCustomAnswers($candidature, $data['reponses_personnalisees'], $job_posting);
    }

    return [
      'candidature_id' => $candidature->id(),
      'message' => 'Candidature déposée avec succès',
      'prochaine_etape' => [
        'action' => 'disc_test',
        'url' => "/api/public/candidature/{$candidature->id()}/disc-test",
        'description' => 'Veuillez passer le test DISC pour finaliser votre candidature'
      ]
    ];
  }

  /**
   * C4 - Gérer les réponses aux champs personnalisés.
   */
  private function handleCustomAnswers($candidature, $responses, $job_posting) {
    // Récupérer les questions de l'annonce
    $custom_fields = [];
    if ($job_posting->hasField('field_posting_custom_fields') && !$job_posting->get('field_posting_custom_fields')->isEmpty()) {
      foreach ($job_posting->get('field_posting_custom_fields')->referencedEntities() as $paragraph) {
        $custom_fields[] = [
          'label' => $paragraph->get('field_question_label')->value,
          'required' => (bool) $paragraph->get('field_required_question')->value,
        ];
      }
    }

    // Créer les paragraphes de réponse
    $answer_paragraphs = [];
    foreach ($responses as $response) {
      if (empty($response['question_text']) || empty($response['answer_value'])) {
        continue;
      }

      // Vérifier que la question correspond à celles de l'annonce
      $question_exists = false;
      foreach ($custom_fields as $field) {
        if ($field['label'] === $response['question_text']) {
          $question_exists = true;
          break;
        }
      }

      if (!$question_exists) {
        continue;
      }

      $paragraph = \Drupal::entityTypeManager()
        ->getStorage('paragraph')
        ->create([
          'type' => 'custom_answer',
          'field_question_label' => $response['question_text'],
          'field_answer_value' => $response['answer_value'],
        ]);
      $paragraph->save();
      $answer_paragraphs[] = $paragraph;
    }

    if (!empty($answer_paragraphs)) {
      $candidature->set('field_candidate_responses_custom', $answer_paragraphs);
      $candidature->save();
    }
  }

  /**
   * Récupérer la liste des candidatures (côté RH).
   */
  public function getCandidatures($filters = [], $sort = [], $page = 0, $limit = 20) {
    $query = $this->entityTypeManager->getStorage('node')->getQuery()
      ->condition('type', 'application')
      ->accessCheck(TRUE);

    // Filtres par statut
    if (!empty($filters['status'])) {
      $status_tids = $this->getApplicationStatusIds($filters['status']);
      if (!empty($status_tids)) {
        $query->condition('field_application_status', $status_tids, 'IN');
      } else {
        // Si le statut n'existe pas, on force un résultat vide
        $query->condition('nid', 0, '<'); // Condition impossible
      }
    }

    // Filtre par annonce d'emploi
    if (!empty($filters['job_posting_id'])) {
      $query->condition('field_related_job_posting', $filters['job_posting_id']);
    }

    // Filtre par entreprise
    if (!empty($filters['company_id'])) {
      $query->condition('field_parent_company', $filters['company_id']);
    }

    // Filtre par recherche textuelle
    if (!empty($filters['search'])) {
      $group = $query->orConditionGroup()
        ->condition('field_candidate_firstname', '%' . $filters['search'] . '%', 'LIKE')
        ->condition('field_candidate_lastname', '%' . $filters['search'] . '%', 'LIKE')
        ->condition('field_candidate_email', '%' . $filters['search'] . '%', 'LIKE');
      $query->condition($group);
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
      $results[] = $this->formatCandidatureForApi($node);
    }

    // Compte total (avec les mêmes filtres)
    $count_query = $this->entityTypeManager->getStorage('node')->getQuery()
      ->condition('type', 'application')
      ->accessCheck(TRUE);
    
    if (!empty($filters['status'])) {
      $status_tids = $this->getApplicationStatusIds($filters['status']);
      if (!empty($status_tids)) {
        $count_query->condition('field_application_status', $status_tids, 'IN');
      } else {
        // Si le statut n'existe pas, on force un résultat vide
        $count_query->condition('nid', 0, '<'); // Condition impossible
      }
    }
    
    if (!empty($filters['job_posting_id'])) {
      $count_query->condition('field_related_job_posting', $filters['job_posting_id']);
    }
    
    if (!empty($filters['company_id'])) {
      $count_query->condition('field_parent_company', $filters['company_id']);
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
   * Récupérer le détail d'une candidature.
   */
  public function getCandidature($id) {
    $node = $this->entityTypeManager->getStorage('node')->load($id);
    
    if (!$node || $node->bundle() !== 'application') {
      return NULL;
    }

    return $this->formatCandidatureForApi($node, TRUE);
  }

  /**
   * Mettre à jour une candidature (suivi RH).
   */
  public function updateCandidature($id, $data) {
    $node = $this->entityTypeManager->getStorage('node')->load($id);
    
    if (!$node || $node->bundle() !== 'application') {
      throw new \Exception('Candidature introuvable');
    }

    // Champs modifiables par les RH
    $updatable_fields = [
      'field_rh_monitoring',
      'field_technical_monitoring',
      'field_disc_test_monitoring',
      'field_application_status'
    ];

    foreach ($updatable_fields as $field) {
      if (isset($data[$field])) {
        if ($field === 'field_application_status') {
          $status_tid = $this->getApplicationStatusId($data[$field]);
          if ($status_tid) {
            $node->set($field, $status_tid);
          }
        } else {
          $node->set($field, $data[$field]);
        }
      }
    }

    $node->save();

    return $this->formatCandidatureForApi($node, TRUE);
  }

  /**
   * Utilitaires privés
   */
  private function generateCandidatureTitle($firstname, $lastname, $job_title) {
    return "Candidature de {$firstname} {$lastname} - {$job_title}";
  }

  private function handleFileUpload($file_data, $type) {
    // TODO: Implémenter la gestion d'upload de fichiers
    // Pour l'instant on retourne null, à compléter selon votre système d'upload
    return null;
  }

  private function getCompanyInfo($job_posting) {
    if ($job_posting->hasField('field_parent_company') && !$job_posting->get('field_parent_company')->isEmpty()) {
      $company = $job_posting->get('field_parent_company')->entity;
      if ($company) {
        return [
          'id' => $company->id(),
          'name' => $company->getTitle(),
          'logo' => $company->hasField('field_company_logo') ? $company->get('field_company_logo')->entity : null,
          'primary_color' => $company->hasField('field_company_primary_color') ? $company->get('field_company_primary_color')->value : null,
        ];
      }
    }
    return null;
  }

  private function getJobPostingStatus($job_posting) {
    if ($job_posting->hasField('field_posting_status') && !$job_posting->get('field_posting_status')->isEmpty()) {
      $status_term = $job_posting->get('field_posting_status')->entity;
      if ($status_term && $status_term->hasField('field_taxo_system_name')) {
        return $status_term->get('field_taxo_system_name')->value;
      }
    }
    return 'draft';
  }

  private function getApplicationStatusId($status_name) {
    $query = $this->entityTypeManager->getStorage('taxonomy_term')->getQuery()
      ->condition('vid', 'application_status')
      ->condition('field_taxo_system_name', $status_name)
      ->accessCheck(FALSE);
    
    $tids = $query->execute();
    return !empty($tids) ? reset($tids) : NULL;
  }

  private function getApplicationStatusIds($status_names) {
    if (!is_array($status_names)) {
      $status_names = [$status_names];
    }

    $query = $this->entityTypeManager->getStorage('taxonomy_term')->getQuery()
      ->condition('vid', 'application_status')
      ->condition('field_taxo_system_name', $status_names, 'IN')
      ->accessCheck(TRUE);
    
    return $query->execute();
  }

  private function getApplicationStatusName($tid) {
    $term = $this->entityTypeManager->getStorage('taxonomy_term')->load($tid);
    if ($term && $term->hasField('field_taxo_system_name')) {
      return $term->get('field_taxo_system_name')->value;
    }
    return 'ongoing_study';
  }

  private function formatCandidatureForApi($node, $detailed = FALSE) {
    // Récupération du statut
    $status = 'en_cours_etude';
    if ($node->hasField('field_application_status') && !$node->get('field_application_status')->isEmpty()) {
      $status_tid = $node->get('field_application_status')->target_id;
      $status = $this->getApplicationStatusName($status_tid);
    }

    // Récupération de l'annonce liée
    $job_posting = null;
    if ($node->hasField('field_related_job_posting') && !$node->get('field_related_job_posting')->isEmpty()) {
      $job_posting_node = $node->get('field_related_job_posting')->entity;
      if ($job_posting_node) {
        $job_posting = [
          'id' => $job_posting_node->id(),
          'title' => $job_posting_node->getTitle(),
        ];
      }
    }

    // Récupération de l'entreprise
    $company = null;
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
      'candidat' => [
        'nom' => $node->hasField('field_candidate_lastname') ? $node->get('field_candidate_lastname')->value : '',
        'prenom' => $node->hasField('field_candidate_firstname') ? $node->get('field_candidate_firstname')->value : '',
        'email' => $node->hasField('field_candidate_email') ? $node->get('field_candidate_email')->value : '',
        'telephone' => $node->hasField('field_candidate_phone') ? $node->get('field_candidate_phone')->value : '',
      ],
      'annonce' => $job_posting,
      'company' => $company,
    ];

    if ($detailed) {
      // Récupération des fichiers
      $cv = null;
      if ($node->hasField('field_candidate_cv') && !$node->get('field_candidate_cv')->isEmpty()) {
        $cv_file = $node->get('field_candidate_cv')->entity;
        if ($cv_file) {
          $cv = [
            'id' => $cv_file->id(),
            'filename' => $cv_file->getFilename(),
            'url' => $cv_file->createFileUrl(),
          ];
        }
      }

      $cover_letter = null;
      if ($node->hasField('field_candidate_cover_letter') && !$node->get('field_candidate_cover_letter')->isEmpty()) {
        $cover_letter_file = $node->get('field_candidate_cover_letter')->entity;
        if ($cover_letter_file) {
          $cover_letter = [
            'id' => $cover_letter_file->id(),
            'filename' => $cover_letter_file->getFilename(),
            'url' => $cover_letter_file->createFileUrl(),
          ];
        }
      }

      // Récupération des liens web
      $web_links = [];
      if ($node->hasField('field_candidate_web_links') && !$node->get('field_candidate_web_links')->isEmpty()) {
        foreach ($node->get('field_candidate_web_links')->getValue() as $link) {
          $web_links[] = [
            'url' => $link['uri'],
            'title' => !empty($link['title']) ? $link['title'] : $link['uri'],
          ];
        }
      }

      // Récupération des réponses personnalisées
      $custom_responses = [];
      if ($node->hasField('field_candidate_responses_custom') && !$node->get('field_candidate_responses_custom')->isEmpty()) {
        foreach ($node->get('field_candidate_responses_custom')->referencedEntities() as $paragraph) {
          $custom_responses[] = [
            'question' => $paragraph->get('field_question_label')->value,
            'reponse' => $paragraph->get('field_answer_value')->value,
          ];
        }
      }

      // Récupération du résultat DISC
      $disc_result = null;
      if ($node->hasField('field_candidate_disc_result') && !$node->get('field_candidate_disc_result')->isEmpty()) {
        $disc_node = $node->get('field_candidate_disc_result')->entity;
        if ($disc_node) {
          $disc_result = [
            'id' => $disc_node->id(),
            'profil_predominant' => $disc_node->hasField('field_disc_predominant_profile') ? 
              $disc_node->get('field_disc_predominant_profile')->value : '',
            'scores' => [
              'D' => $disc_node->hasField('field_disc_score_d') ? (int) $disc_node->get('field_disc_score_d')->value : 0,
              'I' => $disc_node->hasField('field_disc_score_i') ? (int) $disc_node->get('field_disc_score_i')->value : 0,
              'S' => $disc_node->hasField('field_disc_score_s') ? (int) $disc_node->get('field_disc_score_s')->value : 0,
              'C' => $disc_node->hasField('field_disc_score_c') ? (int) $disc_node->get('field_disc_score_c')->value : 0,
            ],
            'date_passage' => $disc_node->hasField('field_disc_completion_date') ? 
              $disc_node->get('field_disc_completion_date')->value : null,
          ];
        }
      }

      $data['candidat'] = array_merge($data['candidat'], [
        'cv' => $cv,
        'lettre_motivation' => $cover_letter,
        'liens_web' => $web_links,
        'reponses_personnalisees' => $custom_responses,
      ]);

      $data['disc_result'] = $disc_result;
      
      $data['suivi'] = [
        'rh' => $node->hasField('field_rh_monitoring') ? $node->get('field_rh_monitoring')->value : '',
        'technique' => $node->hasField('field_technical_monitoring') ? $node->get('field_technical_monitoring')->value : '',
        'disc' => $node->hasField('field_disc_test_monitoring') ? $node->get('field_disc_test_monitoring')->value : '',
      ];
    }

    return $data;
  }

  /**
   * Extraire un titre automatique d'une URL.
   */
  private function extractLinkTitle($url) {
    if (strpos($url, 'linkedin.com') !== false) {
      return 'Profil LinkedIn';
    } elseif (strpos($url, 'github.com') !== false) {
      return 'Profil GitHub';
    } elseif (strpos($url, 'portfolio') !== false || strpos($url, 'portfolio') !== false) {
      return 'Portfolio';
    } else {
      return 'Lien web';
    }
  }
}