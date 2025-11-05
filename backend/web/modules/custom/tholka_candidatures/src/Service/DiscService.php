<?php

namespace Drupal\tholka_candidatures\Service;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\node\Entity\Node;

/**
 * Service pour la gestion des tests DISC.
 */
class DiscService {

  protected $entityTypeManager;
  protected $currentUser;

  public function __construct(EntityTypeManagerInterface $entity_type_manager, AccountInterface $current_user) {
    $this->entityTypeManager = $entity_type_manager;
    $this->currentUser = $current_user;
  }

  /**
   * C5 - Récupérer le test DISC pour une candidature.
   */
  public function getDiscTest($candidature_id) {
    // Vérifier que la candidature existe
    $candidature = $this->entityTypeManager->getStorage('node')->load($candidature_id);
    
    if (!$candidature || $candidature->bundle() !== 'application') {
      throw new \Exception('Candidature introuvable');
    }

    // Vérifier si le test DISC a déjà été passé
    if ($candidature->hasField('field_candidate_disc_result') && !$candidature->get('field_candidate_disc_result')->isEmpty() && $candidature->get('field_candidate_disc_result')->value !== null) {
      return [
        'test_deja_passe' => true,
        'message' => 'Le test DISC a déjà été passé pour cette candidature',
        'resultat_id' => $candidature->get('field_candidate_disc_result')->target_id,
      ];
    }

    // Récupérer les questions du test DISC
    $questions = $this->getDiscQuestions();
    
    return [
      'test_deja_passe' => false,
      'candidature_id' => $candidature_id,
      'candidat' => [
        'nom' => $candidature->get('field_candidate_lastname')->value,
        'prenom' => $candidature->get('field_candidate_firstname')->value,
      ],
      'instructions' => 'Pour chaque affirmation, indiquez votre niveau d\'accord sur une échelle de 1 à 4.',
      'echelle' => [
        1 => 'Pas du tout d\'accord',
        2 => 'Partiellement d\'accord', 
        3 => 'Plutôt d\'accord',
        4 => 'Vraiment d\'accord'
      ],
      'questions' => $questions,
      'nombre_questions' => 50,
    ];
  }

  /**
   * C5 - Soumettre les réponses du test DISC.
   */
  public function submitDiscTest($candidature_id, $responses) {
    // Vérifier que la candidature existe
    $candidature = $this->entityTypeManager->getStorage('node')->load($candidature_id);
    
    if (!$candidature || $candidature->bundle() !== 'application') {
      throw new \Exception('Candidature introuvable');
    }

    // Vérifier si le test n'a pas déjà été passé
    // var_dump($candidature->get('field_candidate_disc_result')->value);exit;:
    if ($candidature->hasField('field_candidate_disc_result') && !$candidature->get('field_candidate_disc_result')->isEmpty() && $candidature->get('field_candidate_disc_result')->value !== null) {
      throw new \Exception('Le test DISC a déjà été passé pour cette candidature');
    }

    // Valider les réponses
    if (!isset($responses['reponses']) || !is_array($responses['reponses'])) {
      throw new \Exception('Format de réponses invalide');
    }

    if (count($responses['reponses']) !== 50) {
      throw new \Exception('Le test doit contenir exactement 50 réponses');
    }

    // Calculer les scores DISC
    $scores = $this->calculateDiscScoresFromLikert($responses['reponses']);
    
    // Déterminer le profil prédominant
    $profil_predominant = $this->getDominantProfile($scores);

    // Récupérer l'entreprise parente
    $company_id = $candidature->hasField('field_parent_company') ? 
      $candidature->get('field_parent_company')->target_id : null;

    // Créer le résultat DISC
    $disc_result_data = [
      'type' => 'disc_result',
      'title' => $this->generateDiscResultTitle($candidature, $profil_predominant),
      'field_disc_context' => 'candidature', // Contexte candidature
      'field_disc_completion_date' => date('Y-m-d'),
      'field_disc_score_d' => $scores['D'],
      'field_disc_score_i' => $scores['I'],
      'field_disc_score_s' => $scores['S'],
      'field_disc_score_c' => $scores['C'],
      'field_disc_predominant_profile' => $profil_predominant,
      'field_disc_detailed_answers' => json_encode([
        'scores_finaux' => $scores,
        'profil' => $profil_predominant,
        'date_passage' => date('Y-m-d H:i:s'),
        'version_test' => '50_questions_likert',
        'pourcentages' => [
          'D' => round(($scores['D'] / 50) * 100, 2), // Score max = 50
          'I' => round(($scores['I'] / 50) * 100, 2),
          'S' => round(($scores['S'] / 50) * 100, 2), 
          'C' => round(($scores['C'] / 50) * 100, 2),
        ]
      ]),
      'field_parent_company' => $company_id,
    ];

    $disc_result = Node::create($disc_result_data);
    $disc_result->save();

    // Lier le résultat à la candidature
    $candidature->set('field_candidate_disc_result', $disc_result->id());
    $candidature->save();

    // Préparer l'animation finale
    $animation_data = $this->prepareDiscAnimation($scores, $profil_predominant);

    return [
      'disc_result_id' => $disc_result->id(),
      'scores' => $scores,
      'profil_predominant' => $profil_predominant,
      'animation' => $animation_data,
      'message' => 'Test DISC terminé avec succès!',
      'prochaine_etape' => [
        'action' => 'candidature_complete',
        'description' => 'Votre candidature est maintenant complète. Vous serez contacté(e) si votre profil est retenu.',
      ],
    ];
  }

  /**
   * Calculer les scores DISC à partir des réponses Likert (1-4).
   */
  private function calculateDiscScoresFromLikert($responses) {
    $scores = ['D' => 0, 'I' => 0, 'S' => 0, 'C' => 0];

    // Mapping question + niveau → lettre
    $question_mapping = $this->getQuestionResponseMapping();
    
    foreach ($responses as $index => $response_value) {
      $question_num = $index + 1; // Questions 1-50
      $level = (int) $response_value; // 1, 2, 3 ou 4
      
      if (isset($question_mapping[$question_num][$level])) {
        $letter = $question_mapping[$question_num][$level];
        $scores[$letter] += 1; // Toujours +1 point
      }
    }
    
    return $scores;
  }


  /**
   * Mapping Question + Niveau → Lettre selon votre questionnaire.
   */
  private function getQuestionResponseMapping() {
    return [
      // Questions 1-10: Prise de décision et leadership
      1 => [1 => 'C', 2 => 'I', 3 => 'S', 4 => 'D'], // Je prends rapidement les choses en main
      2 => [1 => 'S', 2 => 'C', 3 => 'I', 4 => 'D'], // Je prends des décisions rapidement
      3 => [1 => 'S', 2 => 'C', 3 => 'I', 4 => 'D'], // Je préfère diriger un groupe
      4 => [1 => 'C', 2 => 'S', 3 => 'I', 4 => 'D'], // Je préfère agir vite
      5 => [1 => 'S', 2 => 'C', 3 => 'I', 4 => 'D'], // J'aime relever des défis
      6 => [1 => 'I', 2 => 'S', 3 => 'D', 4 => 'C'], // Décisions sur faits et analyse
      7 => [1 => 'D', 2 => 'I', 3 => 'S', 4 => 'C'], // Procédures établies vs improviser
      8 => [1 => 'D', 2 => 'C', 3 => 'S', 4 => 'I'], // Persuader vs donner des ordres
      9 => [1 => 'S', 2 => 'C', 3 => 'I', 4 => 'D'], // J'aime prendre des risques
      10 => [1 => 'C', 2 => 'S', 3 => 'D', 4 => 'I'], // Intuition vs analyse

      // Questions 11-20: Communication et relations aux autres
      11 => [1 => 'C', 2 => 'S', 3 => 'D', 4 => 'I'], // À l'aise avec inconnus
      12 => [1 => 'S', 2 => 'C', 3 => 'D', 4 => 'I'], // Exprimer idées et opinions
      13 => [1 => 'C', 2 => 'S', 3 => 'D', 4 => 'I'], // M'adapte facilement
      14 => [1 => 'I', 2 => 'D', 3 => 'C', 4 => 'S'], // Préfère écouter que parler
      15 => [1 => 'C', 2 => 'S', 3 => 'D', 4 => 'I'], // Encourager et motiver
      16 => [1 => 'D', 2 => 'I', 3 => 'C', 4 => 'S'], // Importance opinion des autres
      17 => [1 => 'C', 2 => 'S', 3 => 'I', 4 => 'D'], // M'exprime avec confiance
      18 => [1 => 'D', 2 => 'I', 3 => 'C', 4 => 'S'], // Éviter conflits
      19 => [1 => 'C', 2 => 'S', 3 => 'D', 4 => 'I'], // Facilement enthousiaste
      20 => [1 => 'D', 2 => 'C', 3 => 'I', 4 => 'S'], // Collaborer en équipe

      // Questions 21-30: Gestion des émotions et réactions au stress
      21 => [1 => 'I', 2 => 'S', 3 => 'C', 4 => 'D'], // Garde sang-froid sous pression
      22 => [1 => 'C', 2 => 'D', 3 => 'S', 4 => 'I'], // Du mal à cacher émotions
      23 => [1 => 'D', 2 => 'I', 3 => 'C', 4 => 'S'], // Éviter conflits autant que possible
      24 => [1 => 'S', 2 => 'C', 3 => 'I', 4 => 'D'], // Frustré par délais/imprévus
      25 => [1 => 'I', 2 => 'D', 3 => 'S', 4 => 'C'], // Prends temps de réfléchir
      26 => [1 => 'C', 2 => 'S', 3 => 'I', 4 => 'D'], // Rebondis rapidement après échec
      27 => [1 => 'D', 2 => 'I', 3 => 'C', 4 => 'S'], // Aime stabilité et prévisible
      28 => [1 => 'C', 2 => 'S', 3 => 'D', 4 => 'I'], // M'adapte aux changements
      29 => [1 => 'C', 2 => 'D', 3 => 'S', 4 => 'I'], // Importance reconnaissance
      30 => [1 => 'S', 2 => 'I', 3 => 'C', 4 => 'D'], // Suivre mon propre chemin

      // Questions 31-40: Organisation et gestion du travail
      31 => [1 => 'I', 2 => 'S', 3 => 'D', 4 => 'C'], // Très rigoureux dans travail
      32 => [1 => 'I', 2 => 'S', 3 => 'D', 4 => 'C'], // Préfère travailler seul
      33 => [1 => 'C', 2 => 'D', 3 => 'S', 4 => 'I'], // Tendance à remettre à plus tard
      34 => [1 => 'I', 2 => 'S', 3 => 'D', 4 => 'C'], // Aime planning précis
      35 => [1 => 'C', 2 => 'S', 3 => 'D', 4 => 'I'], // À l'aise avec improvisation
      36 => [1 => 'D', 2 => 'I', 3 => 'S', 4 => 'C'], // Prendre temps pour bien faire
      37 => [1 => 'S', 2 => 'I', 3 => 'D', 4 => 'C'], // Du mal à déléguer
      38 => [1 => 'S', 2 => 'I', 3 => 'C', 4 => 'D'], // Recherche améliorations
      39 => [1 => 'S', 2 => 'C', 3 => 'I', 4 => 'D'], // Plus efficace sous pression
      40 => [1 => 'I', 2 => 'S', 3 => 'D', 4 => 'C'], // Aime structurer environnement

      // Questions 41-50: Valeurs et motivation
      41 => [1 => 'S', 2 => 'C', 3 => 'I', 4 => 'D'], // Motivé par compétition
      42 => [1 => 'C', 2 => 'D', 3 => 'I', 4 => 'S'], // Importance relations humaines
      43 => [1 => 'C', 2 => 'S', 3 => 'D', 4 => 'I'], // Aime expérimenter nouvelles choses
      44 => [1 => 'I', 2 => 'S', 3 => 'D', 4 => 'C'], // Reconnu pour sérieux/expertise
      45 => [1 => 'C', 2 => 'S', 3 => 'D', 4 => 'I'], // Journées dynamiques et variées
      46 => [1 => 'I', 2 => 'S', 3 => 'D', 4 => 'C'], // Cadre structuré et réglementé
      47 => [1 => 'D', 2 => 'C', 3 => 'I', 4 => 'S'], // Aime aider et accompagner
      48 => [1 => 'S', 2 => 'I', 3 => 'C', 4 => 'D'], // Impact direct sur résultats
      49 => [1 => 'C', 2 => 'D', 3 => 'S', 4 => 'I'], // Reconnaissance sociale vs argent
      50 => [1 => 'S', 2 => 'I', 3 => 'C', 4 => 'D'], // Être indépendant
    ];
  }

  /**
   * Récupérer les questions du test DISC (50 questions selon votre format).
   */
  private function getDiscQuestions() {
    return [
      // 1-10: Prise de décision et leadership
      ['id' => 1, 'section' => 'Prise de décision et leadership', 'texte' => 'Je prends rapidement les choses en main face à un défi important.'],
      ['id' => 2, 'section' => 'Prise de décision et leadership', 'texte' => 'Je prends des décisions rapidement sans hésitation.'],
      ['id' => 3, 'section' => 'Prise de décision et leadership', 'texte' => 'Je préfère être celui/celle qui dirige un groupe.'],
      ['id' => 4, 'section' => 'Prise de décision et leadership', 'texte' => 'Face à un problème, je préfère agir vite plutôt que d\'attendre.'],
      ['id' => 5, 'section' => 'Prise de décision et leadership', 'texte' => 'J\'aime relever des défis et atteindre des objectifs ambitieux.'],
      ['id' => 6, 'section' => 'Prise de décision et leadership', 'texte' => 'Je prends mes décisions en m\'appuyant sur les faits et une analyse logique.'],
      ['id' => 7, 'section' => 'Prise de décision et leadership', 'texte' => 'Je préfère suivre des procédures établies plutôt que d\'improviser.'],
      ['id' => 8, 'section' => 'Prise de décision et leadership', 'texte' => 'Je préfère persuader les autres plutôt que de leur donner des ordres.'],
      ['id' => 9, 'section' => 'Prise de décision et leadership', 'texte' => 'J\'aime prendre des risques.'],
      ['id' => 10, 'section' => 'Prise de décision et leadership', 'texte' => 'Je me fie plus à mon intuition qu\'à une analyse approfondie.'],
      
      // 11-20: Communication et relations
      ['id' => 11, 'section' => 'Communication et relations aux autres', 'texte' => 'Je suis naturellement à l\'aise pour parler avec des inconnus.'],
      ['id' => 12, 'section' => 'Communication et relations aux autres', 'texte' => 'J\'aime exprimer mes idées et mes opinions.'],
      ['id' => 13, 'section' => 'Communication et relations aux autres', 'texte' => 'Je m\'adapte facilement à différents environnements.'],
      ['id' => 14, 'section' => 'Communication et relations aux autres', 'texte' => 'Je préfère écouter plutôt que parler.'],
      ['id' => 15, 'section' => 'Communication et relations aux autres', 'texte' => 'Je cherche souvent à encourager et motiver les autres.'],
      ['id' => 16, 'section' => 'Communication et relations aux autres', 'texte' => 'J\'accorde beaucoup d\'importance à l\'opinion des autres.'],
      ['id' => 17, 'section' => 'Communication et relations aux autres', 'texte' => 'Je m\'exprime avec confiance et énergie.'],
      ['id' => 18, 'section' => 'Communication et relations aux autres', 'texte' => 'Je préfère éviter les conflits et privilégier la bonne entente.'],
      ['id' => 19, 'section' => 'Communication et relations aux autres', 'texte' => 'Je suis facilement enthousiaste à propos de nouvelles idées.'],
      ['id' => 20, 'section' => 'Communication et relations aux autres', 'texte' => 'J\'aime collaborer en équipe plutôt que de travailler seul(e).'],
      
      // 21-30: Gestion émotions et stress
      ['id' => 21, 'section' => 'Gestion des émotions et réactions au stress', 'texte' => 'Je garde mon sang-froid sous la pression.'],
      ['id' => 22, 'section' => 'Gestion des émotions et réactions au stress', 'texte' => 'J\'ai du mal à cacher mes émotions.'],
      ['id' => 23, 'section' => 'Gestion des émotions et réactions au stress', 'texte' => 'Je préfère éviter les conflits autant que possible.'],
      ['id' => 24, 'section' => 'Gestion des émotions et réactions au stress', 'texte' => 'Je suis facilement frustré(e) par les délais ou les imprévus.'],
      ['id' => 25, 'section' => 'Gestion des émotions et réactions au stress', 'texte' => 'Je prends le temps de réfléchir avant d\'agir.'],
      ['id' => 26, 'section' => 'Gestion des émotions et réactions au stress', 'texte' => 'Je rebondis rapidement après un échec.'],
      ['id' => 27, 'section' => 'Gestion des émotions et réactions au stress', 'texte' => 'J\'aime que les choses restent stables et prévisibles.'],
      ['id' => 28, 'section' => 'Gestion des émotions et réactions au stress', 'texte' => 'Je m\'adapte facilement aux changements.'],
      ['id' => 29, 'section' => 'Gestion des émotions et réactions au stress', 'texte' => 'J\'accorde beaucoup d\'importance à la reconnaissance des autres.'],
      ['id' => 30, 'section' => 'Gestion des émotions et réactions au stress', 'texte' => 'Je préfère suivre mon propre chemin plutôt que celui des autres.'],
      
      // 31-40: Organisation et travail
      ['id' => 31, 'section' => 'Organisation et gestion du travail', 'texte' => 'Je suis très rigoureux(se) dans mon travail.'],
      ['id' => 32, 'section' => 'Organisation et gestion du travail', 'texte' => 'Je préfère travailler seul(e) plutôt qu\'en groupe.'],
      ['id' => 33, 'section' => 'Organisation et gestion du travail', 'texte' => 'J\'ai tendance à remettre les choses à plus tard.'],
      ['id' => 34, 'section' => 'Organisation et gestion du travail', 'texte' => 'J\'aime suivre un planning précis et structuré.'],
      ['id' => 35, 'section' => 'Organisation et gestion du travail', 'texte' => 'Je suis à l\'aise avec l\'improvisation.'],
      ['id' => 36, 'section' => 'Organisation et gestion du travail', 'texte' => 'Je préfère prendre mon temps pour faire les choses correctement.'],
      ['id' => 37, 'section' => 'Organisation et gestion du travail', 'texte' => 'J\'ai du mal à déléguer des tâches.'],
      ['id' => 38, 'section' => 'Organisation et gestion du travail', 'texte' => 'Je suis toujours à la recherche d\'améliorations et d\'optimisation.'],
      ['id' => 39, 'section' => 'Organisation et gestion du travail', 'texte' => 'Je suis plus efficace sous pression.'],
      ['id' => 40, 'section' => 'Organisation et gestion du travail', 'texte' => 'J\'aime structurer mon environnement de travail.'],
      
      // 41-50: Valeurs et motivation
      ['id' => 41, 'section' => 'Valeurs et motivation', 'texte' => 'Je suis motivé(e) par la compétition et les résultats.'],
      ['id' => 42, 'section' => 'Valeurs et motivation', 'texte' => 'J\'accorde beaucoup d\'importance aux relations humaines.'],
      ['id' => 43, 'section' => 'Valeurs et motivation', 'texte' => 'J\'aime expérimenter de nouvelles choses.'],
      ['id' => 44, 'section' => 'Valeurs et motivation', 'texte' => 'Je préfère être reconnu(e) pour mon sérieux et mon expertise.'],
      ['id' => 45, 'section' => 'Valeurs et motivation', 'texte' => 'J\'aime que mes journées soient dynamiques et variées.'],
      ['id' => 46, 'section' => 'Valeurs et motivation', 'texte' => 'Je suis plus à l\'aise dans un cadre structuré et réglementé.'],
      ['id' => 47, 'section' => 'Valeurs et motivation', 'texte' => 'J\'aime aider et accompagner les autres.'],
      ['id' => 48, 'section' => 'Valeurs et motivation', 'texte' => 'J\'aime avoir un impact direct et visible sur les résultats.'],
      ['id' => 49, 'section' => 'Valeurs et motivation', 'texte' => 'Je me sens plus motivé(e) par la reconnaissance sociale que par l\'argent.'],
      ['id' => 50, 'section' => 'Valeurs et motivation', 'texte' => 'Je préfère être indépendant(e) et prendre mes propres décisions.'],
    ];
  }

  /**
   * Déterminer le profil DISC prédominant.
   */
  private function getDominantProfile($scores) {
    $max_score = max($scores);
    $dominant_profiles = [];
    
    foreach ($scores as $profile => $score) {
      if ($score === $max_score) {
        $dominant_profiles[] = $profile;
      }
    }
    
    // Si égalité, retourner une combinaison
    if (count($dominant_profiles) === 1) {
      return $dominant_profiles[0];
    } else {
      return implode('', $dominant_profiles);
    }
  }

  /**
   * Générer un titre pour le résultat DISC.
   */
  private function generateDiscResultTitle($candidature, $profil) {
    $nom = $candidature->get('field_candidate_firstname')->value . ' ' . 
           $candidature->get('field_candidate_lastname')->value;
    
    return "Résultat DISC de {$nom} - Profil {$profil}";
  }

  /**
   * Préparer l'animation finale du test DISC.
   */
  private function prepareDiscAnimation($scores, $profil) {
    $profil_descriptions = [
      'D' => [
        'nom' => 'Dominant',
        'couleur' => '#FF6B6B',
        'caracteristiques' => ['Décisif', 'Direct', 'Orienté résultats', 'Compétitif'],
        'description' => 'Vous êtes une personne d\'action qui aime prendre des décisions rapidement et obtenir des résultats.'
      ],
      'I' => [
        'nom' => 'Influent',
        'couleur' => '#4ECDC4',
        'caracteristiques' => ['Sociable', 'Optimiste', 'Persuasif', 'Enthousiaste'],
        'description' => 'Vous excellez dans les relations humaines et savez motiver les autres par votre enthousiasme.'
      ],
      'S' => [
        'nom' => 'Stable',
        'couleur' => '#45B7D1',
        'caracteristiques' => ['Patient', 'Loyal', 'Coopératif', 'Fiable'],
        'description' => 'Vous apportez stabilité et soutien à votre équipe, privilégiant l\'harmonie et la collaboration.'
      ],
      'C' => [
        'nom' => 'Consciencieux',
        'couleur' => '#96CEB4',
        'caracteristiques' => ['Analytique', 'Précis', 'Méthodique', 'Rigoureux'],
        'description' => 'Vous excellez dans l\'analyse et la précision, garantissant la qualité du travail accompli.'
      ],
    ];

    // Animation avec jauges progressives
    $animation_steps = [];
    foreach (['D', 'I', 'S', 'C'] as $type) {
      $animation_steps[] = [
        'type' => $type,
        'nom' => $profil_descriptions[$type]['nom'],
        'couleur' => $profil_descriptions[$type]['couleur'],
        'score' => $scores[$type],
        'pourcentage' => round(min(100, ($scores[$type] / 50) * 100), 2), // Score max = 50
        'is_dominant' => strpos($profil, $type) !== false,
      ];
    }

    return [
      'etapes' => $animation_steps,
      'profil_principal' => [
        'code' => $profil,
        'nom' => isset($profil_descriptions[$profil]) ? $profil_descriptions[$profil]['nom'] : 'Profil mixte',
        'couleur' => isset($profil_descriptions[$profil]) ? $profil_descriptions[$profil]['couleur'] : '#666666',
        'description' => isset($profil_descriptions[$profil]) ? $profil_descriptions[$profil]['description'] : 'Vous présentez un profil équilibré avec plusieurs dominantes.',
      ],
      'roulement_tambour' => true, // Active l'animation de suspense
      'duree_animation' => 5000, // 5 secondes
    ];
  }
}