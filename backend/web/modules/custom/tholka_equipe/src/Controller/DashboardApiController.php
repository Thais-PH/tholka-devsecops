<?php

namespace Drupal\tholka_equipe\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\tholka_equipe\Service\DashboardService;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Contrôleur API pour le tableau de bord personnalisé.
 */
class DashboardApiController extends ControllerBase {

  protected $dashboardService;

  public function __construct(DashboardService $dashboard_service) {
    $this->dashboardService = $dashboard_service;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('tholka_equipe.dashboard_service')
    );
  }

  /**
   * G5 - Récupérer le dashboard personnalisé.
   */
  public function getDashboard(Request $request) {
    try {
      // Paramètre optionnel pour changer de vue (RH/Manager)
      $view_as = $request->query->get('view_as');
      
      // Valider view_as
      if ($view_as && !in_array($view_as, ['collaborateur', 'manager', 'rh'])) {
        return new JsonResponse([
          'status' => 'error',
          'message' => 'Paramètre view_as invalide. Valeurs acceptées : collaborateur, manager, rh'
        ], 400);
      }

      $dashboard = $this->dashboardService->getDashboard($view_as);

      return new JsonResponse([
        'status' => 'success',
        'data' => $dashboard
      ]);

    } catch (\Exception $e) {
      return new JsonResponse([
        'status' => 'error',
        'message' => 'Erreur lors de la récupération du dashboard : ' . $e->getMessage()
      ], 500);
    }
  }
}