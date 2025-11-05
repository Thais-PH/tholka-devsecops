<?php

namespace Drupal\tholka_equipe\Service;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Service pour le tableau de bord personnalisé (G5).
 */
class DashboardService {

  protected $entityTypeManager;
  protected $currentUser;

  public function __construct(EntityTypeManagerInterface $entity_type_manager, AccountInterface $current_user) {
    $this->entityTypeManager = $entity_type_manager;
    $this->currentUser = $current_user;
  }

  /**
   * G5 - Récupérer le dashboard personnalisé selon le rôle.
   */
  public function getDashboard($view_as = null) {
    $current_user = $this->entityTypeManager->getStorage('user')->load($this->currentUser->id());
    $roles = $current_user->getRoles();

    // Déterminer le rôle effectif à afficher
    $effective_role = $this->determineEffectiveRole($roles, $view_as);

    $dashboard = [
      'user' => [
        'id' => $current_user->id(),
        'name' => $current_user->get('field_firstname')->value . ' ' . $current_user->get('field_lastname')->value,
        'role' => $effective_role,
        'available_views' => $this->getAvailableViews($roles),
      ],
      'widgets' => [],
    ];

    // Charger les widgets selon le rôle
    switch ($effective_role) {
      case 'rh':
        $dashboard['widgets'] = $this->getRHWidgets($current_user);
        break;
      
      case 'manager':
        $dashboard['widgets'] = $this->getManagerWidgets($current_user);
        break;
      
      case 'collaborateur':
      default:
        $dashboard['widgets'] = $this->getCollaborateurWidgets($current_user);
        break;
    }

    return $dashboard;
  }

  /**
   * Déterminer le rôle effectif à afficher.
   */
  private function determineEffectiveRole($roles, $view_as) {
    // Si view_as est spécifié et valide, l'utiliser
    if ($view_as && in_array($view_as, $roles)) {
      return $view_as;
    }

    // Sinon, utiliser le rôle le plus élevé
    if (in_array('rh', $roles)) {
      return 'rh';
    } elseif (in_array('manager', $roles)) {
      return 'manager';
    }

    return 'collaborateur';
  }

  /**
   * Récupérer les vues disponibles selon les rôles.
   */
  private function getAvailableViews($roles) {
    $views = ['collaborateur']; // Tous ont accès à la vue collaborateur

    if (in_array('manager', $roles)) {
      $views[] = 'manager';
    }

    if (in_array('rh', $roles)) {
      $views[] = 'rh';
    }

    return $views;
  }

  /**
   * G5 - Widgets pour le rôle Collaborateur.
   */
  private function getCollaborateurWidgets($user) {
    return [
      // Widget 1 : Mon profil DISC
      [
        'type' => 'disc_profile',
        'title' => 'Mon profil DISC',
        'data' => $this->getDiscProfileWidget($user),
      ],
      
      // Widget 2 : Mes formations en cours
      [
        'type' => 'ongoing_trainings',
        'title' => 'Mes formations en cours',
        'data' => $this->getOngoingTrainingsWidget($user->id()),
      ],
      
      // Widget 3 : Mes compétences récentes
      [
        'type' => 'recent_skills',
        'title' => 'Compétences récemment acquises',
        'data' => $this->getRecentSkillsWidget($user->id()),
      ],
      
      // Widget 4 : Solde de congés
      [
        'type' => 'vacation_balance',
        'title' => 'Solde de congés',
        'data' => $this->getVacationBalanceWidget($user->id()),
      ],
      
      // Widget 5 : Mes dernières demandes
      [
        'type' => 'recent_requests',
        'title' => 'Mes dernières demandes',
        'data' => $this->getRecentRequestsWidget($user->id()),
      ],
    ];
  }

  /**
   * G5 - Widgets pour le rôle Manager.
   */
  private function getManagerWidgets($user) {
    return [
      // Widget 1 : Effectif de mon équipe
      [
        'type' => 'team_overview',
        'title' => 'Mon équipe',
        'data' => $this->getTeamOverviewWidget($user->id()),
      ],
      
      // Widget 2 : Demandes en attente
      [
        'type' => 'pending_requests',
        'title' => 'Demandes en attente de validation',
        'data' => $this->getPendingRequestsWidget($user->id()),
      ],
      
      // Widget 3 : Alertes équipe
      [
        'type' => 'team_alerts',
        'title' => 'Alertes équipe',
        'data' => $this->getTeamAlertsWidget($user->id()),
      ],
      
      // Widget 4 : Formations en cours (équipe)
      [
        'type' => 'team_trainings',
        'title' => 'Formations de l\'équipe',
        'data' => $this->getTeamTrainingsWidget($user->id()),
      ],
      
      // Widget 5 : Répartition des profils DISC
      [
        'type' => 'team_disc_distribution',
        'title' => 'Répartition DISC de l\'équipe',
        'data' => $this->getTeamDiscDistributionWidget($user->id()),
      ],
    ];
  }

  /**
   * G5 - Widgets pour le rôle RH.
   */
  private function getRHWidgets($user) {
    $company_id = $user->hasField('field_parent_company') ? 
      $user->get('field_parent_company')->target_id : null;

    return [
      // Widget 1 : Vue d'ensemble entreprise
      [
        'type' => 'company_overview',
        'title' => 'Vue d\'ensemble entreprise',
        'data' => $this->getCompanyOverviewWidget($company_id),
      ],
      
      // Widget 2 : Candidatures récentes
      [
        'type' => 'recent_applications',
        'title' => 'Candidatures récentes',
        'data' => $this->getRecentApplicationsWidget($company_id),
      ],
      
      // Widget 3 : Alertes globales
      [
        'type' => 'global_alerts',
        'title' => 'Alertes RH',
        'data' => $this->getGlobalAlertsWidget($company_id),
      ],
      
      // Widget 4 : Formations en cours (entreprise)
      [
        'type' => 'company_trainings',
        'title' => 'Formations en cours',
        'data' => $this->getCompanyTrainingsWidget($company_id),
      ],
      
      // Widget 5 : Demandes en attente
      [
        'type' => 'all_pending_requests',
        'title' => 'Toutes les demandes en attente',
        'data' => $this->getAllPendingRequestsWidget($company_id),
      ],
      
      // Widget 6 : Répartition par département
      [
        'type' => 'department_distribution',
        'title' => 'Répartition par département',
        'data' => $this->getDepartmentDistributionWidget($company_id),
      ],
    ];
  }

  /**
   * Widget : Profil DISC.
   */
  private function getDiscProfileWidget($user) {
    if (!$user->hasField('field_disc_profile') || $user->get('field_disc_profile')->isEmpty()) {
      return [
        'has_profile' => false,
        'message' => 'Aucun profil DISC enregistré',
      ];
    }

    $disc_profile = $user->get('field_disc_profile')->entity;
    
    if (!$disc_profile) {
      return ['has_profile' => false];
    }

    return [
      'has_profile' => true,
      'predominant_profile' => $disc_profile->get('field_disc_predominant_profile')->value,
      'scores' => [
        'D' => $disc_profile->get('field_disc_score_d')->value,
        'I' => $disc_profile->get('field_disc_score_i')->value,
        'S' => $disc_profile->get('field_disc_score_s')->value,
        'C' => $disc_profile->get('field_disc_score_c')->value,
      ],
      'completion_date' => $disc_profile->get('field_disc_completion_date')->value,
    ];
  }

  /**
   * Widget : Formations en cours.
   */
  private function getOngoingTrainingsWidget($user_id) {
    $query = $this->entityTypeManager->getStorage('node')->getQuery()
      ->condition('type', 'path')
      ->condition('field_path_type', 'formation')
      ->condition('field_path_assigned_users', $user_id)
      ->condition('field_path_status', 'active')
      ->accessCheck(FALSE)
      ->range(0, 3);
    
    $nids = $query->execute();
    $paths = $this->entityTypeManager->getStorage('node')->loadMultiple($nids);

    $trainings = [];
    foreach ($paths as $path) {
      $trainings[] = [
        'id' => $path->id(),
        'title' => $path->getTitle(),
        'description' => $path->get('field_path_description')->value ?? '',
        'blocks_count' => count($path->get('field_path_blocks')->referencedEntities()),
      ];
    }

    return [
      'count' => count($trainings),
      'items' => $trainings,
    ];
  }

  /**
   * Widget : Compétences récemment acquises.
   */
  private function getRecentSkillsWidget($user_id) {
    $user = $this->entityTypeManager->getStorage('user')->load($user_id);
    
    if (!$user->hasField('field_job_sheet') || $user->get('field_job_sheet')->isEmpty()) {
      return ['count' => 0, 'items' => []];
    }

    $job_sheet = $user->get('field_job_sheet')->entity;
    
    if (!$job_sheet || !$job_sheet->hasField('field_job_required_skills') || $job_sheet->get('field_job_required_skills')->isEmpty()) {
      return ['count' => 0, 'items' => []];
    }

    $skills = [];
    foreach ($job_sheet->get('field_job_required_skills')->referencedEntities() as $skill) {
      $skills[] = [
        'name' => $skill->getName(),
        'from_job_sheet' => $job_sheet->getTitle(),
      ];
    }

    return [
      'count' => count($skills),
      'items' => array_slice($skills, 0, 5),
    ];
  }

  /**
   * Widget : Solde de congés (Module J - à implémenter).
   */
  private function getVacationBalanceWidget($user_id) {
    // TODO : Implémenter après Module J
    return [
      'available' => null,
      'used' => null,
      'pending' => null,
      'message' => 'Module Congés non encore implémenté',
    ];
  }

  /**
   * Widget : Dernières demandes.
   */
  private function getRecentRequestsWidget($user_id) {
    // TODO : Implémenter après Modules J & K
    return [
      'count' => 0,
      'items' => [],
      'message' => 'Modules Congés et Heures sup non encore implémentés',
    ];
  }

  /**
   * Widget : Vue d'ensemble de l'équipe (Manager).
   */
  private function getTeamOverviewWidget($manager_id) {
    $query = $this->entityTypeManager->getStorage('user')->getQuery()
      ->condition('status', 1)
      ->condition('field_manager', $manager_id)
      ->accessCheck(FALSE);
    
    $uids = $query->execute();
    $team_members = $this->entityTypeManager->getStorage('user')->loadMultiple($uids);

    return [
      'total_members' => count($team_members),
      'members' => array_map(function($user) {
        $function = '';
        if ($user->hasField('field_function') && !$user->get('field_function')->isEmpty()) {
          $job_sheet = $user->get('field_function')->entity;
          if ($job_sheet) {
            $function = $job_sheet->getTitle();
          }
        }
        
        return [
          'id' => $user->id(),
          'name' => $user->get('field_firstname')->value . ' ' . $user->get('field_lastname')->value,
          'function' => $function,
        ];
      }, $team_members),
    ];
  }

  /**
   * Widget : Demandes en attente (Manager).
   */
  private function getPendingRequestsWidget($manager_id) {
    // TODO : Implémenter après Modules J & K
    return [
      'count' => 0,
      'items' => [],
      'message' => 'Modules Congés et Heures sup non encore implémentés',
    ];
  }

  /**
   * Widget : Alertes équipe (Manager).
   */
  private function getTeamAlertsWidget($manager_id) {
    // Récupérer les membres de l'équipe
    $query = $this->entityTypeManager->getStorage('user')->getQuery()
      ->condition('status', 1)
      ->condition('field_manager', $manager_id)
      ->accessCheck(FALSE);
    
    $uids = $query->execute();

    $alerts = [];
    foreach ($uids as $uid) {
      // Vérifier les alertes pour chaque membre
      // TODO : Implémenter complètement après Modules J & K
      $alerts[] = [
        'user_id' => $uid,
        'type' => 'info',
        'message' => 'Alertes IA disponibles après implémentation complète',
      ];
    }

    return [
      'count' => 0,
      'items' => [],
    ];
  }

  /**
   * Widget : Formations de l'équipe (Manager).
   */
  private function getTeamTrainingsWidget($manager_id) {
    // Récupérer les membres de l'équipe
    $query = $this->entityTypeManager->getStorage('user')->getQuery()
      ->condition('status', 1)
      ->condition('field_manager', $manager_id)
      ->accessCheck(FALSE);
    
    $uids = $query->execute();

    if (empty($uids)) {
      return ['count' => 0, 'items' => []];
    }

    // Récupérer les formations en cours de l'équipe
    $path_query = $this->entityTypeManager->getStorage('node')->getQuery()
      ->condition('type', 'path')
      ->condition('field_path_type', 'formation')
      ->condition('field_path_assigned_users', array_values($uids), 'IN')
      ->condition('field_path_status', 'active')
      ->accessCheck(FALSE)
      ->range(0, 5);
    
    $nids = $path_query->execute();
    $paths = $this->entityTypeManager->getStorage('node')->loadMultiple($nids);

    $trainings = [];
    foreach ($paths as $path) {
      $assigned_users = $path->get('field_path_assigned_users')->referencedEntities();
      $user = !empty($assigned_users) ? $assigned_users[0] : null;
      
      $trainings[] = [
        'id' => $path->id(),
        'title' => $path->getTitle(),
        'user_name' => $user ? $user->get('field_firstname')->value . ' ' . $user->get('field_lastname')->value : 'Inconnu',
        'blocks_count' => count($path->get('field_path_blocks')->referencedEntities()),
      ];
    }

    return [
      'count' => count($trainings),
      'items' => $trainings,
    ];
  }

  /**
   * Widget : Répartition DISC de l'équipe (Manager).
   */
  private function getTeamDiscDistributionWidget($manager_id) {
    $query = $this->entityTypeManager->getStorage('user')->getQuery()
      ->condition('status', 1)
      ->condition('field_manager', $manager_id)
      ->accessCheck(FALSE);
    
    $uids = $query->execute();
    $team_members = $this->entityTypeManager->getStorage('user')->loadMultiple($uids);

    $distribution = ['D' => 0, 'I' => 0, 'S' => 0, 'C' => 0, 'Unknown' => 0];

    foreach ($team_members as $user) {
      if ($user->hasField('field_disc_profile') && !$user->get('field_disc_profile')->isEmpty()) {
        $disc_profile = $user->get('field_disc_profile')->entity;
        if ($disc_profile) {
          $predominant = strtoupper($disc_profile->get('field_disc_predominant_profile')->value);
          if (isset($distribution[$predominant])) {
            $distribution[$predominant]++;
          }
        }
      } else {
        $distribution['Unknown']++;
      }
    }

    return $distribution;
  }

  /**
   * Widget : Vue d'ensemble entreprise (RH).
   */
  private function getCompanyOverviewWidget($company_id) {
    if (!$company_id) {
      return ['error' => 'Entreprise non définie'];
    }

    $query = $this->entityTypeManager->getStorage('user')->getQuery()
      ->condition('status', 1)
      ->condition('field_parent_company', $company_id)
      ->accessCheck(FALSE);
    
    $uids = $query->execute();

    return [
      'total_employees' => count($uids),
      'active_jobs' => $this->countActiveJobs($company_id),
      'pending_applications' => $this->countPendingApplications($company_id),
    ];
  }

  /**
   * Widget : Candidatures récentes (RH).
   */
  private function getRecentApplicationsWidget($company_id) {
    $query = $this->entityTypeManager->getStorage('node')->getQuery()
      ->condition('type', 'application')
      ->accessCheck(FALSE)
      ->sort('created', 'DESC')
      ->range(0, 5);
    
    $nids = $query->execute();
    $applications = $this->entityTypeManager->getStorage('node')->loadMultiple($nids);

    $items = [];
    foreach ($applications as $application) {
      $job = $application->get('field_job_posting')->entity;
      
      if ($job && $job->get('field_parent_company')->target_id == $company_id) {
        $items[] = [
          'id' => $application->id(),
          'candidate_name' => $application->get('field_candidate_name')->value,
          'job_title' => $job->getTitle(),
          'created' => $application->getCreatedTime(),
        ];
      }
    }

    return [
      'count' => count($items),
      'items' => $items,
    ];
  }

  /**
   * Widget : Alertes globales (RH).
   */
  private function getGlobalAlertsWidget($company_id) {
    // TODO : Implémenter complètement après tous les modules
    return [
      'count' => 0,
      'items' => [],
    ];
  }

  /**
   * Widget : Formations entreprise (RH).
   */
  private function getCompanyTrainingsWidget($company_id) {
    // Récupérer tous les utilisateurs de l'entreprise
    $user_query = $this->entityTypeManager->getStorage('user')->getQuery()
      ->condition('status', 1)
      ->condition('field_parent_company', $company_id)
      ->accessCheck(FALSE);
    
    $uids = $user_query->execute();

    if (empty($uids)) {
      return ['count' => 0, 'total_in_progress' => 0];
    }

    $path_query = $this->entityTypeManager->getStorage('node')->getQuery()
      ->condition('type', 'path')
      ->condition('field_path_type', 'formation')
      ->condition('field_path_assigned_users', array_values($uids), 'IN')
      ->condition('field_path_status', 'active')
      ->accessCheck(FALSE);
    
    $count = $path_query->count()->execute();

    return [
      'count' => $count,
      'total_in_progress' => $count,
    ];
  }

  /**
   * Widget : Toutes les demandes en attente (RH).
   */
  private function getAllPendingRequestsWidget($company_id) {
    // TODO : Implémenter après Modules J & K
    return [
      'count' => 0,
      'items' => [],
    ];
  }

  /**
   * Widget : Répartition par département (RH).
   */
  private function getDepartmentDistributionWidget($company_id) {
    $query = $this->entityTypeManager->getStorage('user')->getQuery()
      ->condition('status', 1)
      ->condition('field_parent_company', $company_id)
      ->accessCheck(FALSE);
    
    $uids = $query->execute();
    $users = $this->entityTypeManager->getStorage('user')->loadMultiple($uids);

    $distribution = [];

    foreach ($users as $user) {
      if ($user->hasField('field_department') && !$user->get('field_department')->isEmpty()) {
        $department = $user->get('field_department')->entity;
        if ($department) {
          $dept_name = $department->getName();
          if (!isset($distribution[$dept_name])) {
            $distribution[$dept_name] = 0;
          }
          $distribution[$dept_name]++;
        }
      } else {
        if (!isset($distribution['Sans département'])) {
          $distribution['Sans département'] = 0;
        }
        $distribution['Sans département']++;
      }
    }

    return $distribution;
  }

  /**
   * Compter les offres actives.
   */
  private function countActiveJobs($company_id) {
    $query = $this->entityTypeManager->getStorage('node')->getQuery()
      ->condition('type', 'job_posting')
      ->condition('field_parent_company', $company_id)
      ->condition('field_posting_status', 'published')
      ->accessCheck(FALSE);
    
    return $query->count()->execute();
  }

  /**
   * Compter les candidatures en attente.
   */
  private function countPendingApplications($company_id) {
    $query = $this->entityTypeManager->getStorage('node')->getQuery()
      ->condition('type', 'application')
      ->condition('field_application_status', 'pending')
      ->accessCheck(FALSE);
    
    $nids = $query->execute();
    $applications = $this->entityTypeManager->getStorage('node')->loadMultiple($nids);

    $count = 0;
    foreach ($applications as $application) {
      $job = $application->get('field_job_posting')->entity;
      if ($job && $job->get('field_parent_company')->target_id == $company_id) {
        $count++;
      }
    }

    return $count;
  }
}