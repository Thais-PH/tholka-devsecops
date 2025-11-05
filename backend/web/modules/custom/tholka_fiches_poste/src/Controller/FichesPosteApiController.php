<?php

namespace Drupal\tholka_fiches_poste\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\tholka_fiches_poste\Service\FichesPosteService;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Contrôleur API pour les fiches de poste.
 */
class FichesPosteApiController extends ControllerBase {

  protected $fichesPosteService;

  public function __construct(FichesPosteService $fiches_poste_service) {
    $this->fichesPosteService = $fiches_poste_service;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('tholka_fiches_poste.service')
    );
  }

  /**
   * B1 & B6 - Liste des fiches de poste avec filtres.
   */
  public function getFichesPoste(Request $request) {
    try {
      // Récupérer les filtres
      $filters = [
        'status' => $request->query->get('status'),
        'search' => $request->query->get('search'),
        'company_id' => $request->query->get('company_id'),
        'skills' => $request->query->get('skills'), // Comma-separated ou array
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

      $result = $this->fichesPosteService->getFichesPoste($filters, $sort, $page, $limit);

      return new JsonResponse([
        'status' => 'success',
        'data' => $result
      ]);

    } catch (\Exception $e) {
      return new JsonResponse([
        'status' => 'error',
        'message' => 'Erreur lors de la récupération des fiches de poste : ' . $e->getMessage()
      ], 500);
    }
  }

  /**
   * B2 - Détail d'une fiche de poste.
   */
  public function getFichePoste($id) {
    try {
      $fiche = $this->fichesPosteService->getFichePoste($id);

      return new JsonResponse([
        'status' => 'success',
        'data' => $fiche
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
   * B3 - Créer une nouvelle fiche de poste (avec templates).
   */
  public function createFichePoste(Request $request) {
    try {
      $data = json_decode($request->getContent(), true);

      if (json_last_error() !== JSON_ERROR_NONE) {
        return new JsonResponse([
          'status' => 'error',
          'message' => 'Données JSON invalides'
        ], 400);
      }

      // Si template demandé, le récupérer d'abord
      if (!empty($data['template_id'])) {
        $templates = $this->fichesPosteService->getJobDescriptionTemplates();
        $template_data = null;
        
        foreach ($templates as $template) {
          if ($template['id'] === $data['template_id']) {
            $template_data = $template['template'];
            break;
          }
        }

        if ($template_data) {
          // Fusionner les données du template avec les données fournies
          $data = array_merge($template_data, $data);
        }
      }

      $fiche = $this->fichesPosteService->createFichePoste($data);

      return new JsonResponse([
        'status' => 'success',
        'message' => 'Fiche de poste créée avec succès',
        'data' => $fiche
      ], 201);

    } catch (\Exception $e) {
      return new JsonResponse([
        'status' => 'error',
        'message' => 'Erreur lors de la création : ' . $e->getMessage()
      ], 400);
    }
  }

  /**
   * B4 - Modifier une fiche de poste.
   */
  public function updateFichePoste($id, Request $request) {
    try {
      $data = json_decode($request->getContent(), true);

      if (json_last_error() !== JSON_ERROR_NONE) {
        return new JsonResponse([
          'status' => 'error',
          'message' => 'Données JSON invalides'
        ], 400);
      }

      $fiche = $this->fichesPosteService->updateFichePoste($id, $data);

      return new JsonResponse([
        'status' => 'success',
        'message' => 'Fiche de poste modifiée avec succès',
        'data' => $fiche
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
   * B5 - Supprimer une fiche de poste.
   */
  public function deleteFichePoste($id) {
    try {
      $this->fichesPosteService->deleteFichePoste($id);

      return new JsonResponse([
        'status' => 'success',
        'message' => 'Fiche de poste supprimée avec succès'
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
   * Récupérer les templates disponibles pour B3.
   */
  public function getTemplates() {
    try {
      $templates = $this->fichesPosteService->getJobDescriptionTemplates();

      return new JsonResponse([
        'status' => 'success',
        'data' => $templates
      ]);

    } catch (\Exception $e) {
      return new JsonResponse([
        'status' => 'error',
        'message' => 'Erreur lors de la récupération des templates : ' . $e->getMessage()
      ], 500);
    }
  }

  /**
   * Récupérer les compétences disponibles pour une entreprise.
   */
  public function getSkillsForCompany($company_id) {
    try {
      $skills = $this->fichesPosteService->getSkillsForCompany($company_id);

      return new JsonResponse([
        'status' => 'success',
        'data' => $skills
      ]);

    } catch (\Exception $e) {
      return new JsonResponse([
        'status' => 'error',
        'message' => 'Erreur lors de la récupération des compétences : ' . $e->getMessage()
      ], 500);
    }
  }
}