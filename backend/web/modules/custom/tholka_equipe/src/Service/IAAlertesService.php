<?php

namespace Drupal\tholka_equipe\Service;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use GuzzleHttp\ClientInterface;

/**
 * Service pour les alertes IA (G4).
 */
class IAAlertesService {

  protected $entityTypeManager;
  protected $httpClient;

  public function __construct(EntityTypeManagerInterface $entity_type_manager, ClientInterface $http_client) {
    $this->entityTypeManager = $entity_type_manager;
    $this->httpClient = $http_client;
  }

  /**
   * G4 - Récupérer les alertes IA pour un utilisateur.
   */
  public function getUserAlertes($user_id) {
    $user = $this->entityTypeManager->getStorage('user')->load($user_id);
    
    if (!$user || $user->id() == 0) {
      throw new \Exception('Utilisateur introuvable');
    }

    $alertes = [];

    // Alerte 1 : Rémunération inférieure au marché
    $salary_alert = $this->checkSalaryAlert($user);
    if ($salary_alert) {
      $alertes[] = $salary_alert;
    }

    // Alerte 2 : Risque de burnout
    $burnout_alert = $this->checkBurnoutAlert($user_id);
    if ($burnout_alert) {
      $alertes[] = $burnout_alert;
    }

    return [
      'user_id' => $user_id,
      'alertes' => $alertes,
      'count' => count($alertes),
    ];
  }

  /**
   * G4 - Vérifier si le salaire est inférieur au marché.
   */
  private function checkSalaryAlert($user) {
    if (!$user->hasField('field_gross_annual_salary') || $user->get('field_gross_annual_salary')->isEmpty()) {
      return null;
    }

    $current_salary = $user->get('field_gross_annual_salary')->value;

    $function = '';
    if ($user->hasField('field_function') && !$user->get('field_function')->isEmpty()) {
      $job_sheet = $user->get('field_function')->entity;
      if ($job_sheet) {
        $function = $job_sheet->getTitle();
      }
    }

    if (empty($function)) {
      return null;
    }

    // TODO : Appeler une API externe (INSEE ou autre) pour récupérer le salaire médian
    // Pour l'instant, on utilise une valeur simulée
    $market_salary = $this->getMarketSalary($function);

    if (!$market_salary) {
      return null;
    }

    // Alerte si le salaire est inférieur de plus de 10% au marché
    $threshold = $market_salary * 0.90;

    if ($current_salary < $threshold) {
      $percentage_below = round((($market_salary - $current_salary) / $market_salary) * 100, 1);
      
      return [
        'type' => 'salary_below_market',
        'severity' => 'warning',
        'title' => 'Rémunération inférieure au marché',
        'message' => sprintf(
          'Le salaire actuel (%.2f €) est %.1f%% inférieur au salaire médian du marché (%.2f €) pour le poste de %s.',
          $current_salary,
          $percentage_below,
          $market_salary,
          $function
        ),
        'data' => [
          'current_salary' => $current_salary,
          'market_salary' => $market_salary,
          'difference' => $market_salary - $current_salary,
          'percentage_below' => $percentage_below,
        ],
      ];
    }

    return null;
  }

  /**
   * G4 - Vérifier le risque de burnout.
   */
  private function checkBurnoutAlert($user_id) {
    $risk_score = 0;
    $factors = [];

    // Facteur 1 : Heures supplémentaires excessives (Module K)
    $overtime_score = $this->checkOvertimeHours($user_id);
    if ($overtime_score > 0) {
      $risk_score += $overtime_score;
      $factors[] = 'Heures supplémentaires importantes';
    }

    // Facteur 2 : Congés non pris (Module J)
    $vacation_score = $this->checkUnusedVacation($user_id);
    if ($vacation_score > 0) {
      $risk_score += $vacation_score;
      $factors[] = 'Congés non pris';
    }

    // Facteur 3 : Score bien-être faible (Enquêtes internes)
    $wellbeing_score = $this->checkWellbeingScore($user_id);
    if ($wellbeing_score > 0) {
      $risk_score += $wellbeing_score;
      $factors[] = 'Baromètre bien-être en baisse';
    }

    // Seuil d'alerte : 50 points sur 100
    if ($risk_score >= 50) {
      $severity = $risk_score >= 70 ? 'critical' : 'warning';
      
      return [
        'type' => 'burnout_risk',
        'severity' => $severity,
        'title' => 'Risque de burnout détecté',
        'message' => sprintf(
          'Le score de risque de burnout est de %d/100. Facteurs identifiés : %s.',
          $risk_score,
          implode(', ', $factors)
        ),
        'data' => [
          'risk_score' => $risk_score,
          'factors' => $factors,
          'recommendation' => 'Prévoir un entretien individuel et envisager des mesures de prévention.',
        ],
      ];
    }

    return null;
  }

  /**
   * Récupérer le salaire médian du marché pour un poste (simulé).
   */
  private function getMarketSalary($function) {
    // TODO : Remplacer par un vrai appel API (INSEE, LinkedIn Salary, etc.)
    // Pour l'instant, mapping statique
    $market_salaries = [
      'Développeuse Senior' => 55000,
      'Développeur Full Stack' => 48000,
      'Directeur Technique' => 80000,
      'Responsable RH' => 60000,
      'Chef de projet' => 50000,
    ];

    return $market_salaries[$function] ?? null;
  }

  /**
   * Vérifier les heures supplémentaires (Module K - à implémenter).
   */
  private function checkOvertimeHours($user_id) {
    // TODO : Implémenter après Module K
    // Pour l'instant, retourner 0
    
    // Logique attendue :
    // - Récupérer les heures sup des 3 derniers mois
    // - Si > 30h/mois en moyenne : +30 points
    // - Si > 50h/mois en moyenne : +50 points
    
    return 0;
  }

  /**
   * Vérifier les congés non pris (Module J - à implémenter).
   */
  private function checkUnusedVacation($user_id) {
    // TODO : Implémenter après Module J
    // Pour l'instant, retourner 0
    
    // Logique attendue :
    // - Récupérer le solde de congés
    // - Si > 15 jours non pris : +20 points
    // - Si > 25 jours non pris : +40 points
    
    return 0;
  }

  /**
   * Vérifier le score bien-être (Enquêtes internes).
   */
  private function checkWellbeingScore($user_id) {
    // Récupérer les réponses aux enquêtes
    $query = $this->entityTypeManager->getStorage('node')->getQuery()
      ->condition('type', 'survey_response')
      ->condition('field_respondent_user', $user_id)
      ->accessCheck(FALSE)
      ->sort('created', 'DESC')
      ->range(0, 5); // 5 dernières réponses
    
    $nids = $query->execute();
    $responses = $this->entityTypeManager->getStorage('node')->loadMultiple($nids);

    if (empty($responses)) {
      return 0;
    }

    $total_score = 0;
    $count = 0;

    // Analyser les réponses (survey_answers paragraphs)
    foreach ($responses as $response) {
      if ($response->hasField('field_survey_answers') && !$response->get('field_survey_answers')->isEmpty()) {
        foreach ($response->get('field_survey_answers')->referencedEntities() as $answer_paragraph) {
          // Récupérer la question référencée
          if ($answer_paragraph->hasField('field_survey_question') && 
              !$answer_paragraph->get('field_survey_question')->isEmpty()) {
            
            $question = $answer_paragraph->get('field_survey_question')->entity;
            
            // Vérifier si la question est incluse dans le baromètre
            if ($question && $question->hasField('field_include_in_barometer') && 
                $question->get('field_include_in_barometer')->value == 1) {
              
              // Récupérer le score de la réponse
              if ($answer_paragraph->hasField('field_response_value')) {
                $response_value = $answer_paragraph->get('field_response_value')->value;
                
                // Convertir la réponse en score (ex: "Très satisfait" = 100, "Pas du tout" = 0)
                $score = $this->convertResponseToScore($response_value);
                
                if ($score !== null) {
                  $total_score += $score;
                  $count++;
                }
              }
            }
          }
        }
      }
    }

    if ($count == 0) {
      return 0;
    }

    $average_score = $total_score / $count;

    // Si score moyen < 40% : +40 points
    // Si score moyen < 60% : +20 points
    if ($average_score < 40) {
      return 40;
    } elseif ($average_score < 60) {
      return 20;
    }

    return 0;
  }

  /**
   * Convertir une réponse textuelle en score numérique.
   */
  private function convertResponseToScore($response_value) {
    // Mapping des réponses aux scores (à adapter selon vos enquêtes)
    $score_mapping = [
      'Très satisfait' => 100,
      'Satisfait' => 75,
      'Neutre' => 50,
      'Insatisfait' => 25,
      'Très insatisfait' => 0,
    ];

    return $score_mapping[$response_value] ?? null;
  }
}