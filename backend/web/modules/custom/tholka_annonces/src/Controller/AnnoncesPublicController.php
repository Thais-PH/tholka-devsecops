<?php

namespace Drupal\tholka_annonces\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;

class AnnoncesPublicController extends ControllerBase {

  /**
   * GET /api/public/annonces/{uuid} - Accès public pour candidature
   */
  public function getAnnoncePublic($uuid) {
    $query = \Drupal::entityQuery('node')
      ->condition('type', 'annonce_emploi')
      ->condition('field_uuid', $uuid)
      ->condition('status', 1) // Seulement les publiées
      ->accessCheck(FALSE); // Accès public

    $nids = $query->execute();
    
    if (empty($nids)) {
      return new JsonResponse(['error' => 'Annonce introuvable ou non publiée'], 404);
    }

    $node = \Drupal::entityTypeManager()->getStorage('node')->load(reset($nids));
    
    // Format spécial pour candidature (sans infos sensibles)
    $data = [
      'uuid' => $uuid,
      'title' => $node->getTitle(),
      'intitule_poste' => $node->get('field_intitule_poste')->value,
      'description' => $node->get('body')->value,
      'localisation' => $node->get('field_localisation')->value,
      'type_contrat' => $node->get('field_type_contrat')->value,
      'formulaire_candidature' => json_decode($node->get('field_formulaire_candidature')->value, TRUE),
      'profil_disc_requis' => $node->get('field_profil_disc_souhaite')->value,
    ];

    return new JsonResponse($data);
  }
}