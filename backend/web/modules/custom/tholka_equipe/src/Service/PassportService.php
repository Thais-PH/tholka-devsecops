<?php

namespace Drupal\tholka_equipe\Service;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Service pour la gestion des passeports de compétences.
 */
class PassportService {

  protected $entityTypeManager;
  protected $currentUser;

  public function __construct(EntityTypeManagerInterface $entity_type_manager, AccountInterface $current_user) {
    $this->entityTypeManager = $entity_type_manager;
    $this->currentUser = $current_user;
  }

  /**
   * G1 - Récupérer le passeport de compétences d'un utilisateur.
   */
  public function getUserPassport($user_id, $include_salary = FALSE) {
    $user = $this->entityTypeManager->getStorage('user')->load($user_id);
    
    if (!$user || $user->id() == 0) {
      throw new \Exception('Utilisateur introuvable');
    }

    $passport = [
      'user' => $this->formatUserHeader($user),
      'technical_skills' => $this->getTechnicalSkills($user_id),
      'disc_profile' => $this->getDiscProfile($user),
      'wellbeing_barometer' => $this->getWellbeingBarometer($user_id),
      'training_history' => $this->getTrainingHistory($user_id),
    ];

    // Salaire visible uniquement pour RH
    if ($include_salary) {
      $passport['salary'] = $user->hasField('field_gross_annual_salary') ? 
        $user->get('field_gross_annual_salary')->value : null;
    }

    return $passport;
  }

  /**
   * G1 - Récupérer son propre passeport.
   */
  public function getMyPassport() {
    $current_user_id = $this->currentUser->id();
    return $this->getUserPassport($current_user_id, FALSE);
  }

  /**
   * G1 - Mettre à jour le salaire (RH uniquement).
   */
  public function updateSalary($user_id, $new_salary) {
    $user = $this->entityTypeManager->getStorage('user')->load($user_id);
    
    if (!$user || $user->id() == 0) {
      throw new \Exception('Utilisateur introuvable');
    }

    if (!is_numeric($new_salary) || $new_salary < 0) {
      throw new \Exception('Salaire invalide');
    }

    $user->set('field_gross_annual_salary', $new_salary);
    $user->save();

    return [
      'user_id' => $user_id,
      'new_salary' => $new_salary,
    ];
  }

  /**
   * Formater l'en-tête utilisateur du passeport.
   */
  private function formatUserHeader($user) {
    $header = [
      'id' => $user->id(),
      'firstname' => $user->hasField('field_firstname') ? $user->get('field_firstname')->value : '',
      'lastname' => $user->hasField('field_lastname') ? $user->get('field_lastname')->value : '',
      'effective_date' => $user->hasField('field_effective_date') ? $user->get('field_effective_date')->value : '',
      'initials' => $this->generateInitials($user),
    ];

    // Poste à partir de la fiche de poste
    if ($user->hasField('field_function') && !$user->get('field_function')->isEmpty()) {
      $job_sheet = $user->get('field_function')->entity;
      if ($job_sheet) {
        $header['function'] = $job_sheet->getTitle();
        $header['job_sheet_id'] = $job_sheet->id();
      }
    }

    // Photo de profil
    if ($user->hasField('field_profile_picture') && !$user->get('field_profile_picture')->isEmpty()) {
      $file = $user->get('field_profile_picture')->entity;
      if ($file) {
        $header['profile_picture'] = file_create_url($file->getFileUri());
      }
    }

    // Couleur de fond basée sur DISC
    $header['disc_background_color'] = $this->getDiscBackgroundColor($user);

    return $header;
  }

  /**
   * Récupérer les compétences techniques depuis la fiche de poste.
   */
  private function getTechnicalSkills($user_id) {
    $user = $this->entityTypeManager->getStorage('user')->load($user_id);
    
    // Récupérer les compétences depuis la fiche de poste
    // todo remplacer champ "poste" texte par lien avec fiche de poste
    if (!$user->hasField('field_job_sheet') || $user->get('field_job_sheet')->isEmpty()) {
      return [];
    }

    $job_sheet = $user->get('field_job_sheet')->entity;
    
    if (!$job_sheet || !$job_sheet->hasField('field_job_required_skills') || 
        $job_sheet->get('field_job_required_skills')->isEmpty()) {
      return [];
    }

    $skills = [];
    foreach ($job_sheet->get('field_job_required_skills')->referencedEntities() as $skill) {
      $skills[] = [
        'id' => $skill->id(),
        'name' => $skill->getName(),
        'acquired_from' => 'Fiche de poste : ' . $job_sheet->getTitle(),
      ];
    }

    return $skills;
  }

  /**
   * Récupérer le profil DISC.
   */
  private function getDiscProfile($user) {
    if (!$user->hasField('field_disc_profile') || $user->get('field_disc_profile')->isEmpty()) {
      return null;
    }

    $disc_profile = $user->get('field_disc_profile')->entity;
    
    if (!$disc_profile) {
      return null;
    }

    return [
      'id' => $disc_profile->id(),
      'title' => $disc_profile->getTitle(),
      'context' => $disc_profile->hasField('field_disc_context') ? 
        $disc_profile->get('field_disc_context')->value : '',
      'completion_date' => $disc_profile->hasField('field_disc_completion_date') ? 
        $disc_profile->get('field_disc_completion_date')->value : '',
      'scores' => [
        'd' => $disc_profile->hasField('field_disc_score_d') ? 
          $disc_profile->get('field_disc_score_d')->value : 0,
        'i' => $disc_profile->hasField('field_disc_score_i') ? 
          $disc_profile->get('field_disc_score_i')->value : 0,
        's' => $disc_profile->hasField('field_disc_score_s') ? 
          $disc_profile->get('field_disc_score_s')->value : 0,
        'c' => $disc_profile->hasField('field_disc_score_c') ? 
          $disc_profile->get('field_disc_score_c')->value : 0,
      ],
      'predominant_profile' => $disc_profile->hasField('field_disc_predominant_profile') ? 
        $disc_profile->get('field_disc_predominant_profile')->value : '',
    ];
  }

  /**
   * Récupérer le baromètre bien-être depuis les enquêtes internes.
   */
  private function getWellbeingBarometer($user_id) {
    // Récupérer les réponses aux enquêtes
    $query = $this->entityTypeManager->getStorage('node')->getQuery()
      ->condition('type', 'survey_response')
      ->condition('field_respondent_user', $user_id)
      ->accessCheck(FALSE)
      ->sort('created', 'DESC');
    
    $nids = $query->execute();
    $responses = $this->entityTypeManager->getStorage('node')->loadMultiple($nids);

    $barometer_data = [];
    $total_score = 0;
    $count = 0;

    foreach ($responses as $response) {
      // Analyser les réponses (survey_answers paragraphs)
      if ($response->hasField('field_survey_answers') && !$response->get('field_survey_answers')->isEmpty()) {
        foreach ($response->get('field_survey_answers')->referencedEntities() as $answer_paragraph) {
          // Récupérer la question référencée
          if ($answer_paragraph->hasField('field_survey_question') && 
              !$answer_paragraph->get('field_survey_question')->isEmpty()) {
            
            $question = $answer_paragraph->get('field_survey_question')->entity;
            
            // Vérifier si la question est incluse dans le baromètre
            if ($question && $question->hasField('field_include_in_barometer') && 
                $question->get('field_include_in_barometer')->value == 1) {
              
              // Récupérer la réponse
              if ($answer_paragraph->hasField('field_response_value')) {
                $response_value = $answer_paragraph->get('field_response_value')->value;
                
                // Convertir en score
                $score = $this->convertResponseToScore($response_value);
                
                if ($score !== null) {
                  $total_score += $score;
                  $count++;

                  $barometer_data[] = [
                    'question' => $question->getTitle(),
                    'response' => $response_value,
                    'score' => $score,
                    'date' => $response->getCreatedTime(),
                  ];
                }
              }
            }
          }
        }
      }
    }

    return [
      'average_score' => $count > 0 ? round($total_score / $count, 2) : null,
      'details' => $barometer_data,
    ];
  }

  /**
   * Convertir une réponse textuelle en score numérique.
   */
  private function convertResponseToScore($response_value) {
    $score_mapping = [
      'Très satisfait' => 100,
      'Satisfait' => 75,
      'Neutre' => 50,
      'Insatisfait' => 25,
      'Très insatisfait' => 0,
    ];

    return $score_mapping[$response_value] ?? null;
  }

  /**
   * Récupérer l'historique des formations.
   */
  private function getTrainingHistory($user_id) {
    // Récupérer tous les parcours de type "Formation"
    $query = $this->entityTypeManager->getStorage('node')->getQuery()
      ->condition('type', 'path')
      ->condition('field_path_type', 'formation')
      ->condition('field_path_assigned_users', $user_id)
      ->accessCheck(FALSE)
      ->sort('created', 'DESC');
    
    $nids = $query->execute();
    $paths = $this->entityTypeManager->getStorage('node')->loadMultiple($nids);

    $history = [];

    foreach ($paths as $path) {
      $status_term = null;
      if ($path->hasField('field_path_status') && !$path->get('field_path_status')->isEmpty()) {
        $status_term = $path->get('field_path_status')->entity;
      }

      $history[] = [
        'id' => $path->id(),
        'title' => $path->getTitle(),
        'status' => $status_term ? $status_term->getName() : 'Inconnu',
        'blocks_count' => count($path->get('field_path_blocks')->referencedEntities()),
        'description' => $path->get('field_path_description')->value ?? '',
      ];
    }

    return $history;
  }

  /**
   * Générer les initiales d'un utilisateur.
   */
  private function generateInitials($user) {
    $firstname = $user->hasField('field_firstname') ? $user->get('field_firstname')->value : '';
    $lastname = $user->hasField('field_lastname') ? $user->get('field_lastname')->value : '';

    $initials = '';
    if (!empty($firstname)) {
      $initials .= strtoupper(substr($firstname, 0, 1));
    }
    if (!empty($lastname)) {
      $initials .= strtoupper(substr($lastname, 0, 1));
    }

    return $initials ?: '??';
  }

  /**
   * Récupérer la couleur de fond basée sur le profil DISC.
   */
  private function getDiscBackgroundColor($user) {
    if (!$user->hasField('field_disc_profile') || $user->get('field_disc_profile')->isEmpty()) {
      return '#CCCCCC'; // Gris par défaut
    }

    $disc_profile = $user->get('field_disc_profile')->entity;
    
    if (!$disc_profile || !$disc_profile->hasField('field_disc_predominant_profile')) {
      return '#CCCCCC';
    }

    $predominant = $disc_profile->get('field_disc_predominant_profile')->value;

    // Couleurs DISC standards
    $colors = [
      'D' => '#FF0000', // Rouge (Dominance)
      'I' => '#FFFF00', // Jaune (Influence)
      'S' => '#00FF00', // Vert (Stabilité)
      'C' => '#0000FF', // Bleu (Conformité)
    ];

    return $colors[strtoupper($predominant)] ?? '#CCCCCC';
  }

  /**
   * Vérifier si l'utilisateur courant peut accéder au passeport.
   */
  public function canAccessPassport($target_user_id) {
    $current_user_id = $this->currentUser->id();
    $current_user = $this->entityTypeManager->getStorage('user')->load($current_user_id);
    $target_user = $this->entityTypeManager->getStorage('user')->load($target_user_id);

    // Accès à son propre passeport
    if ($current_user_id == $target_user_id) {
      return TRUE;
    }

    $roles = $current_user->getRoles();

    // RH : accès à tous les passeports de l'entreprise
    if (in_array('rh', $roles)) {
      $current_company = $current_user->hasField('field_parent_company') ? 
        $current_user->get('field_parent_company')->target_id : null;
      $target_company = $target_user->hasField('field_parent_company') ? 
        $target_user->get('field_parent_company')->target_id : null;

      return $current_company == $target_company;
    }

    // Manager : accès aux passeports de son équipe
    if (in_array('manager', $roles)) {
      $manager_id = $target_user->hasField('field_manager') ? 
        $target_user->get('field_manager')->target_id : null;

      return $manager_id == $current_user_id;
    }

    return FALSE;
  }

}