<?php

namespace Drupal\tholka_equipe\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\tholka_equipe\Service\IAAlertesService;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Contrôleur API pour les alertes IA.
 */
class IAAlertesApiController extends ControllerBase {

  protected $iaAlertesService;

  public function __construct(IAAlertesService $ia_alertes_service) {
    $this->iaAlertesService = $ia_alertes_service;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('tholka_equipe.ia_alertes_service')
    );
  }

  /**
   * G4 - Récupérer les alertes IA pour un utilisateur.
   */
  public function getUserAlertes($user_id) {
    try {
      $alertes = $this->iaAlertesService->getUserAlertes($user_id);

      return new JsonResponse([
        'status' => 'success',
        'data' => $alertes
      ]);

    } catch (\Exception $e) {
      $status_code = (strpos($e->getMessage(), 'introuvable') !== false) ? 404 : 500;
      
      return new JsonResponse([
        'status' => 'error',
        'message' => 'Erreur lors de la récupération des alertes : ' . $e->getMessage()
      ], $status_code);
    }
  }
}