<?php

namespace Drupal\tholka_equipe\Service;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Service pour la gestion de l'organigramme.
 */
class OrganigrammeService {

  protected $entityTypeManager;
  protected $currentUser;

  public function __construct(EntityTypeManagerInterface $entity_type_manager, AccountInterface $current_user) {
    $this->entityTypeManager = $entity_type_manager;
    $this->currentUser = $current_user;
  }

  /**
   * G2 & G3 - Récupérer l'organigramme avec filtres.
   */
  public function getOrganigramme($filters = [], $view_type = 'hierarchical') {
    $current_user = $this->entityTypeManager->getStorage('user')->load($this->currentUser->id());
    // var_dump($current_user);
    // Récupérer l'entreprise de l'utilisateur connecté
    $company_id = $current_user->hasField('field_parent_company') ? 
      $current_user->get('field_parent_company')->target_id : null;

    if (!$company_id) {
      throw new \Exception('Entreprise parente introuvable pour l\'utilisateur connecté');
    }

    // Récupérer tous les utilisateurs de l'entreprise
    $query = $this->entityTypeManager->getStorage('user')->getQuery()
      ->condition('status', 1)
      ->condition('uid', 0, '>')
      ->condition('uid', 1, '!=')
      ->condition('field_parent_company', $company_id)
      ->accessCheck(FALSE);

    // Filtres
    if (!empty($filters['department_id'])) {
      $query->condition('field_department', $filters['department_id']);
    }

    if (!empty($filters['disc_profile'])) {
      // Filtrer par profil DISC prédominant
      $disc_query = $this->entityTypeManager->getStorage('node')->getQuery()
        ->condition('type', 'disc_result')
        ->condition('field_disc_predominant_profile', strtoupper($filters['disc_profile']))
        ->accessCheck(FALSE);
      
      $disc_nids = $disc_query->execute();
      
      if (!empty($disc_nids)) {
        $query->condition('field_disc_profile', array_values($disc_nids), 'IN');
      } else {
        $query->condition('uid', 0, '<'); // Aucun résultat
      }
    }

    if (!empty($filters['function'])) {
      // Récupérer les IDs des fiches de poste correspondantes
      $job_query = $this->entityTypeManager->getStorage('node')->getQuery()
        ->condition('type', 'job_description')
        ->condition('title', '%' . $filters['function'] . '%', 'LIKE')
        ->accessCheck(FALSE);
      
      $job_nids = $job_query->execute();
      
      if (!empty($job_nids)) {
        $query->condition('field_function', array_values($job_nids), 'IN');
      } else {
        $query->condition('uid', 0, '<'); // Aucun résultat
      }
    }

    if (!empty($filters['manager_id'])) {
      $query->condition('field_manager', $filters['manager_id']);
    }

    $query->sort('field_lastname', 'ASC');

    $uids = $query->execute();
    $users = $this->entityTypeManager->getStorage('user')->loadMultiple($uids);

    // Construire l'organigramme selon le type de vue
    if ($view_type === 'hierarchical') {
      return $this->buildHierarchicalView($users);
    } else {
      return $this->buildDepartmentView($users);
    }
  }

  /**
   * G2 - Construire la vue hiérarchique (par manager).
   */
  private function buildHierarchicalView($users) {
    $hierarchy = [];
    $user_map = [];

    // Première passe : créer un map de tous les utilisateurs
    foreach ($users as $user) {
      $user_data = $this->formatUserForOrganigramme($user);
      $user_map[$user->id()] = $user_data;
      $user_map[$user->id()]['children'] = [];
    }

    // Deuxième passe : construire l'arbre hiérarchique
    foreach ($users as $user) {
      $manager_id = $user->hasField('field_manager') && !$user->get('field_manager')->isEmpty() ? 
        $user->get('field_manager')->target_id : null;

      if ($manager_id && isset($user_map[$manager_id])) {
        // Ajouter l'utilisateur comme enfant de son manager
        $user_map[$manager_id]['children'][] = &$user_map[$user->id()];
      } else {
        // Pas de manager = racine de l'organigramme
        $hierarchy[] = &$user_map[$user->id()];
      }
    }

    return [
      'view_type' => 'hierarchical',
      'data' => $hierarchy,
    ];
  }

  /**
   * G2 - Construire la vue par département.
   */
  private function buildDepartmentView($users) {
    $departments = [];

    foreach ($users as $user) {
      $department_id = $user->hasField('field_department') && !$user->get('field_department')->isEmpty() ? 
        $user->get('field_department')->target_id : null;

      $department_name = 'Sans département';
      
      if ($department_id) {
        $department = $this->entityTypeManager->getStorage('taxonomy_term')->load($department_id);
        if ($department) {
          $department_name = $department->getName();
        }
      }

      if (!isset($departments[$department_name])) {
        $departments[$department_name] = [
          'department_id' => $department_id,
          'department_name' => $department_name,
          'members' => [],
        ];
      }

      $departments[$department_name]['members'][] = $this->formatUserForOrganigramme($user);
    }

    return [
      'view_type' => 'department',
      'data' => array_values($departments),
    ];
  }

  /**
   * Formater un utilisateur pour l'organigramme.
   */
  private function formatUserForOrganigramme($user) {
    $data = [
      'id' => $user->id(),
      'firstname' => $user->hasField('field_firstname') ? $user->get('field_firstname')->value : '',
      'lastname' => $user->hasField('field_lastname') ? $user->get('field_lastname')->value : '',
      'initials' => $this->generateInitials($user),
      'disc_background_color' => $this->getDiscBackgroundColor($user),
    ];

    // Poste à partir de la fiche de poste
    if ($user->hasField('field_function') && !$user->get('field_function')->isEmpty()) {
      $job_sheet = $user->get('field_function')->entity;
      if ($job_sheet) {
        $data['function'] = $job_sheet->getTitle();
        $data['job_sheet_id'] = $job_sheet->id();
      }
    }

    // Photo de profil
    if ($user->hasField('field_profile_picture') && !$user->get('field_profile_picture')->isEmpty()) {
      $file = $user->get('field_profile_picture')->entity;
      if ($file) {
        $data['profile_picture'] = file_create_url($file->getFileUri());
      }
    }

    // Département
    if ($user->hasField('field_department') && !$user->get('field_department')->isEmpty()) {
      $department = $user->get('field_department')->entity;
      if ($department) {
        $data['department'] = [
          'id' => $department->id(),
          'name' => $department->getName(),
        ];
      }
    }

    // Manager
    if ($user->hasField('field_manager') && !$user->get('field_manager')->isEmpty()) {
      $manager = $user->get('field_manager')->entity;
      if ($manager) {
        $data['manager_id'] = $manager->id();
        $data['manager_name'] = $manager->get('field_firstname')->value . ' ' . $manager->get('field_lastname')->value;
      }
    }

    return $data;
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
      return '#CCCCCC';
    }

    $disc_profile = $user->get('field_disc_profile')->entity;
    
    if (!$disc_profile || !$disc_profile->hasField('field_disc_predominant_profile')) {
      return '#CCCCCC';
    }

    $predominant = $disc_profile->get('field_disc_predominant_profile')->value;

    $colors = [
      'D' => '#FF0000',
      'I' => '#FFFF00',
      'S' => '#00FF00',
      'C' => '#0000FF',
    ];

    return $colors[strtoupper($predominant)] ?? '#CCCCCC';
  }

  /**
   * Récupérer les départements disponibles pour l'entreprise.
   */
  public function getDepartmentsForCurrentCompany() {
    $current_user = $this->entityTypeManager->getStorage('user')->load($this->currentUser->id());
    
    $company_id = $current_user->hasField('field_parent_company') ? 
      $current_user->get('field_parent_company')->target_id : null;

    if (!$company_id) {
      return [];
    }

    $query = $this->entityTypeManager->getStorage('taxonomy_term')->getQuery()
      ->condition('vid', 'departments')
      ->condition('field_parent_company', $company_id)
      ->accessCheck(FALSE)
      ->sort('name');
    
    $tids = $query->execute();
    $terms = $this->entityTypeManager->getStorage('taxonomy_term')->loadMultiple($tids);
    
    $departments = [];
    foreach ($terms as $term) {
      $departments[] = [
        'id' => $term->id(),
        'name' => $term->getName(),
      ];
    }

    return $departments;
  }

  /**
   * G3 - Récupérer la liste des départements avec nombre de membres.
   */
  public function getDepartments() {
    $current_user = $this->entityTypeManager->getStorage('user')->load($this->currentUser->id());
    
    // Récupérer l'entreprise
    $company_id = $current_user->hasField('field_parent_company') ? 
      $current_user->get('field_parent_company')->target_id : null;

    if (!$company_id) {
      throw new \Exception('Entreprise parente introuvable');
    }

    // Récupérer tous les utilisateurs de l'entreprise
    $query = $this->entityTypeManager->getStorage('user')->getQuery()
      ->condition('status', 1)
      ->condition('uid', 0, '>')
      ->condition('uid', 1, '!=')
      ->condition('field_parent_company', $company_id)
      ->accessCheck(FALSE);
    
    $uids = $query->execute();
    $users = $this->entityTypeManager->getStorage('user')->loadMultiple($uids);

    // Grouper par département
    $departments = [];
    foreach ($users as $user) {
      if ($user->hasField('field_department') && !$user->get('field_department')->isEmpty()) {
        $dept = $user->get('field_department')->entity;
        
        if ($dept) {
          $dept_id = $dept->id();
          
          if (!isset($departments[$dept_id])) {
            $departments[$dept_id] = [
              'id' => $dept_id,
              'name' => $dept->getName(),
              'count' => 0,
            ];
          }
          
          $departments[$dept_id]['count']++;
        }
      }
    }

    // Trier par nom
    usort($departments, function($a, $b) {
      return strcmp($a['name'], $b['name']);
    });

    return array_values($departments);
  }
}