<?php

namespace Drupal\tholka_comptes\Service;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Password\PasswordGeneratorInterface;
use Drupal\Core\File\FileSystemInterface;
use Drupal\user\Entity\User;
use Drupal\paragraphs\Entity\Paragraph;

/**
 * Service pour la gestion des comptes utilisateurs.
 */
class ComptesService {

  protected $entityTypeManager;
  protected $currentUser;
  protected $passwordGenerator;
  protected $fileSystem;

  public function __construct(EntityTypeManagerInterface $entity_type_manager, AccountInterface $current_user, PasswordGeneratorInterface $password_generator, FileSystemInterface $file_system) {
    $this->entityTypeManager = $entity_type_manager;
    $this->currentUser = $current_user;
    $this->passwordGenerator = $password_generator;
    $this->fileSystem = $file_system;
  }

  /**
   * L1 & L6 - Récupérer la liste des comptes avec filtres.
   */
  public function getComptes($filters = [], $sort = [], $page = 0, $limit = 20) {
    $query = $this->entityTypeManager->getStorage('user')->getQuery()
      ->condition('status', 1) // Seulement les comptes actifs par défaut
      ->condition('uid', 0, '>') // Exclure anonyme ET admin
      ->condition('uid', 1, '!=') // Exclure explicitement le compte admin
      ->accessCheck(FALSE); // Pas de contrainte pour les tests locaux

    // Filtre par statut (actif/inactif)
    if (isset($filters['status'])) {
      $query->condition('status', (int) $filters['status']);
    }

    // Filtre par rôle
    if (!empty($filters['role'])) {
      $query->condition('roles', $filters['role']);
    }

    // Filtre par entreprise
    if (!empty($filters['company_id'])) {
      $query->condition('field_parent_company', $filters['company_id']);
    }

    // Filtre par équipe/département
    if (!empty($filters['department_id'])) {
      $query->condition('field_department', $filters['department_id']);
    }

    // Recherche textuelle
    if (!empty($filters['search'])) {
      $job_query = $this->entityTypeManager->getStorage('node')->getQuery()
        ->condition('type', 'job_description')
        ->condition('title', '%' . $filters['search'] . '%', 'LIKE')
        ->accessCheck(FALSE);

      $job_nids = $job_query->execute();

      $group = $query->orConditionGroup()
        ->condition('field_firstname', '%' . $filters['search'] . '%', 'LIKE')
        ->condition('field_lastname', '%' . $filters['search'] . '%', 'LIKE')
        ->condition('mail', '%' . $filters['search'] . '%', 'LIKE');

      if (!empty($job_nids)) {
        $group->condition('field_function', array_values($job_nids), 'IN');
      }

      $query->condition($group);
    }

    // Tri
    if (!empty($sort['field']) && !empty($sort['direction'])) {
      $direction = strtoupper($sort['direction']) === 'DESC' ? 'DESC' : 'ASC';
      
      switch ($sort['field']) {
        case 'lastname':
          $query->sort('field_lastname', $direction);
          break;
        case 'firstname':
          $query->sort('field_firstname', $direction);
          break;
        case 'email':
          $query->sort('mail', $direction);
          break;
        case 'created':
          $query->sort('created', $direction);
          break;
        // Todo : à implémenter plus tard si besoin avec ref entity
        // case 'function':
        //   $query->sort('field_function', $direction);
        //   break;
        default:
          $query->sort('field_lastname', 'ASC');
      }
    } else {
      $query->sort('field_lastname', 'ASC');
    }

    // Pagination
    $query->range($page * $limit, $limit);

    $uids = $query->execute();
    $users = $this->entityTypeManager->getStorage('user')->loadMultiple($uids);

    $results = [];
    foreach ($users as $user) {
      $results[] = $this->formatUserForApi($user);
    }

    // Count query avec mêmes filtres
    $count_query = $this->entityTypeManager->getStorage('user')->getQuery()
      ->condition('status', 1)
      ->condition('uid', 0, '>')
      ->condition('uid', 1, '!=')
      ->accessCheck(FALSE);

    // Appliquer les mêmes filtres pour le count
    if (isset($filters['status'])) {
      $count_query->condition('status', (int) $filters['status']);
    }
    if (!empty($filters['role'])) {
      $count_query->condition('roles', $filters['role']);
    }
    if (!empty($filters['company_id'])) {
      $count_query->condition('field_parent_company', $filters['company_id']);
    }
    if (!empty($filters['department_id'])) {
      $count_query->condition('field_department', $filters['department_id']);
    }
    if (!empty($filters['search'])) {
      $group = $count_query->orConditionGroup()
        ->condition('field_firstname', '%' . $filters['search'] . '%', 'LIKE')
        ->condition('field_lastname', '%' . $filters['search'] . '%', 'LIKE')
        ->condition('mail', '%' . $filters['search'] . '%', 'LIKE')
        ->condition('field_function', '%' . $filters['search'] . '%', 'LIKE');
      $count_query->condition($group);
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
   * L2 - Récupérer un compte par ID.
   */
  public function getCompte($id) {
    $user = $this->entityTypeManager->getStorage('user')->load($id);
    
    if (!$user || $user->id() == 0) {
      throw new \Exception('Compte utilisateur introuvable');
    }

    return $this->formatUserForApi($user, TRUE);
  }

  /**
   * L3 - Créer un nouveau compte utilisateur.
   */
  public function createCompte($data) {
    // Validation des données requises
    if (empty($data['firstname'])) {
      throw new \Exception('Le prénom est requis');
    }

    if (empty($data['lastname'])) {
      throw new \Exception('Le nom est requis');
    }

    if (empty($data['email'])) {
      throw new \Exception('L\'email est requis');
    }

    if (empty($data['username'])) {
      throw new \Exception('Le nom d\'utilisateur est requis');
    }

    if (empty($data['company_id'])) {
      throw new \Exception('L\'entreprise parente est requise');
    }

    // Vérifier unicité email et username
    if ($this->emailExists($data['email'])) {
      throw new \Exception('Cet email est déjà utilisé');
    }

    if ($this->usernameExists($data['username'])) {
      throw new \Exception('Ce nom d\'utilisateur est déjà utilisé');
    }

    // Générer mot de passe si non fourni
    $password = !empty($data['password']) ? $data['password'] : $this->passwordGenerator->generate(12);

    // Créer l'utilisateur
    $user_data = [
      'name' => $data['username'],
      'mail' => $data['email'],
      'pass' => $password,
      'status' => 1,
      'field_firstname' => $data['firstname'],
      'field_lastname' => $data['lastname'],
      'field_parent_company' => $data['company_id'],
    ];

    // Champs optionnels
    if (!empty($data['phone'])) {
      $user_data['field_phone'] = $data['phone'];
    }

    if (!empty($data['job_sheet_id'])) {
      $user_data['field_function'] = $data['job_sheet_id'];
    }

    if (!empty($data['effective_date'])) {
      $user_data['field_effective_date'] = $data['effective_date'];
    }

    if (!empty($data['gross_annual_salary'])) {
      $user_data['field_gross_annual_salary'] = $data['gross_annual_salary'];
    }

    if (!empty($data['department_id'])) {
      $user_data['field_department'] = $data['department_id'];
    }

    if (!empty($data['manager_id'])) {
      $user_data['field_manager'] = $data['manager_id'];
    }

    // Créer l'adresse si fournie
    if (!empty($data['address'])) {
      $address_paragraph = $this->createAddressParagraph($data['address']);
      if ($address_paragraph) {
        $user_data['field_address'] = [
          'target_id' => $address_paragraph->id(),
          'target_revision_id' => $address_paragraph->getRevisionId(),
        ];
      }
    }

    $user = User::create($user_data);

    // Assigner les rôles (par défaut : authenticated)
    if (!empty($data['roles'])) {
      foreach ($data['roles'] as $role) {
        $user->addRole($role);
      }
    }

    $user->save();

    $result = $this->formatUserForApi($user, TRUE);
    $result['generated_password'] = $password; // Pour notifier l'utilisateur

    return $result;
  }

  /**
   * L4 - Modifier un compte utilisateur.
   */
  public function updateCompte($id, $data) {
    $user = $this->entityTypeManager->getStorage('user')->load($id);
    
    if (!$user || $user->id() == 0) {
      throw new \Exception('Compte utilisateur introuvable');
    }

    // Mise à jour des champs modifiables
    if (isset($data['firstname'])) {
      $user->set('field_firstname', $data['firstname']);
    }

    if (isset($data['lastname'])) {
      $user->set('field_lastname', $data['lastname']);
    }

    if (isset($data['email'])) {
      // Vérifier unicité
      if ($data['email'] !== $user->getEmail() && $this->emailExists($data['email'])) {
        throw new \Exception('Cet email est déjà utilisé');
      }
      $user->set('mail', $data['email']);
    }

    if (isset($data['username'])) {
      // Vérifier unicité
      if ($data['username'] !== $user->getAccountName() && $this->usernameExists($data['username'])) {
        throw new \Exception('Ce nom d\'utilisateur est déjà utilisé');
      }
      $user->set('name', $data['username']);
    }

    if (isset($data['phone'])) {
      $user->set('field_phone', $data['phone']);
    }

    if (isset($data['job_sheet_id'])) {
      $user->set('field_function', $data['job_sheet_id']);
    }

    if (isset($data['effective_date'])) {
      $user->set('field_effective_date', $data['effective_date']);
    }

    if (isset($data['gross_annual_salary'])) {
      $user->set('field_gross_annual_salary', $data['gross_annual_salary']);
    }

    if (isset($data['company_id'])) {
      $user->set('field_parent_company', $data['company_id']);
    }

    if (isset($data['department_id'])) {
      $user->set('field_department', $data['department_id']);
    }

    if (isset($data['manager_id'])) {
      $user->set('field_manager', $data['manager_id']);
    }

    if (isset($data['status'])) {
      $user->set('status', (int) $data['status']);
    }

    // Mettre à jour l'adresse
    if (isset($data['address'])) {
      // Supprimer l'ancienne adresse
      if ($user->hasField('field_address') && !$user->get('field_address')->isEmpty()) {
        $old_address = $user->get('field_address')->entity;
        if ($old_address) {
          $old_address->delete();
        }
      }

      // Créer la nouvelle adresse
      if (!empty($data['address'])) {
        $address_paragraph = $this->createAddressParagraph($data['address']);
        if ($address_paragraph) {
          $user->set('field_address', [
            'target_id' => $address_paragraph->id(),
            'target_revision_id' => $address_paragraph->getRevisionId(),
          ]);
        }
      } else {
        $user->set('field_address', NULL);
      }
    }

    // Gestion des rôles
    if (isset($data['roles'])) {
      // Supprimer tous les rôles sauf authenticated
      $current_roles = $user->getRoles(TRUE); // Exclure authenticated
      foreach ($current_roles as $role) {
        $user->removeRole($role);
      }

      // Ajouter les nouveaux rôles
      foreach ($data['roles'] as $role) {
        $user->addRole($role);
      }
    }

    $user->save();

    return $this->formatUserForApi($user, TRUE);
  }

  /**
   * L5 - Supprimer un compte utilisateur.
   */
  public function deleteCompte($id) {
    $user = $this->entityTypeManager->getStorage('user')->load($id);
    
    if (!$user || $user->id() == 0) {
      throw new \Exception('Compte utilisateur introuvable');
    }

    // Supprimer l'adresse associée
    if ($user->hasField('field_address') && !$user->get('field_address')->isEmpty()) {
      $address = $user->get('field_address')->entity;
      if ($address) {
        $address->delete();
      }
    }

    // Supprimer l'utilisateur
    $user->delete();

    return TRUE;
  }

  /**
   * L7 - Récupérer le profil de l'utilisateur connecté.
   */
  public function getMyProfile() {
    $current_user_id = $this->currentUser->id();
    return $this->getCompte($current_user_id);
  }

  /**
   * L7 - Modifier le profil de l'utilisateur connecté.
   */
  public function updateMyProfile($data) {
    $current_user_id = $this->currentUser->id();
    
    // Filtrer les données pour n'autoriser que certains champs
    $allowed_fields = [
      'firstname', 'lastname', 'phone', 'address', 'profile_picture'
    ];
    
    $filtered_data = array_intersect_key($data, array_flip($allowed_fields));
    
    return $this->updateCompte($current_user_id, $filtered_data);
  }

  /**
   * Formater un utilisateur pour l'API.
   */
  private function formatUserForApi($user, $detailed = FALSE) {
    $data = [
      'id' => $user->id(),
      'username' => $user->getAccountName(),
      'email' => $user->getEmail(),
      'firstname' => $user->hasField('field_firstname') ? $user->get('field_firstname')->value : '',
      'lastname' => $user->hasField('field_lastname') ? $user->get('field_lastname')->value : '',
      'status' => $user->isActive(),
      'created' => $user->getCreatedTime(),
      'roles' => $user->getRoles(TRUE), // Exclure authenticated
    ];

    if ($user->hasField('field_function') && !$user->get('field_function')->isEmpty()) {
      $job_sheet = $user->get('field_function')->entity;
      if ($job_sheet) {
        $data['function'] = $job_sheet->getTitle();
        $data['job_sheet_id'] = $job_sheet->id();
      }
    }

    // Informations entreprise
    if ($user->hasField('field_parent_company') && !$user->get('field_parent_company')->isEmpty()) {
      $company = $user->get('field_parent_company')->entity;
      if ($company) {
        $data['company'] = [
          'id' => $company->id(),
          'name' => $company->getTitle(),
        ];
      }
    }

    // Détails complets si demandé
    if ($detailed) {
      $data['phone'] = $user->hasField('field_phone') ? $user->get('field_phone')->value : '';
      $data['effective_date'] = $user->hasField('field_effective_date') ? $user->get('field_effective_date')->value : '';
      $data['gross_annual_salary'] = $user->hasField('field_gross_annual_salary') ? $user->get('field_gross_annual_salary')->value : '';

      // Fiche de poste
      if ($user->hasField('field_function') && !$user->get('field_function')->isEmpty()) {
        $job_sheet = $user->get('field_function')->entity;
        if ($job_sheet) {
          $data['job_sheet'] = [
            'id' => $job_sheet->id(),
            'title' => $job_sheet->getTitle(),
            'status' => $job_sheet->hasField('field_job_description_status') ? 
              $job_sheet->get('field_job_description_status')->entity->getName() : '',
          ];
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
          $data['manager'] = [
            'id' => $manager->id(),
            'name' => $manager->get('field_firstname')->value . ' ' . $manager->get('field_lastname')->value,
          ];
        }
      }

      // Adresse
      if ($user->hasField('field_address') && !$user->get('field_address')->isEmpty()) {
        $address = $user->get('field_address')->entity;
        if ($address) {
          $data['address'] = [
            'street_number' => $address->get('field_street_number')->value,
            'street_name' => $address->get('field_street_name')->value,
            'postal_code' => $address->get('field_postal_code')->value,
            'city' => $address->get('field_city')->value,
            'country' => $address->get('field_country')->value,
          ];
        }
      }

      // Profil DISC
      if ($user->hasField('field_disc_profile') && !$user->get('field_disc_profile')->isEmpty()) {
        $disc_profile = $user->get('field_disc_profile')->entity;
        if ($disc_profile) {
          $data['disc_profile'] = [
            'id' => $disc_profile->id(),
            'title' => $disc_profile->getTitle(),
            'context' => $disc_profile->get('field_disc_context')->value,
            'completion_date' => $disc_profile->get('field_disc_completion_date')->value,
            'predominant_profile' => $disc_profile->get('field_disc_predominant_profile')->value,
          ];
        }
      }
    }

    return $data;
  }

  /**
   * Créer un paragraphe adresse.
   */
  private function createAddressParagraph($address_data) {
    if (empty($address_data['street_number']) || empty($address_data['street_name']) || 
        empty($address_data['postal_code']) || empty($address_data['city']) || 
        empty($address_data['country'])) {
      return NULL;
    }

    $paragraph = Paragraph::create([
      'type' => 'address',
      'field_street_number' => $address_data['street_number'],
      'field_street_name' => $address_data['street_name'],
      'field_postal_code' => $address_data['postal_code'],
      'field_city' => $address_data['city'],
      'field_country' => $address_data['country'],
    ]);

    $paragraph->save();
    return $paragraph;
  }

  /**
   * Vérifier si un email existe déjà.
   */
  private function emailExists($email) {
    $query = $this->entityTypeManager->getStorage('user')->getQuery()
      ->condition('mail', $email)
      ->accessCheck(FALSE);
    
    $uids = $query->execute();
    return !empty($uids);
  }

  /**
   * Vérifier si un nom d'utilisateur existe déjà.
   */
  private function usernameExists($username) {
    $query = $this->entityTypeManager->getStorage('user')->getQuery()
      ->condition('name', $username)
      ->accessCheck(FALSE);
    
    $uids = $query->execute();
    return !empty($uids);
  }
}