<?php

namespace Drupal\tholka_comptes\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\tholka_comptes\Service\ComptesService;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Contrôleur API pour les comptes utilisateurs.
 */
class ComptesApiController extends ControllerBase {

  protected $comptesService;

  public function __construct(ComptesService $comptes_service) {
    $this->comptesService = $comptes_service;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('tholka_comptes.service')
    );
  }

  /**
   * L1 & L6 - Liste des comptes utilisateurs avec filtres.
   */
  public function getComptes(Request $request) {
    try {
      // Récupérer les filtres
      $filters = [
        'status' => $request->query->get('status'), // 1 = actif, 0 = inactif
        'role' => $request->query->get('role'), // collaborateur, manager, rh
        'company_id' => $request->query->get('company_id'),
        'department_id' => $request->query->get('department_id'),
        'search' => $request->query->get('search'),
      ];

      // Récupérer le tri
      $sort = [];
      if ($request->query->get('sort_field')) {
        $sort = [
          'field' => $request->query->get('sort_field'),
          'direction' => $request->query->get('sort_direction', 'ASC'),
        ];
      }

      // Pagination
      $page = max(0, (int) $request->query->get('page', 0));
      $limit = min(100, max(1, (int) $request->query->get('limit', 20)));

      $result = $this->comptesService->getComptes($filters, $sort, $page, $limit);

      return new JsonResponse([
        'status' => 'success',
        'data' => $result
      ]);

    } catch (\Exception $e) {
      return new JsonResponse([
        'status' => 'error',
        'message' => 'Erreur lors de la récupération des comptes : ' . $e->getMessage()
      ], 500);
    }
  }

  /**
   * L2 - Détail d'un compte utilisateur.
   */
  public function getCompte($id) {
    try {
      $compte = $this->comptesService->getCompte($id);

      return new JsonResponse([
        'status' => 'success',
        'data' => $compte
      ]);

    } catch (\Exception $e) {
      $status_code = (strpos($e->getMessage(), 'introuvable') !== false) ? 404 : 500;
      
      return new JsonResponse([
        'status' => 'error',
        'message' => $e->getMessage()
      ], $status_code);
    }
  }

  /**
   * L3 - Créer un nouveau compte utilisateur.
   */
  public function createCompte(Request $request) {
    try {
      $data = json_decode($request->getContent(), true);

      if (json_last_error() !== JSON_ERROR_NONE) {
        return new JsonResponse([
          'status' => 'error',
          'message' => 'Données JSON invalides'
        ], 400);
      }

      $compte = $this->comptesService->createCompte($data);

      return new JsonResponse([
        'status' => 'success',
        'message' => 'Compte utilisateur créé avec succès',
        'data' => $compte
      ], 201);

    } catch (\Exception $e) {
      return new JsonResponse([
        'status' => 'error',
        'message' => 'Erreur lors de la création : ' . $e->getMessage()
      ], 400);
    }
  }

  /**
   * L4 - Modifier un compte utilisateur.
   */
  public function updateCompte($id, Request $request) {
    try {
      $data = json_decode($request->getContent(), true);

      if (json_last_error() !== JSON_ERROR_NONE) {
        return new JsonResponse([
          'status' => 'error',
          'message' => 'Données JSON invalides'
        ], 400);
      }

      $compte = $this->comptesService->updateCompte($id, $data);

      return new JsonResponse([
        'status' => 'success',
        'message' => 'Compte utilisateur modifié avec succès',
        'data' => $compte
      ]);

    } catch (\Exception $e) {
      $status_code = (strpos($e->getMessage(), 'introuvable') !== false) ? 404 : 400;
      
      return new JsonResponse([
        'status' => 'error',
        'message' => 'Erreur lors de la modification : ' . $e->getMessage()
      ], $status_code);
    }
  }

  /**
   * L5 - Supprimer un compte utilisateur.
   */
  public function deleteCompte($id) {
    try {
      $this->comptesService->deleteCompte($id);

      return new JsonResponse([
        'status' => 'success',
        'message' => 'Compte utilisateur supprimé avec succès'
      ]);

    } catch (\Exception $e) {
      $status_code = (strpos($e->getMessage(), 'introuvable') !== false) ? 404 : 500;
      
      return new JsonResponse([
        'status' => 'error',
        'message' => 'Erreur lors de la suppression : ' . $e->getMessage()
      ], $status_code);
    }
  }

  /**
   * L7 - Récupérer son profil personnel.
   */
  public function getMyProfile() {
    try {
      $profile = $this->comptesService->getMyProfile();

      return new JsonResponse([
        'status' => 'success',
        'data' => $profile
      ]);

    } catch (\Exception $e) {
      return new JsonResponse([
        'status' => 'error',
        'message' => 'Erreur lors de la récupération du profil : ' . $e->getMessage()
      ], 500);
    }
  }

  /**
   * L7 - Modifier son profil personnel.
   */
  public function updateMyProfile(Request $request) {
    try {
      $data = json_decode($request->getContent(), true);

      if (json_last_error() !== JSON_ERROR_NONE) {
        return new JsonResponse([
          'status' => 'error',
          'message' => 'Données JSON invalides'
        ], 400);
      }

      $profile = $this->comptesService->updateMyProfile($data);

      return new JsonResponse([
        'status' => 'success',
        'message' => 'Profil personnel modifié avec succès',
        'data' => $profile
      ]);

    } catch (\Exception $e) {
      return new JsonResponse([
        'status' => 'error',
        'message' => 'Erreur lors de la modification du profil : ' . $e->getMessage()
      ], 400);
    }
  }

  /**
   * Récupérer les départements disponibles pour une entreprise.
   */
  public function getDepartmentsForCompany($company_id) {
    try {
      $query = $this->entityTypeManager()->getStorage('taxonomy_term')->getQuery()
        ->condition('vid', 'departments')
        ->condition('field_parent_company', $company_id)
        ->accessCheck(FALSE)
        ->sort('name');
      
      $tids = $query->execute();
      $terms = $this->entityTypeManager()->getStorage('taxonomy_term')->loadMultiple($tids);
      
      $departments = [];
      foreach ($terms as $term) {
        $departments[] = [
          'id' => $term->id(),
          'name' => $term->getName(),
        ];
      }

      return new JsonResponse([
        'status' => 'success',
        'data' => $departments
      ]);

    } catch (\Exception $e) {
      return new JsonResponse([
        'status' => 'error',
        'message' => 'Erreur lors de la récupération des départements : ' . $e->getMessage()
      ], 500);
    }
  }

  /**
   * Récupérer les managers disponibles pour une entreprise.
   */
  public function getManagersForCompany($company_id) {
    try {
      $query = $this->entityTypeManager()->getStorage('user')->getQuery()
        ->condition('status', 1)
        ->condition('field_parent_company', $company_id)
        ->condition('roles', 'manager')
        ->accessCheck(FALSE)
        ->sort('field_lastname');
      
      $uids = $query->execute();
      $users = $this->entityTypeManager()->getStorage('user')->loadMultiple($uids);
      
      $managers = [];
      foreach ($users as $user) {
        $function = '';
        if ($user->hasField('field_function') && !$user->get('field_function')->isEmpty()) {
          $job_sheet = $user->get('field_function')->entity;
          if ($job_sheet) {
            $function = $job_sheet->getTitle();
          }
        }
        
        $managers[] = [
          'id' => $user->id(),
          'name' => $user->get('field_firstname')->value . ' ' . $user->get('field_lastname')->value,
          'function' => $function,
        ];
      }

      return new JsonResponse([
        'status' => 'success',
        'data' => $managers
      ]);

    } catch (\Exception $e) {
      return new JsonResponse([
        'status' => 'error',
        'message' => 'Erreur lors de la récupération des managers : ' . $e->getMessage()
      ], 500);
    }
  }

  /**
   * Récupérer les rôles disponibles.
   */
  public function getRoles() {
    try {
      $roles = [
        ['id' => 'collaborateur', 'name' => 'Collaborateur'],
        ['id' => 'manager', 'name' => 'Manager'],
        ['id' => 'rh', 'name' => 'Ressources Humaines'],
      ];

      return new JsonResponse([
        'status' => 'success',
        'data' => $roles
      ]);

    } catch (\Exception $e) {
      return new JsonResponse([
        'status' => 'error',
        'message' => 'Erreur lors de la récupération des rôles : ' . $e->getMessage()
      ], 500);
    }
  }

  /**
   * Récupérer les fiches de poste disponibles pour une entreprise.
   */
  public function getJobSheetsForCompany($company_id) {
    try {
      $query = $this->entityTypeManager()->getStorage('node')->getQuery()
        ->condition('type', 'job_description')
        ->condition('field_parent_company', $company_id)
        ->condition('field_job_description_status', 'published')
        ->accessCheck(FALSE)
        ->sort('title');
      
      $nids = $query->execute();
      $job_sheets = $this->entityTypeManager()->getStorage('node')->loadMultiple($nids);
      
      $sheets = [];
      foreach ($job_sheets as $sheet) {
        $sheets[] = [
          'id' => $sheet->id(),
          'title' => $sheet->getTitle(),
        ];
      }

      return new JsonResponse([
        'status' => 'success',
        'data' => $sheets
      ]);

    } catch (\Exception $e) {
      return new JsonResponse([
        'status' => 'error',
        'message' => 'Erreur lors de la récupération des fiches de poste : ' . $e->getMessage()
      ], 500);
    }
  }
}