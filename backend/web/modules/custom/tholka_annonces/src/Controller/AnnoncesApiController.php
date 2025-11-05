<?php

namespace Drupal\tholka_annonces\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\tholka_annonces\Service\AnnoncesService;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Contrôleur API pour les annonces.
 */
class AnnoncesApiController extends ControllerBase {

  protected $annoncesService;

  public function __construct(AnnoncesService $annonces_service) {
    $this->annoncesService = $annonces_service;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('tholka_annonces.service')
    );
  }

  /**
   * GET /api/annonces - Liste des annonces (A1).
   */
  public function getAnnonces(Request $request) {
    try {
      $filters = [
        'status' => $request->query->get('status'), // draft, published, archived
        'search' => $request->query->get('search'),
        'localisation' => $request->query->get('localisation'),
        'company_id' => $request->query->get('company_id'),
        'date_from' => $request->query->get('date_from'),
        'date_to' => $request->query->get('date_to'),
      ];

      $sort = [];
      if ($request->query->get('sort_field')) {
        $sort = [
          'field' => $request->query->get('sort_field'),
          'direction' => $request->query->get('sort_direction', 'ASC'),
        ];
      }

      $page = (int) $request->query->get('page', 0);
      $limit = (int) $request->query->get('limit', 20);

      $result = $this->annoncesService->getAnnonces($filters, $sort, $page, $limit);

      return new JsonResponse($result);
    }
    catch (\Exception $e) {
      return new JsonResponse(['error' => $e->getMessage()], 500);
    }
  }

  /**
   * GET /api/annonces/{id} - Détail d'une annonce (A2).
   */
  public function getAnnonce($id) {
    try {
      $annonce = $this->annoncesService->getAnnonce($id);
      
      if (!$annonce) {
        return new JsonResponse(['error' => 'Annonce introuvable'], 404);
      }

      return new JsonResponse($annonce);
    }
    catch (\Exception $e) {
      return new JsonResponse(['error' => $e->getMessage()], 500);
    }
  }

  /**
   * POST /api/annonces - Création d'annonce (A3).
   */
  public function createAnnonce(Request $request) {
    try {
      $data = json_decode($request->getContent(), TRUE);
      
      if (!$data || empty($data['title'])) {
        return new JsonResponse(['error' => 'Titre requis'], 400);
      }

      $annonce = $this->annoncesService->createAnnonce($data);

      return new JsonResponse($annonce, 201);
    }
    catch (\Exception $e) {
      return new JsonResponse(['error' => $e->getMessage()], 500);
    }
  }

  /**
   * PUT/PATCH /api/annonces/{id} - Modification d'annonce (A4).
   */
  public function updateAnnonce($id, Request $request) {
    try {
      $data = json_decode($request->getContent(), TRUE);
      
      if (!$data) {
        return new JsonResponse(['error' => 'Données invalides'], 400);
      }

      $annonce = $this->annoncesService->updateAnnonce($id, $data);

      return new JsonResponse($annonce);
    }
    catch (\Exception $e) {
      return new JsonResponse(['error' => $e->getMessage()], 500);
    }
  }

  /**
   * DELETE /api/annonces/{id} - Suppression d'annonce (A5).
   */
  public function deleteAnnonce($id) {
    try {
      $result = $this->annoncesService->deleteAnnonce($id);

      return new JsonResponse($result);
    }
    catch (\Exception $e) {
      return new JsonResponse(['error' => $e->getMessage()], 500);
    }
  }

  /**
   * POST /api/annonces/generate - Génération IA (A3).
   */
  public function generateAnnonce(Request $request) {
    try {
      $data = json_decode($request->getContent(), TRUE);
      
      if (!$data) {
        return new JsonResponse(['error' => 'Données invalides'], 400);
      }

      $generated = $this->annoncesService->generateAnnonce($data);

      return new JsonResponse($generated);
    }
    catch (\Exception $e) {
      return new JsonResponse(['error' => $e->getMessage()], 500);
    }
  }

  /**
   * POST /api/annonces/{id}/duplicate - Duplication (A6).
   */
  public function duplicateAnnonce($id) {
    try {
      $duplicate = $this->annoncesService->duplicateAnnonce($id);

      return new JsonResponse($duplicate, 201);
    }
    catch (\Exception $e) {
      return new JsonResponse(['error' => $e->getMessage()], 500);
    }
  }
}