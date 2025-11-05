<?php

namespace Drupal\tholka_equipe\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\tholka_equipe\Service\OrganigrammeService;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Contrôleur API pour l'organigramme.
 */
class OrganigrammeApiController extends ControllerBase {

  protected $organigrammeService;

  public function __construct(OrganigrammeService $organigramme_service) {
    $this->organigrammeService = $organigramme_service;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('tholka_equipe.organigramme_service')
    );
  }

  /**
   * G2 & G3 - Récupérer l'organigramme avec filtres.
   */
  public function getOrganigramme(Request $request) {
    try {
      // Type de vue : hierarchical ou department
      $view_type = $request->query->get('view_type', 'hierarchical');
      
      if (!in_array($view_type, ['hierarchical', 'department'])) {
        return new JsonResponse([
          'status' => 'error',
          'message' => 'Type de vue invalide. Valeurs acceptées : hierarchical, department'
        ], 400);
      }

      // Filtres
      $filters = [
        'department_id' => $request->query->get('department_id'),
        'disc_profile' => $request->query->get('disc_profile'), // D, I, S, C
        'function' => $request->query->get('function'),
        'manager_id' => $request->query->get('manager_id'),
      ];

      $organigramme = $this->organigrammeService->getOrganigramme($filters, $view_type);

      return new JsonResponse([
        'status' => 'success',
        'data' => $organigramme
      ]);

    } catch (\Exception $e) {
      return new JsonResponse([
        'status' => 'error',
        'message' => 'Erreur lors de la récupération de l\'organigramme : ' . $e->getMessage()
      ], 500);
    }
  }

  /**
   * Récupérer les départements disponibles pour filtrer l'organigramme.
   */
  public function getDepartments() {
    try {
      $departments = $this->organigrammeService->getDepartments();

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
}