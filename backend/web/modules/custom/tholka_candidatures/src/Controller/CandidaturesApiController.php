<?php

namespace Drupal\tholka_candidatures\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\tholka_candidatures\Service\CandidaturesService;

/**
 * Contrôleur API pour les candidatures (côté RH).
 */
class CandidaturesApiController extends ControllerBase {

  protected $candidaturesService;

  public function __construct(CandidaturesService $candidatures_service) {
    $this->candidaturesService = $candidatures_service;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('tholka_candidatures.service')
    );
  }

  /**
   * GET /api/candidatures - Liste des candidatures avec filtres.
   */
  public function getCandidatures(Request $request) {
    try {
      // Récupérer les paramètres
      $filters = [
        'status' => $request->query->get('status'),
        'job_posting_id' => $request->query->get('job_posting_id'),
        'company_id' => $request->query->get('company_id'),
        'search' => $request->query->get('search'),
      ];
      
      // Nettoyer les filtres vides
      $filters = array_filter($filters, function($value) {
        return $value !== null && $value !== '';
      });

      $sort = [
        'field' => $request->query->get('sort_field', 'created'),
        'direction' => strtoupper($request->query->get('sort_direction', 'DESC')),
      ];

      $page = max(0, (int) $request->query->get('page', 0));
      $limit = max(1, min(100, (int) $request->query->get('limit', 20)));

      $result = $this->candidaturesService->getCandidatures($filters, $sort, $page, $limit);

      return new JsonResponse([
        'status' => 'success',
        'data' => $result,
      ]);

    } catch (\Exception $e) {
      return new JsonResponse([
        'status' => 'error',
        'message' => $e->getMessage(),
      ], 500);
    }
  }

  /**
   * GET /api/candidatures/{id} - Détail d'une candidature.
   */
  public function getCandidature($id) {
    try {
      $candidature = $this->candidaturesService->getCandidature($id);
      
      if (!$candidature) {
        return new JsonResponse([
          'status' => 'error',
          'message' => 'Candidature introuvable',
        ], 404);
      }

      return new JsonResponse([
        'status' => 'success',
        'data' => $candidature,
      ]);

    } catch (\Exception $e) {
      return new JsonResponse([
        'status' => 'error',
        'message' => $e->getMessage(),
      ], 500);
    }
  }

  /**
   * PUT/PATCH /api/candidatures/{id} - Modifier une candidature (suivi RH).
   */
  public function updateCandidature(Request $request, $id) {
    try {
      $data = json_decode($request->getContent(), TRUE);
      
      if (!$data) {
        return new JsonResponse([
          'status' => 'error',
          'message' => 'Données JSON invalides',
        ], 400);
      }

      $result = $this->candidaturesService->updateCandidature($id, $data);

      return new JsonResponse([
        'status' => 'success',
        'data' => $result,
      ]);

    } catch (\Exception $e) {
      return new JsonResponse([
        'status' => 'error',
        'message' => $e->getMessage(),
      ], $e->getMessage() === 'Candidature introuvable' ? 404 : 400);
    }
  }
}