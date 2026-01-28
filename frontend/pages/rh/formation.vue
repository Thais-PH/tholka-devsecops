<template>
  <div class="flex flex-col w-full h-screen bg-secondary-300 overflow-hidden">
    <!-- Navbar -->
    <OrganismsNavbar
      variant="rh"
      :is-sidebar-open="isSidebarOpen"
      @toggle-sidebar="isSidebarOpen = !isSidebarOpen"
    />

    <!-- Main Layout -->
    <div class="flex flex-1 overflow-hidden pt-[82.73px]">
      <!-- Overlay mobile -->
      <div
        v-if="isSidebarOpen"
        class="fixed inset-0 bg-black/50 z-40 lg:hidden"
        @click="isSidebarOpen = false"
      ></div>

      <!-- Sidebar Mini -->
      <OrganismsSidebarMini
        class="fixed top-[82.73px] left-0 h-[calc(100vh-82.73px)] z-50 transition-transform duration-300 transform -translate-x-full lg:translate-x-0 lg:static lg:h-auto"
        :class="{ 'translate-x-0': isSidebarOpen }"
        variant="rh"
        active-item="formation"
        @navigate="handleNavigation"
      />

      <!-- Main Content -->
      <main class="flex-1 overflow-y-auto hide-scrollbar">
        
        <!-- Hero Section -->
        <section class="relative w-full overflow-hidden">
          <!-- Background Image + Gradient -->
          <div
            class="absolute inset-0 z-0"
            style="background: linear-gradient(180deg, rgba(37, 41, 88, 0.00) 84.05%, var(--Colors-Primary-700, #252958) 100%), linear-gradient(180deg, var(--Colors-Primary-900, rgba(5, 13, 46, 0.50)) 6.14%, var(--Colors-Primary-900, rgba(5, 13, 46, 0.50)) 22.26%, rgba(5, 13, 46, 0.00) 42.57%, rgba(5, 13, 46, 0.00) 42.57%), linear-gradient(90deg, rgba(5, 13, 46, 0.80) 0%, rgba(5, 13, 46, 0.80) 44.23%, rgba(5, 13, 46, 0.00) 99.99%, rgba(5, 13, 46, 0.00) 100%), url('/annonces/background-formation.jpg') no-repeat center / cover;"
          ></div>

          <!-- Hero Content -->
          <div class="relative z-10 flex flex-col md:flex-row justify-between items-start gap-6 px-6 md:px-16 lg:px-24 py-10 md:py-16 lg:py-24">
            <!-- Left Content -->
            <div class="flex flex-col items-start gap-4 max-w-2xl">
              <!-- Nouveau Tag -->
              <AtomsTag variant="solid" color="orange" size="md">
                Nouveau
              </AtomsTag>

              <!-- Title -->
              <h2 class="text-h2 md:text-[40px] font-sans font-bold text-Light leading-tight">
                Découvrez notre parcours manager
              </h2>

              <!-- Description -->
              <p class="text-lg md:text-xl font-roboto font-normal text-Light/90 leading-relaxed">
                Un parcours conçu pour accompagner les collaborateurs qui souhaitent évoluer vers un rôle managérial. À travers des capsules pratiques et progressives, il développe les bases essentielles : posture, communication, gestion d’équipe et prise de décision.
              </p>

              <!-- Tags Row -->
              <div class="flex flex-wrap items-center gap-3 mt-2">
                <AtomsTag variant="soft" color="white" size="lg">
                  Management & Leadership
                </AtomsTag>
                <AtomsTag variant="soft" color="white" size="lg">
                  Ressources humaines
                </AtomsTag>
              </div>

              <!-- CTA Button -->
              <AtomsButton variant="primary" size="md" class="mt-4">
                Voir le parcours
              </AtomsButton>
            </div>

            <!-- Right Content: Nouvelle Formation Button -->
            <div class="flex-shrink-0">
              <AtomsButton variant="primary" size="md">
                <template #icon-left>
                  <LucidePlus :size="20" :stroke-width="1" />
                </template>
                Nouvelle formation
              </AtomsButton>
            </div>
          </div>
        </section>

        <!-- Secondary Menu / Filter Bar -->
        <section class="relative w-full min-h-[54px] bg-primary-700 z-20 flex items-center px-4 md:px-16 lg:px-24 py-2 md:py-0">
          <!-- Conteneur scrollable sur mobile, aligné à droite sur desktop -->
          <div class="w-full md:overflow-visible md:flex md:justify-end">
            <MoleculesFilterBar 
              :filters="formationFilters"
              variant="dark"
              @update-filter="handleFormationFilterUpdate"
              @apply-filter="handleFormationFilterApply"
            />
          </div>
        </section>

        <!-- Main Body Content -->
        <div class="relative z-10 flex flex-col gap-16 md:gap-20 px-6 md:px-16 lg:px-24 py-10 md:py-16">
          
          <!-- Section: Top 5 des capsules les + suivies -->
          <section v-if="showTopCapsules" class="w-full">
            <h3 class="text-h3 text-primary-500 mb-6 md:mb-10">
              Top 5 des capsules les + suivies
            </h3>
            
            <!-- Horizontal Scroll Container -->
            <div class="flex overflow-x-auto pb-4 gap-24 hide-scrollbar">
              <MoleculesCard 
                v-for="(capsule, index) in filteredTopCapsules"
                :key="`top-${index}`"
                type="job"
                :order-number="index + 1"
                :title="capsule.title"
                :contract-type="capsule.tag"
                :image-url="capsule.imageUrl"
                :description="capsule.resume"
                :has-video="capsule.hasVideo"
                :has-sound="capsule.hasSound"
                :has-article="capsule.hasArticle"
                :has-list="capsule.hasList"
                class="flex-shrink-0 first:ml-[58px]"
              />
            </div>
          </section>

          <!-- Section: Nos parcours de formation -->
          <section v-if="showParcours" class="w-full">
            <h3 class="text-h3 text-primary-500 mb-6 md:mb-10">
              Nos parcours de formation
            </h3>
            
            <!-- Horizontal Scroll Container -->
            <div class="flex overflow-x-auto pb-4 gap-6 md:gap-10 hide-scrollbar">
              <MoleculesCard 
                v-for="(parcours, index) in filteredParcours"
                :key="`parcours-${index}`"
                type="job"
                :title="parcours.title"
                :contract-type="parcours.tag"
                :image-url="parcours.imageUrl"
                :description="parcours.resume"
                :has-video="parcours.hasVideo"
                :has-sound="parcours.hasSound"
                :has-article="parcours.hasArticle"
                :has-list="parcours.hasList"
                class="flex-shrink-0"
              />
            </div>
          </section>

          <!-- Section: Nos capsules de savoir -->
          <section v-if="showCapsules" class="w-full">
            <h3 class="text-h3 text-primary-500 mb-6 md:mb-10">
              Nos capsules de savoir
            </h3>
            
            <!-- Horizontal Scroll Container -->
            <div class="flex overflow-x-auto pb-4 gap-6 md:gap-10 hide-scrollbar">
              <MoleculesCard 
                v-for="(capsule, index) in filteredCapsules"
                :key="`capsule-${index}`"
                type="job"
                :title="capsule.title"
                :contract-type="capsule.tag"
                :image-url="capsule.imageUrl"
                :description="capsule.resume"
                :has-video="capsule.hasVideo"
                :has-sound="capsule.hasSound"
                :has-article="capsule.hasArticle"
                :has-list="capsule.hasList"
                class="flex-shrink-0"
              />
            </div>
          </section>

        </div>
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Plus as LucidePlus } from 'lucide-vue-next'
import { useRouter } from 'vue-router'

useHead({
  title: 'Formation - Tholka RH',
})

const router = useRouter()

// État de la sidebar mobile (pour la navbar)
const isSidebarOpen = ref(false)

// Navigation depuis la sidebar mini
const handleNavigation = (itemId) => {
  const routes = {
    accueil: '/rh',
    equipe: '/rh/equipe',
    recrutement: '/rh/recrutement',
    mobilite: '/rh/mobilite',
    bienetre: '/rh/bienetre',
    administration: '/rh/administration',
    remuneration: '/rh/remuneration',
    formation: '/rh/formation'
  }
  if (routes[itemId]) {
    router.push(routes[itemId])
  }
}

// Gestion des filtres
const formationFilters = ref([
  {
    id: 'category',
    label: 'Catégorie',
    value: [],
    options: [
      { id: 'management', label: 'Management & Leadership' },
      { id: 'comportemental', label: 'Compétences comportementales' },
      { id: 'performance', label: 'Performance & Organisation' },
      { id: 'outils', label: 'Outils & pratiques' },
      { id: 'rh', label: 'Ressources Humaines' },
      { id: 'metier', label: 'Compétences métier' },
      { id: 'developpement', label: 'Développement personnel' },
      { id: 'culture', label: 'Culture & valeurs de l\'entreprise' }
    ]
  },
  {
    id: 'type',
    label: 'Type de formation',
    value: [],
    options: [
      { id: 'capsule', label: 'Capsule de savoir' },
      { id: 'parcours', label: 'Parcours de formation' },
    ]
  },
  {
    id: 'modality',
    label: 'Modalité',
    value: [],
    options: [
      { id: 'in-person', label: 'Présentiel' },
      { id: 'remote', label: 'Distanciel' },
      { id: 'e-learning', label: 'E-learning' },
    ]
  }
])

const handleFormationFilterUpdate = ({ id, value }) => {
  const filter = formationFilters.value.find(f => f.id === id)
  if (filter) {
    filter.value = value
  }
}

// Fonction utilitaire pour vérifier si un item correspond aux filtres
const checkFilters = (item, type) => {
  const categoryFilter = formationFilters.value.find(f => f.id === 'category')
  const modalityFilter = formationFilters.value.find(f => f.id === 'modality')
  const typeFilter = formationFilters.value.find(f => f.id === 'type')

  // Filtre Type (Global) : Si un type est sélectionné et qu'il ne correspond pas à la section actuelle, on retourne false
  if (typeFilter && typeFilter.value.length > 0) {
    // Si on filtre sur "capsules", on cache les parcours, et inversement
    // Note: Top 5 est considéré comme "capsule"
    if (type === 'parcours' && !typeFilter.value.includes('parcours')) return false
    if (type === 'capsule' && !typeFilter.value.includes('capsule')) return false
  }

  // Filtre Catégorie
  if (categoryFilter && categoryFilter.value.length > 0) {
    // On doit mapper le tag texte (ex: "Management & Leadership") avec l'ID du filtre (ex: "management")
    const selectedLabels = categoryFilter.options
      .filter(opt => categoryFilter.value.includes(opt.id))
      .map(opt => opt.label)

    // Si le tag de l'item n'est pas dans les labels sélectionnés
    if (!selectedLabels.some(label => item.tag === label)) {
      return false
    }
  }

  // Filtre Modalité
  if (modalityFilter && modalityFilter.value.length > 0) {
    if (!item.modality || !modalityFilter.value.includes(item.modality)) {
      return false
    }
  }

  return true
}

const handleFormationFilterApply = ({ id, value }) => {
  console.log('Filtre appliqué - ID:', id, 'Valeur:', value)
}

// Données pour Top 5 des capsules
const topCapsules = [
  {
    title: 'Gestion des conflits',
    tag: 'Compétences comportementales',
    resume: 'Identifier et désamorcer les tensions au bon moment.',
    imageUrl: '/annonces/capsule-1.jpg',
    hasVideo: true,
    modality: 'e-learning'
  },
  {
    title: 'Communiquer avec un profil DISC',
    tag: 'Compétences comportementales',
    resume: 'Comment s\'adapter efficacement aux besoins communicatifs des interlocuteurs ?',
    imageUrl: '/annonces/capsule-2.jpg',
    hasSound: true,
    modality: 'remote'
  },
  {
    title: 'Maîtriser les bases d\'Excel',
    tag: 'Outils & pratiques',
    resume: 'Allez plus loin avec les tableaux, les formules et les tableaux croisés dynamiques',
    imageUrl: '/annonces/capsule-3.jpg',
    hasArticle: true,
    modality: 'in-person'
  },
  {
    title: 'Communication assertive',
    tag: 'Compétences comportementales',
    resume: 'S’exprimer clairement tout en respectant son interlocuteur.',
    imageUrl: '/annonces/capsule-4.jpg',
    hasVideo: true,
    modality: 'e-learning'
  },
  {
    title: 'Motiver son équipe au quotidien',
    tag: 'Management & Leadership',
    resume: 'Identifier et activer les leviers de motivation.',
    imageUrl: '/annonces/capsule-5.jpg',
    hasList: true,
    modality: 'remote'
  }
]

// Données pour Nos parcours de formation
const parcoursList = [
  {
    title: 'Devenir manager d\'équipe',
    tag: 'Management & Leadership',
    resume: 'Les fondamentaux pour encadrer, motiver et accompagner une équipe.',
    imageUrl: '/annonces/parcours-1.jpg',
    hasList: true,
    modality: 'in-person'
  },
  {
    title: 'Recruter autrement',
    tag: 'Ressources Humaines',
    resume: 'Maîtriser un recrutement structuré, équitable et attractif.',
    imageUrl: '/annonces/parcours-2.jpg',
    hasVideo: true,
    modality: 'remote'
  },
  {
    title: 'Maintenance Industrielle (Niveau 2)',
    tag: 'Compétences métier',
    resume: 'Diagnostic, interventions simples, sécurité, documentation.',
    imageUrl: '/annonces/parcours-3.jpg',
    hasList: true,
    modality: 'in-person'
  },
  {
    title: 'Sensibilisation QSE',
    tag: 'Performance & Organisation',
    resume: 'Un parcours essentiel pour comprendre les enjeux QSE, adopter les bons réflexes.',
    imageUrl: '/annonces/parcours-4.jpg',
    hasArticle: true,
    modality: 'e-learning'
  },
  {
    title: 'Initiation à la Cybersécurité',
    tag: 'Performance & Organisation',
    resume: 'Menaces, phishing, mots de passe, bonnes pratiques IT.',
    imageUrl: '/annonces/parcours-5.jpg',
    hasList: true,
    modality: 'remote'
  }
]

// Données pour Nos capsules de savoir
const capsulesList = [
  {
    title: 'Gestion des conflits',
    tag: 'Compétences comportementales',
    resume: 'Identifier et désamorcer les tensions au bon moment.',
    imageUrl: '/annonces/savoir-1.jpg',
    hasVideo: true,
    modality: 'e-learning'
  },
  {
    title: 'Motiver son équipe au quotidien',
    tag: 'Management & Leadership',
    resume: 'Identifier et activer les leviers de motivation.',
    imageUrl: '/annonces/savoir-2.jpg',
    hasSound: true,
    modality: 'remote'
  },
  {
    title: 'Analyse de données & KPI',
    tag: 'Compétences métier',
    resume: 'Interpréter les indicateurs clés pour optimiser les actions marketing.',
    imageUrl: '/annonces/savoir-3.jpg',
    hasArticle: true,
    modality: 'in-person'
  },
  {
    title: 'Maitrîser les bases d\'Excel',
    tag: 'Outils & pratiques',
    resume: 'Allez plus loin avec les tableaux, les formules et les tableaux croisés dynamiques',
    imageUrl: '/annonces/savoir-4.jpg',
    hasList: true,
    modality: 'e-learning'
  },
  {
    title: 'Communication assertive',
    tag: 'Compétences comportementales',
    resume: 'S\'exprimer clairement tout en respectant son interlocuteur.',
    imageUrl: '/annonces/savoir-5.jpg',
    hasVideo: true,
    modality: 'remote'
  },
  {
    title: 'Communiquer avec un profil DISC',
    tag: 'Compétences comportementales',
    resume: 'Comment s\'adapter efficacement aux besoins communicatifs des interlocuteurs ?',
    imageUrl: '/annonces/savoir-6.jpg',
    hasSound: true,
    modality: 'e-learning'
  }
]

// Listes filtrées
const filteredTopCapsules = computed(() => {
  return topCapsules.filter(item => checkFilters(item, 'capsule'))
})

const filteredParcours = computed(() => {
  return parcoursList.filter(item => checkFilters(item, 'parcours'))
})

const filteredCapsules = computed(() => {
  return capsulesList.filter(item => checkFilters(item, 'capsule'))
})

// Propriétés pour savoir si on doit afficher les sections
const showTopCapsules = computed(() => filteredTopCapsules.value.length > 0)
const showParcours = computed(() => filteredParcours.value.length > 0)
const showCapsules = computed(() => filteredCapsules.value.length > 0)
</script>

<style scoped>
.hide-scrollbar {
  -ms-overflow-style: none;
  scrollbar-width: none;
}
.hide-scrollbar::-webkit-scrollbar {
  display: none;
}
</style>
