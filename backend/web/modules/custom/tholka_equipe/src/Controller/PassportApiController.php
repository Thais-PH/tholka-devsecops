<?php

namespace Drupal\tholka_equipe\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\tholka_equipe\Service\PassportService;
use Drupal\tholka_equipe\Service\IAAlertesService;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Session\AccountInterface;

/**
 * Contrôleur API pour les passeports de compétences.
 */
class PassportApiController extends ControllerBase {

  protected $passportService;

  public function __construct(PassportService $passport_service) {
    $this->passportService = $passport_service;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('tholka_equipe.passport_service')
    );
  }

  /**
   * G1 - Récupérer son propre passeport de compétences.
   */
  public function getMyPassport() {
    try {
      $passport = $this->passportService->getMyPassport();

      return new JsonResponse([
        'status' => 'success',
        'data' => $passport
      ]);

    } catch (\Exception $e) {
      return new JsonResponse([
        'status' => 'error',
        'message' => 'Erreur lors de la récupération du passeport : ' . $e->getMessage()
      ], 500);
    }
  }

  /**
   * G1 - Récupérer le passeport d'un utilisateur spécifique.
   */
  public function getUserPassport($user_id) {
    try {
      // Vérifier si le salaire doit être inclus (RH uniquement)
      $current_user = $this->entityTypeManager()->getStorage('user')->load($this->currentUser()->id());
      $include_salary = in_array('rh', $current_user->getRoles());

      $passport = $this->passportService->getUserPassport($user_id, $include_salary);

      return new JsonResponse([
        'status' => 'success',
        'data' => $passport
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
   * Mettre à jour le salaire d'un utilisateur (RH uniquement).
   */
  public function updateSalary($user_id, Request $request) {
    try {
      $current_user_obj = $this->entityTypeManager()->getStorage('user')->load($this->currentUser()->id());
      $roles = $current_user_obj->getRoles();

      // Vérifier que l'utilisateur est RH
      if (!in_array('rh', $roles)) {
        return new JsonResponse([
          'status' => 'error',
          'message' => 'Accès refusé : seuls les RH peuvent modifier les salaires'
        ], 403);
      }

      // ✅ NOUVELLE VÉRIFICATION : Même entreprise
      $target_user = $this->entityTypeManager()->getStorage('user')->load($user_id);
      
      if (!$target_user) {
        return new JsonResponse([
          'status' => 'error',
          'message' => 'Utilisateur introuvable'
        ], 404);
      }

      $current_company = $current_user_obj->hasField('field_parent_company') ? 
        $current_user_obj->get('field_parent_company')->target_id : null;
      
      $target_company = $target_user->hasField('field_parent_company') ? 
        $target_user->get('field_parent_company')->target_id : null;

      if ($current_company != $target_company) {
        return new JsonResponse([
          'status' => 'error',
          'message' => 'Accès refusé : vous ne pouvez modifier que les salaires de votre entreprise'
        ], 403);
      }

      // Récupérer le nouveau salaire
      $data = json_decode($request->getContent(), TRUE);

      if (!isset($data['salary'])) {
        return new JsonResponse([
          'status' => 'error',
          'message' => 'Le champ "salary" est requis'
        ], 400);
      }

      $result = $this->passportService->updateSalary($user_id, $data['salary']);

      return new JsonResponse([
        'status' => 'success',
        'message' => 'Salaire mis à jour avec succès',
        'data' => $result
      ]);

    } catch (\Exception $e) {
      return new JsonResponse([
        'status' => 'error',
        'message' => 'Erreur lors de la mise à jour du salaire : ' . $e->getMessage()
      ], 500);
    }
  }

  /**
   * Vérification d'accès personnalisée pour les passeports.
   */
  public function checkPassportAccess($user_id, AccountInterface $account) {
    try {
      $can_access = $this->passportService->canAccessPassport($user_id);
      
      return $can_access ? AccessResult::allowed() : AccessResult::forbidden();
      
    } catch (\Exception $e) {
      return AccessResult::forbidden();
    }
  }
}