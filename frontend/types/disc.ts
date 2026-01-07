export interface DiscQuestion {
  question: string
  category: string
  options: {
    text: string
    color: 'D' | 'I' | 'S' | 'C'
  }[]
}

export const DISC_QUESTIONS: DiscQuestion[] = [
  // 1-10 Prise de décision et leadership
  {
    question: 'Je prends rapidement les choses en main face à un défi important.',
    category: 'Prise de décision et leadership',
    options: [
      { text: 'Pas du tout d\'accord', color: 'C' },
      { text: 'Partiellement d\'accord', color: 'I' },
      { text: 'Plutôt d\'accord', color: 'S' },
      { text: 'Vraiment d\'accord', color: 'D' }
    ]
  },
  {
    question: 'Je prends des décisions rapidement sans hésitation.',
    category: 'Prise de décision et leadership',
    options: [
      { text: 'Pas du tout d\'accord', color: 'S' },
      { text: 'Partiellement d\'accord', color: 'C' },
      { text: 'Plutôt d\'accord', color: 'I' },
      { text: 'Vraiment d\'accord', color: 'D' }
    ]
  },
  {
    question: 'Je préfère être celui/celle qui dirige un groupe.',
    category: 'Prise de décision et leadership',
    options: [
      { text: 'Pas du tout d\'accord', color: 'S' },
      { text: 'Partiellement d\'accord', color: 'C' },
      { text: 'Plutôt d\'accord', color: 'I' },
      { text: 'Vraiment d\'accord', color: 'D' }
    ]
  },
  {
    question: 'Face à un problème, je préfère agir vite plutôt que d\'attendre.',
    category: 'Prise de décision et leadership',
    options: [
      { text: 'Pas du tout d\'accord', color: 'C' },
      { text: 'Partiellement d\'accord', color: 'S' },
      { text: 'Plutôt d\'accord', color: 'I' },
      { text: 'Vraiment d\'accord', color: 'D' }
    ]
  },
  {
    question: 'J\'aime relever des défis et atteindre des objectifs ambitieux.',
    category: 'Prise de décision et leadership',
    options: [
      { text: 'Pas du tout d\'accord', color: 'S' },
      { text: 'Partiellement d\'accord', color: 'C' },
      { text: 'Plutôt d\'accord', color: 'I' },
      { text: 'Vraiment d\'accord', color: 'D' }
    ]
  },
  {
    question: 'Je prends mes décisions en m\'appuyant sur les faits et une analyse logique.',
    category: 'Prise de décision et leadership',
    options: [
      { text: 'Pas du tout d\'accord', color: 'I' },
      { text: 'Partiellement d\'accord', color: 'S' },
      { text: 'Plutôt d\'accord', color: 'D' },
      { text: 'Vraiment d\'accord', color: 'C' }
    ]
  },
  {
    question: 'Je préfère suivre des procédures établies plutôt que d\'improviser.',
    category: 'Prise de décision et leadership',
    options: [
      { text: 'Pas du tout d\'accord', color: 'D' },
      { text: 'Partiellement d\'accord', color: 'I' },
      { text: 'Plutôt d\'accord', color: 'S' },
      { text: 'Vraiment d\'accord', color: 'C' }
    ]
  },
  {
    question: 'Je préfère persuader les autres plutôt que de leur donner des ordres.',
    category: 'Prise de décision et leadership',
    options: [
      { text: 'Pas du tout d\'accord', color: 'D' },
      { text: 'Partiellement d\'accord', color: 'C' },
      { text: 'Plutôt d\'accord', color: 'S' },
      { text: 'Vraiment d\'accord', color: 'I' }
    ]
  },
  {
    question: 'J\'aime prendre des risques.',
    category: 'Prise de décision et leadership',
    options: [
      { text: 'Pas du tout d\'accord', color: 'S' },
      { text: 'Partiellement d\'accord', color: 'C' },
      { text: 'Plutôt d\'accord', color: 'I' },
      { text: 'Vraiment d\'accord', color: 'D' }
    ]
  },
  {
    question: 'Je me fie plus à mon intuition qu\'à une analyse approfondie.',
    category: 'Prise de décision et leadership',
    options: [
      { text: 'Pas du tout d\'accord', color: 'C' },
      { text: 'Partiellement d\'accord', color: 'S' },
      { text: 'Plutôt d\'accord', color: 'D' },
      { text: 'Vraiment d\'accord', color: 'I' }
    ]
  },
  // 11-20 Communication et relations aux autres
  {
    question: 'Je suis naturellement à l\'aise pour parler avec des inconnus.',
    category: 'Communication et relations aux autres',
    options: [
      { text: 'Pas du tout d\'accord', color: 'C' },
      { text: 'Partiellement d\'accord', color: 'S' },
      { text: 'Plutôt d\'accord', color: 'D' },
      { text: 'Vraiment d\'accord', color: 'I' }
    ]
  },
  {
    question: 'J\'aime exprimer mes idées et mes opinions.',
    category: 'Communication et relations aux autres',
    options: [
      { text: 'Pas du tout d\'accord', color: 'S' },
      { text: 'Partiellement d\'accord', color: 'C' },
      { text: 'Plutôt d\'accord', color: 'D' },
      { text: 'Vraiment d\'accord', color: 'I' }
    ]
  },
  {
    question: 'Je m\'adapte facilement à différents environnements.',
    category: 'Communication et relations aux autres',
    options: [
      { text: 'Pas du tout d\'accord', color: 'C' },
      { text: 'Partiellement d\'accord', color: 'S' },
      { text: 'Plutôt d\'accord', color: 'D' },
      { text: 'Vraiment d\'accord', color: 'I' }
    ]
  },
  {
    question: 'Je préfère écouter plutôt que parler.',
    category: 'Communication et relations aux autres',
    options: [
      { text: 'Pas du tout d\'accord', color: 'I' },
      { text: 'Partiellement d\'accord', color: 'D' },
      { text: 'Plutôt d\'accord', color: 'C' },
      { text: 'Vraiment d\'accord', color: 'S' }
    ]
  },
  {
    question: 'Je cherche souvent à encourager et motiver les autres.',
    category: 'Communication et relations aux autres',
    options: [
      { text: 'Pas du tout d\'accord', color: 'C' },
      { text: 'Partiellement d\'accord', color: 'S' },
      { text: 'Plutôt d\'accord', color: 'D' },
      { text: 'Vraiment d\'accord', color: 'I' }
    ]
  },
  {
    question: 'J\'accorde beaucoup d\'importance à l\'opinion des autres.',
    category: 'Communication et relations aux autres',
    options: [
      { text: 'Pas du tout d\'accord', color: 'D' },
      { text: 'Partiellement d\'accord', color: 'I' },
      { text: 'Plutôt d\'accord', color: 'C' },
      { text: 'Vraiment d\'accord', color: 'S' }
    ]
  },
  {
    question: 'Je m\'exprime avec confiance et énergie.',
    category: 'Communication et relations aux autres',
    options: [
      { text: 'Pas du tout d\'accord', color: 'C' },
      { text: 'Partiellement d\'accord', color: 'S' },
      { text: 'Plutôt d\'accord', color: 'I' },
      { text: 'Vraiment d\'accord', color: 'D' }
    ]
  },
  {
    question: 'Je préfère éviter les conflits et privilégier la bonne entente.',
    category: 'Communication et relations aux autres',
    options: [
      { text: 'Pas du tout d\'accord', color: 'D' },
      { text: 'Partiellement d\'accord', color: 'I' },
      { text: 'Plutôt d\'accord', color: 'C' },
      { text: 'Vraiment d\'accord', color: 'S' }
    ]
  },
  {
    question: 'Je suis facilement enthousiaste à propos de nouvelles idées.',
    category: 'Communication et relations aux autres',
    options: [
      { text: 'Pas du tout d\'accord', color: 'C' },
      { text: 'Partiellement d\'accord', color: 'S' },
      { text: 'Plutôt d\'accord', color: 'D' },
      { text: 'Vraiment d\'accord', color: 'I' }
    ]
  },
  {
    question: 'J\'aime collaborer en équipe plutôt que de travailler seul(e).',
    category: 'Communication et relations aux autres',
    options: [
      { text: 'Pas du tout d\'accord', color: 'D' },
      { text: 'Partiellement d\'accord', color: 'C' },
      { text: 'Plutôt d\'accord', color: 'I' },
      { text: 'Vraiment d\'accord', color: 'S' }
    ]
  },
  // 21-30 Gestion des émotions et réactions au stress
  {
    question: 'Je garde mon sang-froid sous la pression.',
    category: 'Gestion des émotions et réactions au stress',
    options: [
      { text: 'Pas du tout d\'accord', color: 'I' },
      { text: 'Partiellement d\'accord', color: 'S' },
      { text: 'Plutôt d\'accord', color: 'C' },
      { text: 'Vraiment d\'accord', color: 'D' }
    ]
  },
  {
    question: 'J\'ai du mal à cacher mes émotions.',
    category: 'Gestion des émotions et réactions au stress',
    options: [
      { text: 'Pas du tout d\'accord', color: 'C' },
      { text: 'Partiellement d\'accord', color: 'D' },
      { text: 'Plutôt d\'accord', color: 'S' },
      { text: 'Vraiment d\'accord', color: 'I' }
    ]
  },
  {
    question: 'Je préfère éviter les conflits autant que possible.',
    category: 'Gestion des émotions et réactions au stress',
    options: [
      { text: 'Pas du tout d\'accord', color: 'D' },
      { text: 'Partiellement d\'accord', color: 'I' },
      { text: 'Plutôt d\'accord', color: 'C' },
      { text: 'Vraiment d\'accord', color: 'S' }
    ]
  },
  {
    question: 'Je suis facilement frustré(e) par les délais ou les imprévus.',
    category: 'Gestion des émotions et réactions au stress',
    options: [
      { text: 'Pas du tout d\'accord', color: 'S' },
      { text: 'Partiellement d\'accord', color: 'C' },
      { text: 'Plutôt d\'accord', color: 'I' },
      { text: 'Vraiment d\'accord', color: 'D' }
    ]
  },
  {
    question: 'Je prends le temps de réfléchir avant d\'agir.',
    category: 'Gestion des émotions et réactions au stress',
    options: [
      { text: 'Pas du tout d\'accord', color: 'I' },
      { text: 'Partiellement d\'accord', color: 'D' },
      { text: 'Plutôt d\'accord', color: 'S' },
      { text: 'Vraiment d\'accord', color: 'C' }
    ]
  },
  {
    question: 'Je rebondis rapidement après un échec.',
    category: 'Gestion des émotions et réactions au stress',
    options: [
      { text: 'Pas du tout d\'accord', color: 'C' },
      { text: 'Partiellement d\'accord', color: 'S' },
      { text: 'Plutôt d\'accord', color: 'I' },
      { text: 'Vraiment d\'accord', color: 'D' }
    ]
  },
  {
    question: 'J\'aime que les choses restent stables et prévisibles.',
    category: 'Gestion des émotions et réactions au stress',
    options: [
      { text: 'Pas du tout d\'accord', color: 'D' },
      { text: 'Partiellement d\'accord', color: 'I' },
      { text: 'Plutôt d\'accord', color: 'C' },
      { text: 'Vraiment d\'accord', color: 'S' }
    ]
  },
  {
    question: 'Je m\'adapte facilement aux changements.',
    category: 'Gestion des émotions et réactions au stress',
    options: [
      { text: 'Pas du tout d\'accord', color: 'C' },
      { text: 'Partiellement d\'accord', color: 'S' },
      { text: 'Plutôt d\'accord', color: 'D' },
      { text: 'Vraiment d\'accord', color: 'I' }
    ]
  },
  {
    question: 'J\'accorde beaucoup d\'importance à la reconnaissance des autres.',
    category: 'Gestion des émotions et réactions au stress',
    options: [
      { text: 'Pas du tout d\'accord', color: 'C' },
      { text: 'Partiellement d\'accord', color: 'D' },
      { text: 'Plutôt d\'accord', color: 'S' },
      { text: 'Vraiment d\'accord', color: 'I' }
    ]
  },
  {
    question: 'Je préfère suivre mon propre chemin plutôt que celui des autres.',
    category: 'Gestion des émotions et réactions au stress',
    options: [
      { text: 'Pas du tout d\'accord', color: 'S' },
      { text: 'Partiellement d\'accord', color: 'I' },
      { text: 'Plutôt d\'accord', color: 'C' },
      { text: 'Vraiment d\'accord', color: 'D' }
    ]
  },
  // 31-40 Organisation et gestion du travail
  {
    question: 'Je suis très rigoureux(se) dans mon travail.',
    category: 'Organisation et gestion du travail',
    options: [
      { text: 'Pas du tout d\'accord', color: 'I' },
      { text: 'Partiellement d\'accord', color: 'S' },
      { text: 'Plutôt d\'accord', color: 'D' },
      { text: 'Vraiment d\'accord', color: 'C' }
    ]
  },
  {
    question: 'Je préfère travailler seul(e) plutôt qu\'en groupe.',
    category: 'Organisation et gestion du travail',
    options: [
      { text: 'Pas du tout d\'accord', color: 'I' },
      { text: 'Partiellement d\'accord', color: 'S' },
      { text: 'Plutôt d\'accord', color: 'D' },
      { text: 'Vraiment d\'accord', color: 'C' }
    ]
  },
  {
    question: 'J\'ai tendance à remettre les choses à plus tard.',
    category: 'Organisation et gestion du travail',
    options: [
      { text: 'Pas du tout d\'accord', color: 'C' },
      { text: 'Partiellement d\'accord', color: 'D' },
      { text: 'Plutôt d\'accord', color: 'S' },
      { text: 'Vraiment d\'accord', color: 'I' }
    ]
  },
  {
    question: 'J\'aime suivre un planning précis et structuré.',
    category: 'Organisation et gestion du travail',
    options: [
      { text: 'Pas du tout d\'accord', color: 'I' },
      { text: 'Partiellement d\'accord', color: 'S' },
      { text: 'Plutôt d\'accord', color: 'D' },
      { text: 'Vraiment d\'accord', color: 'C' }
    ]
  },
  {
    question: 'Je suis à l\'aise avec l\'improvisation.',
    category: 'Organisation et gestion du travail',
    options: [
      { text: 'Pas du tout d\'accord', color: 'C' },
      { text: 'Partiellement d\'accord', color: 'S' },
      { text: 'Plutôt d\'accord', color: 'D' },
      { text: 'Vraiment d\'accord', color: 'I' }
    ]
  },
  {
    question: 'Je préfère prendre mon temps pour faire les choses correctement.',
    category: 'Organisation et gestion du travail',
    options: [
      { text: 'Pas du tout d\'accord', color: 'D' },
      { text: 'Partiellement d\'accord', color: 'I' },
      { text: 'Plutôt d\'accord', color: 'S' },
      { text: 'Vraiment d\'accord', color: 'C' }
    ]
  },
  {
    question: 'J\'ai du mal à déléguer des tâches.',
    category: 'Organisation et gestion du travail',
    options: [
      { text: 'Pas du tout d\'accord', color: 'S' },
      { text: 'Partiellement d\'accord', color: 'I' },
      { text: 'Plutôt d\'accord', color: 'D' },
      { text: 'Vraiment d\'accord', color: 'C' }
    ]
  },
  {
    question: 'Je suis toujours à la recherche d\'améliorations et d\'optimisation.',
    category: 'Organisation et gestion du travail',
    options: [
      { text: 'Pas du tout d\'accord', color: 'S' },
      { text: 'Partiellement d\'accord', color: 'I' },
      { text: 'Plutôt d\'accord', color: 'C' },
      { text: 'Vraiment d\'accord', color: 'D' }
    ]
  },
  {
    question: 'Je suis plus efficace sous pression.',
    category: 'Organisation et gestion du travail',
    options: [
      { text: 'Pas du tout d\'accord', color: 'S' },
      { text: 'Partiellement d\'accord', color: 'C' },
      { text: 'Plutôt d\'accord', color: 'I' },
      { text: 'Vraiment d\'accord', color: 'D' }
    ]
  },
  {
    question: 'J\'aime structurer mon environnement de travail.',
    category: 'Organisation et gestion du travail',
    options: [
      { text: 'Pas du tout d\'accord', color: 'I' },
      { text: 'Partiellement d\'accord', color: 'S' },
      { text: 'Plutôt d\'accord', color: 'D' },
      { text: 'Vraiment d\'accord', color: 'C' }
    ]
  },
  // 41-50 Valeurs et motivation
  {
    question: 'Je suis motivé(e) par la compétition et les résultats.',
    category: 'Valeurs et motivation',
    options: [
      { text: 'Pas du tout d\'accord', color: 'S' },
      { text: 'Partiellement d\'accord', color: 'C' },
      { text: 'Plutôt d\'accord', color: 'I' },
      { text: 'Vraiment d\'accord', color: 'D' }
    ]
  },
  {
    question: 'J\'accorde beaucoup d\'importance aux relations humaines.',
    category: 'Valeurs et motivation',
    options: [
      { text: 'Pas du tout d\'accord', color: 'C' },
      { text: 'Partiellement d\'accord', color: 'D' },
      { text: 'Plutôt d\'accord', color: 'I' },
      { text: 'Vraiment d\'accord', color: 'S' }
    ]
  },
  {
    question: 'J\'aime expérimenter de nouvelles choses.',
    category: 'Valeurs et motivation',
    options: [
      { text: 'Pas du tout d\'accord', color: 'C' },
      { text: 'Partiellement d\'accord', color: 'S' },
      { text: 'Plutôt d\'accord', color: 'D' },
      { text: 'Vraiment d\'accord', color: 'I' }
    ]
  },
  {
    question: 'Je préfère être reconnu(e) pour mon sérieux et mon expertise.',
    category: 'Valeurs et motivation',
    options: [
      { text: 'Pas du tout d\'accord', color: 'I' },
      { text: 'Partiellement d\'accord', color: 'S' },
      { text: 'Plutôt d\'accord', color: 'D' },
      { text: 'Vraiment d\'accord', color: 'C' }
    ]
  },
  {
    question: 'J\'aime que mes journées soient dynamiques et variées.',
    category: 'Valeurs et motivation',
    options: [
      { text: 'Pas du tout d\'accord', color: 'C' },
      { text: 'Partiellement d\'accord', color: 'S' },
      { text: 'Plutôt d\'accord', color: 'D' },
      { text: 'Vraiment d\'accord', color: 'I' }
    ]
  },
  {
    question: 'Je suis plus à l\'aise dans un cadre structuré et réglementé.',
    category: 'Valeurs et motivation',
    options: [
      { text: 'Pas du tout d\'accord', color: 'I' },
      { text: 'Partiellement d\'accord', color: 'S' },
      { text: 'Plutôt d\'accord', color: 'D' },
      { text: 'Vraiment d\'accord', color: 'C' }
    ]
  },
  {
    question: 'J\'aime aider et accompagner les autres.',
    category: 'Valeurs et motivation',
    options: [
      { text: 'Pas du tout d\'accord', color: 'D' },
      { text: 'Partiellement d\'accord', color: 'C' },
      { text: 'Plutôt d\'accord', color: 'I' },
      { text: 'Vraiment d\'accord', color: 'S' }
    ]
  },
  {
    question: 'J\'aime avoir un impact direct et visible sur les résultats.',
    category: 'Valeurs et motivation',
    options: [
      { text: 'Pas du tout d\'accord', color: 'S' },
      { text: 'Partiellement d\'accord', color: 'I' },
      { text: 'Plutôt d\'accord', color: 'C' },
      { text: 'Vraiment d\'accord', color: 'D' }
    ]
  },
  {
    question: 'Je me sens plus motivé(e) par la reconnaissance sociale que par l\'argent.',
    category: 'Valeurs et motivation',
    options: [
      { text: 'Pas du tout d\'accord', color: 'C' },
      { text: 'Partiellement d\'accord', color: 'D' },
      { text: 'Plutôt d\'accord', color: 'S' },
      { text: 'Vraiment d\'accord', color: 'I' }
    ]
  },
  {
    question: 'Je préfère être indépendant(e) et prendre mes propres décisions.',
    category: 'Valeurs et motivation',
    options: [
      { text: 'Pas du tout d\'accord', color: 'S' },
      { text: 'Partiellement d\'accord', color: 'I' },
      { text: 'Plutôt d\'accord', color: 'C' },
      { text: 'Vraiment d\'accord', color: 'D' }
    ]
  }
]
