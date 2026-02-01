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
        active-item="recrutement"
        @navigate="handleNavigation"
      />

      <!-- Main Content -->
      <main class="flex-1 overflow-y-auto hide-scrollbar">
        <div class="flex flex-col items-start px-4 md:px-8 lg:px-[52px] py-8 gap-5 w-full">
          
          <!-- Breadcrumb -->
          <AtomsBreadcrumb :items="breadcrumbItems" class="w-full" />

          <!-- Body -->
          <div class="flex flex-col items-center gap-10 w-full">
            
            <!-- Titre + Tag statut -->
            <div class="flex flex-col items-center gap-3">
              <!-- Titre & Tag -->
              <div class="flex flex-col md:flex-row items-center gap-3 md:gap-5">
                <h1 class="text-h3 text-primary-500">{{ offerTitle }}</h1>
                <AtomsTagDropdown
                  v-model="selectedStatus"
                  :options="statusOptions"
                />
              </div>
              <!-- Date -->
              <span class="font-roboto text-sm text-primary-900">En ligne depuis le {{ publishDate }}</span>
            </div>

            <!-- Tableau des candidatures -->
            <div class="w-full bg-white rounded-lg">
              <MoleculesTable
                :data="tableData"
                :columns="tableColumns"
                @action-click="handleActionClick"
                @header-icon-click="handleHeaderIconClick"
              />
            </div>

            <!-- Bloc bas : ATS + Meilleurs candidats -->
            <div class="flex flex-col lg:flex-row items-stretch gap-10 w-full">
              
              <!-- Section ATS -->
              <div class="flex flex-col items-end p-6 gap-5 w-full lg:flex-1 bg-white rounded-lg">
                <h2 class="w-full font-nunito font-bold text-2xl text-primary-500">Suivi des ATS</h2>
                
                <!-- Liste des ATS -->
                <div class="flex flex-col items-start gap-2 w-full">
                  <!-- ATS Item -->
                  <div 
                    v-for="(ats, index) in atsList" 
                    :key="index"
                    class="flex flex-row items-center px-3 py-3 gap-4 sm:gap-8 w-full bg-white border border-Grey-300 rounded-lg"
                  >
                    <!-- Logo -->
                    <div class="w-[106px] h-[50px] flex items-center justify-center shrink-0">
                      <img 
                        v-if="ats.logo" 
                        :src="ats.logo" 
                        :alt="ats.name" 
                        class="max-w-full max-h-full object-contain"
                        @error="(e) => e.target.style.display = 'none'"
                      />
                      <span v-else class="font-nunito font-bold text-sm text-primary-500 text-center">{{ ats.name }}</span>
                    </div>
                    <!-- Content -->
                    <div class="flex flex-col items-start gap-2 flex-1">
                      <span class="font-nunito font-bold text-[18px] text-primary-500">{{ ats.name }}</span>
                      <!-- KPIs -->
                      <div class="flex flex-col sm:flex-row items-start sm:items-center">
                        <div class="flex items-center sm:pr-4 sm:border-r border-Grey-500">
                          <span class="font-roboto text-base text-primary-900/50">{{ ats.duration }}</span>
                        </div>
                        <div class="flex items-center sm:px-4 sm:border-r border-Grey-500">
                          <span class="font-roboto text-base text-primary-900/50">{{ ats.price }}</span>
                        </div>
                        <div class="flex items-center gap-1 sm:px-4">
                          <span class="font-roboto text-base text-primary-900/50">Score</span>
                          <span class="font-roboto font-semibold text-base" :class="ats.score >= 50 ? 'text-Green-500' : 'text-Red-500'">{{ ats.score }}%</span>
                        </div>
                      </div>
                    </div>
                    <!-- Edit button -->
                    <button class="p-2 hover:bg-secondary-300 rounded-lg transition-colors">
                      <LucidePenSquare :size="24" :stroke-width="1" class="text-primary-500" />
                    </button>
                  </div>
                </div>
                
                <!-- Bouton voir plus -->
                <AtomsButton variant="tertiary" size="md" class="!min-w-0">
                  Voir plus de données
                  <template #icon-right>
                    <LucideChevronRight :size="20" :stroke-width="1" />
                  </template>
                </AtomsButton>
              </div>

              <!-- Section Meilleurs candidats -->
              <div class="flex flex-col items-end p-6 gap-6 w-full lg:flex-1 bg-white rounded-lg">
                <!-- Titre -->
                <div class="flex flex-col justify-center items-start gap-1 w-full">
                  <h2 class="font-nunito font-bold text-2xl text-primary-500">Meilleur(s) candidat(s)</h2>
                  <AtomsTag variant="soft" color="purple" size="md">
                    Sources : CV, test DISC, historique des recrutements ; Hello Workplace
                  </AtomsTag>
                </div>

                <!-- Carte candidat -->
                <div class="flex flex-row items-center gap-3 w-full">
                  <MoleculesCard
                    v-for="(candidate, index) in bestCandidates"
                    :key="index"
                    type="people-small"
                    :title="candidate.name"
                    :image-url="candidate.imageUrl"
                    image-position="center top"
                    button-icon-left="File" 
                    :button-icon-right="null" 
                    button-label="CV_TDUPUIS_2026   81,6KB"
                  />
                </div>

                <!-- Description IA -->
                <div class="flex flex-col items-end gap-3 w-full">
                  <p class="font-roboto text-base text-primary-900 w-full">
                    Les candidatures issues de la <span class="font-bold text-primary-500">cooptation</span> affichent un <span class="font-bold text-primary-500">taux de compatibilité moyen de 85 %</span>, supérieur à la moyenne globale (68 %).<br />Conseil : priorisez ce canal pour vos prochaines offres.
                  </p>
                  <p class="font-roboto text-base text-primary-900 w-full">
                    Le candidat <span class="font-bold text-primary-500">Thomas DUPUIS a un profil DISC proche de celui de vos meilleurs collaborateurs marketing</span>.
                  </p>
                </div>
              </div>

            </div>

          </div>
        </div>
      </main>
    </div>

    <!-- Modal Compatibilité Profil -->
    <MoleculesModalCompatibilityHelp
      :is-open="showCompatibilityModal"
      @close="showCompatibilityModal = false"
    />
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import {
  PenSquare as LucidePenSquare,
  ChevronRight as LucideChevronRight,
  HelpCircle as LucideHelpCircle,
  ChevronsUpDown as LucideChevronsUpDown
} from 'lucide-vue-next'

const route = useRoute()
const router = useRouter()

// État de la sidebar mobile
const isSidebarOpen = ref(false)

// État de la modal de compatibilité
const showCompatibilityModal = ref(false)

// ID de l'offre depuis l'URL
const offerId = computed(() => route.params.id)

// Titre de l'offre (récupéré depuis les query params)
const offerTitle = computed(() => route.query.title || 'Responsable Achats')
const publishDate = ref('19/09/2025')

// Options de statut dropdown
const statusOptions = [
  { value: 'published', label: 'Publiée', color: 'primary', variant: 'solid', size: 'md', statusColor: 'green' },
  { value: 'paused', label: 'En pause', color: 'orange', variant: 'solid', size: 'md', statusColor: 'green' },
  { value: 'archived', label: 'Archivée', color: 'green', variant: 'solid', size: 'md', statusColor: 'green' }
  
]

const selectedStatus = ref(route.query.status || 'published')

// Breadcrumb items
const breadcrumbItems = computed(() => [
  { label: 'Accueil', to: '/rh' },
  { label: 'Recrutement', to: '/rh/recrutement' },
  { label: offerTitle.value }
])

// Titre SEO dynamique
useHead({
  title: `${offerTitle.value} - Tholka RH`
})

// Configuration des colonnes du tableau
const tableColumns = [
  { key: 'name', label: 'Nom du candidat', type: 'text', sortable: true },
  { key: 'type', label: 'Type', type: 'tag', sortable: true },
  { key: 'source', label: 'Source', type: 'text', sortable: false },
  { key: 'status', label: 'Statut', type: 'tag', sortable: false },
  { key: 'lastActivity', label: 'Dernière activité', type: 'text', sortable: true },
  { key: 'tracking', label: 'Suivi de la candidature', type: 'stepper', sortable: false },
  { key: 'compatibility', label: 'Compatibilité profil', type: 'tag', sortable: false, headerIcon: 'HelpCircle' },
  { key: 'acces', label: 'Accès', type: 'action', sortable: false }
]

// Données des candidats (selon maquette)
const candidates = ref([
  {
    name: 'Julie MARTIN',
    type: 'Externe',
    source: 'Linkedin',
    status: 'Active',
    lastActivity: '25/09/2025',
    tracking: [
      { label: 'Entretien RH', completed: true, rejected: false },
      { label: 'Entretien technique', completed: false, rejected: false },
      { label: 'Offre', completed: false, rejected: false }
    ],
    compatibility: null
  },
  {
    name: 'Thomas DUPUIS',
    type: 'Externe',
    source: 'Cooptation',
    status: 'Active',
    lastActivity: '24/09/2025',
    tracking: [
      { label: 'Entretien RH', completed: true, rejected: false },
      { label: 'Entretien technique', completed: true, rejected: false },
      { label: 'Offre', completed: true, rejected: false }
    ],
    compatibility: 82
  },
  {
    name: 'Claire BERNARD',
    type: 'Externe',
    source: 'Mail',
    status: 'Refusé',
    lastActivity: '23/09/2025',
    tracking: [
      { label: 'Entretien RH', completed: false, rejected: true },
      { label: 'Entretien technique', completed: false, rejected: false },
      { label: 'Offre', completed: false, rejected: false }
    ],
    compatibility: null
  },
  {
    name: 'Lucas PETIT',
    type: 'Externe',
    source: 'Linkedin',
    status: 'À traiter',
    lastActivity: '22/09/2025',
    tracking: [
      { label: 'Entretien RH', completed: false, rejected: false },
      { label: 'Entretien technique', completed: false, rejected: false },
      { label: 'Offre', completed: false, rejected: false }
    ],
    compatibility: null
  },
  {
    name: 'Sophie LEROY',
    type: 'Interne',
    source: '',
    status: 'À traiter',
    lastActivity: '20/09/2025',
    tracking: [
      { label: 'Entretien RH', completed: false, rejected: false },
      { label: 'Entretien technique', completed: false, rejected: false },
      { label: 'Offre', completed: false, rejected: false }
    ],
    compatibility: null
  },
  {
    name: 'Maxime LAURENT',
    type: 'Externe',
    source: 'Welcome to the jungle',
    status: 'Active',
    lastActivity: '20/09/2025',
    tracking: [
      { label: 'Entretien RH', completed: true, rejected: false },
      { label: 'Entretien technique', completed: false, rejected: false },
      { label: 'Offre', completed: false, rejected: false }
    ],
    compatibility: 71
  },
  {
    name: 'Emma DUBOIS',
    type: 'Externe',
    source: 'Google for job',
    status: 'Active',
    lastActivity: '18/09/2025',
    tracking: [
      { label: 'Entretien RH', completed: true, rejected: false },
      { label: 'Entretien technique', completed: true, rejected: false },
      { label: 'Offre', completed: false, rejected: false }
    ],
    compatibility: 40
  }
])

// Données formatées pour le composant Table
const tableData = computed(() => {
  return candidates.value.map(candidate => ({
    name: candidate.name,
    type: {
      text: candidate.type,
      variant: candidate.type === 'Externe' ? 'stroke' : 'soft',
      color: candidate.type === 'Externe' ? 'primary' : 'yellow'
    },
    source: candidate.source,
    status: {
      text: candidate.status,
      variant: 'soft',
      color: getStatusColor(candidate.status),
      statusColor: getStatusIndicatorColor(candidate.status)
    },
    lastActivity: candidate.lastActivity,
    tracking: candidate.tracking,
    compatibility: candidate.compatibility 
      ? { text: `${candidate.compatibility}%`, variant: 'soft', color: 'purple' }
      : null,
    acces: [{ icon: 'ChevronRight', action: 'access' }]
  }))
})

// Liste des ATS
const atsList = ref([
  {
    name: 'Indeed',
    logo: '/logos/indeed-logo.png',
    duration: '30 jours',
    price: '295,00€',
    score: 72
  },
  {
    name: 'Welcome to the Jungle',
    logo: '/logos/wttj-logo.png',
    duration: '15 jours',
    price: '295,00€',
    score: 65
  },
  {
    name: 'Google for Jobs',
    logo: '/logos/google-logo.png',
    duration: '10 jours',
    price: '295,00€',
    score: 22
  }
])

// Meilleurs candidats
const bestCandidates = ref([
  {
    name: 'Thomas DUPUIS',
    imageUrl: '/profiles/profile-1.jpg',
    discIcon: ''
  }
])

// Fonction pour obtenir la couleur du statut
const getStatusColor = (status) => {
  const colorMap = {
    'Active': 'green',
    'Refusé': 'orange',
    'À traiter': 'primary'
  }
  return colorMap[status] || 'primary'
}

// Fonction pour obtenir la couleur de l'indicateur de statut
const getStatusIndicatorColor = (status) => {
  const colorMap = {
    'Active': 'green',
    'Refusé': 'orange',
    'À traiter': 'primary'
  }
  return colorMap[status] || 'primary'
}

// Navigation sidebar
const handleNavigation = (itemId) => {
  const routes = {
    accueil: '/rh',
    equipe: '/rh/equipe-management-rh',
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

// Clic sur accès candidat
const handleCandidateAccess = (candidate) => {
  console.log('Access candidate:', candidate)
  // Navigation vers le profil du candidat
}

// Gestion des actions du tableau
const handleActionClick = ({ action, row, rowIndex }) => {
  if (action === 'access') {
    // Navigation vers le détail de la candidature
    router.push({
      path: `/rh/recrutement/candidature/${rowIndex + 1}`,
      query: {
        name: row.name,
        offerId: offerId.value,
        offerTitle: offerTitle.value
      }
    })
  }
}

// Gestion du clic sur l'icône d'aide dans le header
const handleHeaderIconClick = ({ column, columnKey }) => {
  if (columnKey === 'compatibility') {
    showCompatibilityModal.value = true
  }
}
</script>

<style scoped>
.hide-scrollbar::-webkit-scrollbar {
  display: none;
}

.hide-scrollbar {
  -ms-overflow-style: none;
  scrollbar-width: none;
}

.text-h3 {
  font-family: 'Nunito', sans-serif;
  font-weight: 700;
  font-size: 32px;
  line-height: 120%;
}
</style>
