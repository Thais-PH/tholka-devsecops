<?php

namespace Drupal\tholka_candidatures\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\tholka_candidatures\Service\CandidaturesService;
use Drupal\tholka_candidatures\Service\DiscService;

/**
 * Contrôleur API publique pour les candidatures.
 */
class CandidaturesPublicController extends ControllerBase {

  protected $candidaturesService;
  protected $discService;

  public function __construct(CandidaturesService $candidatures_service, DiscService $disc_service) {
    $this->candidaturesService = $candidatures_service;
    $this->discService = $disc_service;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('tholka_candidatures.service'),
      $container->get('tholka_candidatures.disc_service')
    );
  }

  /**
   * GET /api/public/annonces/{job_posting_id} - Annonce publique pour candidature.
   */
  public function getJobPostingPublic($job_posting_id) {
    try {
      $annonce_service = \Drupal::service('tholka_annonces.service');
      $annonce = $annonce_service->getAnnonce($job_posting_id);
      
      if (!$annonce) {
        return new JsonResponse([
          'status' => 'error',
          'message' => 'Annonce introuvable',
        ], 404);
      }

      // Vérifier que l'annonce est publiée
      if ($annonce['status'] !== 'published') {
        return new JsonResponse([
          'status' => 'error',
          'message' => 'Cette annonce n\'est plus disponible',
        ], 403);
      }

      // Retourner uniquement les infos publiques
      $public_data = [
        'id' => $annonce['id'],
        'title' => $annonce['title'],
        'description' => $annonce['description'],
        'localisation' => $annonce['localisation'],
        'postes_a_pourvoir' => $annonce['postes_a_pourvoir'],
        'company' => $annonce['company'],
        'liens_web_requis' => $annonce['liens_web_requis'] ?? [],
        'lettre_motivation_requise' => $annonce['lettre_motivation_requise'] ?? false,
        'champs_personnalises' => $annonce['champs_personnalises'] ?? [],
      ];

      return new JsonResponse([
        'status' => 'success',
        'data' => $public_data,
      ]);

    } catch (\Exception $e) {
      return new JsonResponse([
        'status' => 'error',
        'message' => $e->getMessage(),
      ], 500);
    }
  }

  /**
   * GET /api/public/candidature/{job_posting_id} - C1: Formulaire de candidature.
   */
  public function getCandidatureForm($job_posting_id) {
    try {
      $form_data = $this->candidaturesService->getPublicCandidatureForm($job_posting_id);

      return new JsonResponse([
        'status' => 'success',
        'data' => $form_data,
      ]);

    } catch (\Exception $e) {
      return new JsonResponse([
        'status' => 'error',
        'message' => $e->getMessage(),
      ], $e->getMessage() === 'Annonce d\'emploi introuvable' ? 404 : 400);
    }
  }

  /**
   * POST /api/public/candidature/{job_posting_id}/submit - C2/C3: Soumettre candidature.
   */
  public function submitCandidature(Request $request, $job_posting_id) {
    try {
      // Récupérer les données JSON
      $data = json_decode($request->getContent(), TRUE);
      
      if (!$data) {
        return new JsonResponse([
          'status' => 'error',
          'message' => 'Données JSON invalides',
        ], 400);
      }

      // Récupérer les fichiers (pour l'instant mock, TODO: implémenter upload)
      $files = $request->files->all();

      $result = $this->candidaturesService->submitPublicCandidature($job_posting_id, $data, $files);

      return new JsonResponse([
        'status' => 'success',
        'data' => $result,
      ], 201);

    } catch (\Exception $e) {
      return new JsonResponse([
        'status' => 'error',
        'message' => $e->getMessage(),
      ], 400);
    }
  }

  /**
   * GET /api/public/candidature/{candidature_id}/disc-test - C5: Récupérer test DISC.
   */
  public function getDiscTest($candidature_id) {
    try {
      $disc_test = $this->discService->getDiscTest($candidature_id);

      return new JsonResponse([
        'status' => 'success',
        'data' => $disc_test,
      ]);

    } catch (\Exception $e) {
      return new JsonResponse([
        'status' => 'error',
        'message' => $e->getMessage(),
      ], $e->getMessage() === 'Candidature introuvable' ? 404 : 400);
    }
  }

  /**
   * POST /api/public/candidature/{candidature_id}/disc-test/submit - C5: Soumettre test DISC.
   */
  public function submitDiscTest(Request $request, $candidature_id) {
    try {
      $data = json_decode($request->getContent(), TRUE);
      
      if (!$data) {
        return new JsonResponse([
          'status' => 'error',
          'message' => 'Données JSON invalides',
        ], 400);
      }

      $result = $this->discService->submitDiscTest($candidature_id, $data);

      return new JsonResponse([
        'status' => 'success',
        'data' => $result,
      ]);

    } catch (\Exception $e) {
      return new JsonResponse([
        'status' => 'error',
        'message' => $e->getMessage(),
      ], 400);
    }
  }
}