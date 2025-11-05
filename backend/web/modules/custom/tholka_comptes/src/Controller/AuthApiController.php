<?php

namespace Drupal\tholka_comptes\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Drupal\user\Entity\User;

/**
 * Contrôleur pour l'authentification API.
 */
class AuthApiController extends ControllerBase {

  /**
   * Login et récupération du cookie de session.
   */
  public function login(Request $request) {
    $data = json_decode($request->getContent(), TRUE);

    if (empty($data['username']) || empty($data['password'])) {
      return new JsonResponse([
        'status' => 'error',
        'message' => 'Username et password requis'
      ], 400);
    }

    // Authentifier l'utilisateur
    $uid = \Drupal::service('user.auth')->authenticate($data['username'], $data['password']);

    if (!$uid) {
      return new JsonResponse([
        'status' => 'error',
        'message' => 'Identifiants invalides'
      ], 401);
    }

    $user = User::load($uid);
    
    // Créer une session pour cet utilisateur
    user_login_finalize($user);

    // Récupérer les infos de session
    $session_name = session_name();
    $session_id = session_id();

    return new JsonResponse([
      'status' => 'success',
      'data' => [
        'uid' => $user->id(),
        'username' => $user->getAccountName(),
        'email' => $user->getEmail(),
        'roles' => $user->getRoles(),
        'session_name' => $session_name,
        'session_id' => $session_id,
      ],
      'message' => 'Connexion réussie. Utilisez le cookie de session pour les prochaines requêtes.'
    ]);
  }

  /**
   * Logout.
   */
  public function logout() {
    user_logout();

    return new JsonResponse([
      'status' => 'success',
      'message' => 'Déconnexion réussie'
    ]);
  }

  /**
   * Récupérer les infos de l'utilisateur connecté.
   */
  public function me() {
    $current_user = \Drupal::currentUser();

    if ($current_user->isAnonymous()) {
      return new JsonResponse([
        'status' => 'error',
        'message' => 'Non authentifié'
      ], 401);
    }

    $user = User::load($current_user->id());

    return new JsonResponse([
      'status' => 'success',
      'data' => [
        'uid' => $user->id(),
        'username' => $user->getAccountName(),
        'email' => $user->getEmail(),
        'roles' => $user->getRoles(),
        'firstname' => $user->hasField('field_firstname') ? $user->get('field_firstname')->value : '',
        'lastname' => $user->hasField('field_lastname') ? $user->get('field_lastname')->value : '',
      ]
    ]);
  }
}