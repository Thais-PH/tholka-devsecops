<template>
  <div class="flex flex-col w-full h-screen bg-secondary-300 overflow-hidden">
    <!-- Navbar -->
    <OrganismsNavbar
      :is-sidebar-open="isSidebarOpen"
      @toggle-sidebar="isSidebarOpen = !isSidebarOpen"
    />

    <!-- Main Layout -->
    <div class="flex flex-1 overflow-hidden pt-[82.73px]">
      <!-- Sidebar RH -->
      <OrganismsSidebarRH
        active-item="accueil"
        :is-open="isSidebarOpen"
        @close="isSidebarOpen = false"
      />

      <!-- Content Area -->
      <main class="flex-1 lg:ml-[300px] overflow-y-auto">
        <div class="flex flex-col gap-6 p-6 lg:px-[52px] py-[32px]">

          <!-- Secondary Menu -->
          <div class="flex items-center">
            <MoleculesSecondaryMenu
              :items="secondaryMenuItems"
              :default-active-index="activeTabIndex"
              @change="handleMenuChange"
            />
          </div>

          <!-- Tab Content -->
          <div v-if="activeTab === 'general'" class="flex flex-col gap-6">

            <!-- Bento Grid Layout -->
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

              <!-- Left Column (2/3) -->
              <div class="xl:col-span-2 flex flex-col gap-6">

                <!-- Quick Access Block -->
                <OrganismsQuickAccessBlock
                  title="Accès rapides"
                  :quick-access="quickAccessItems"
                />

                <!-- Chart + Stats Row -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                  <!-- Chart Block -->
                  <OrganismsChartBlock
                    :departures="5"
                    :arrivals="6"
                    :in-position="39"
                  />

                  <!-- Stats Grid (2x2) -->
                  <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col justify-center items-center p-6 bg-white rounded-lg shadow-sm">
                      <span class="text-h2 font-sans text-primary-500 whitespace-nowrap">8%</span>
                      <span class="text-base font-roboto text-primary-900 text-center whitespace-nowrap">Turnover annuel</span>
                    </div>
                    <div class="flex flex-col justify-center items-center p-6 bg-white rounded-lg shadow-sm">
                      <span class="text-h2 font-sans text-primary-500 whitespace-nowrap">4,2 ans</span>
                      <span class="text-base font-roboto text-primary-900 text-center whitespace-nowrap">Moyenne d'ancienneté</span>
                    </div>
                    <div class="flex flex-col justify-center items-center p-6 bg-white rounded-lg shadow-sm">
                      <span class="text-h2 font-sans text-primary-500 whitespace-nowrap">78/100</span>
                      <span class="text-base font-roboto text-primary-900 text-center line-clamp-2">Indice bien-être au travail</span>
                    </div>
                    <div class="flex flex-col justify-center items-center p-6 bg-white rounded-lg shadow-sm">
                      <span class="text-h2 font-sans text-primary-500 whitespace-nowrap">3,5%</span>
                      <span class="text-base font-roboto text-primary-900 text-center whitespace-nowrap">Absentéisme</span>
                    </div>
                  </div>
                </div>

                <!-- Documents + Contacts Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <OrganismsDocumentsBlock
                    title="Derniers documents"
                    :documents="documents"
                  />
                  <OrganismsContactsBlock
                    title="Contact de référence"
                    :contacts="contacts"
                  />
                </div>
              </div>

              <!-- Right Column (1/3) - Calendar -->
              <div class="xl:col-span-1">
                <OrganismsCalendarBlock class="h-full" />
              </div>
            </div>

            <!-- New Collaborators Section - Full Width -->
            <div class="flex flex-col gap-4 bg-white rounded-lg shadow-sm p-6">
              <div class="flex justify-between items-center">
                <h5 class="text-h5 text-primary-500">Bienvenue aux nouveaux collaborateurs</h5>
                <LucideUsers :size="24" :stroke-width="1" class="text-Orange-500" />
              </div>

              <!-- Profiles Carousel -->
              <div class="flex gap-4 overflow-x-auto hide-scrollbar pb-2">
                <MoleculesCard
                  v-for="profile in newProfiles"
                  :key="profile.name"
                  type="profile"
                  :image-url="profile.imageUrl"
                  :image-position="profile.imagePosition"
                  :title="profile.name"
                  :contract-type="profile.contractType"
                  :description="profile.description"
                  class="flex-shrink-0"
                />
              </div>
            </div>
          </div>

          <!-- Action RH Tab -->
          <div v-else-if="activeTab === 'action-rh'" class="flex flex-col gap-6">

            <!-- Actions RH Table Block -->
            <div class="flex flex-col gap-4 bg-white rounded-lg shadow-sm p-6">
              <div class="flex justify-between items-center">
                <h5 class="text-h5 text-primary-500">Actions RH</h5>
                <LucideFileEdit :size="24" :stroke-width="1" class="text-Orange-500" />
              </div>

              <MoleculesTable
                :data="actionsRHData"
                :columns="actionsRHColumns"
                variant="simple"
                :striped="false"
                :hover="true"
                @row-click="handleActionClick"
                @action-click="handleActionClick"
              />
            </div>

            <!-- Stats + Formation Row -->
            <div class="grid grid-cols-1 xl:grid-cols-5 gap-6">

              <!-- Stats Grid (2x2) - 2/5 width -->
              <div class="xl:col-span-2 grid grid-cols-2 gap-4">
                <div class="flex flex-col justify-center items-center p-6 bg-white rounded-lg shadow-sm">
                  <span class="text-h2 font-sans text-primary-500 whitespace-nowrap">6</span>
                  <span class="text-base font-roboto text-primary-500 text-center whitespace-nowrap">Actions en attente</span>
                </div>
                <div class="flex flex-col justify-center items-center p-6 bg-white rounded-lg shadow-sm">
                  <span class="text-h2 font-sans text-primary-500 whitespace-nowrap">3 jours</span>
                  <span class="text-base font-roboto text-primary-500 text-center line-clamp-2">Délai moyen de traitement</span>
                </div>
                <div class="flex flex-col justify-center items-center p-6 bg-white rounded-lg shadow-sm">
                  <span class="text-h2 font-sans text-primary-500 whitespace-nowrap">42</span>
                  <span class="text-base font-roboto text-primary-500 text-center whitespace-nowrap">Actions traitées</span>
                </div>
                <div class="flex flex-col justify-center items-center p-6 bg-white rounded-lg shadow-sm">
                  <span class="text-h2 font-sans text-primary-500 whitespace-nowrap">92%</span>
                  <span class="text-base font-roboto text-primary-500 text-center line-clamp-2">Taux de demandes résolues</span>
                </div>
              </div>

              <!-- Formation du mois Block - 3/5 width -->
              <div class="xl:col-span-3 flex flex-col md:flex-row bg-white rounded-lg shadow-sm overflow-hidden">
                <!-- Content - 50% width -->
                <div class="flex flex-col gap-4 p-6 w-full md:w-1/2">
                  <!-- Header -->
                  <div class="flex justify-between items-center">
                    <h5 class="text-h5 text-primary-500">La formation interne du mois</h5>
                    <LucideBookMarked :size="24" :stroke-width="1" class="text-Orange-500 flex-shrink-0" />
                  </div>

                  <!-- Subtitle -->
                  <p class="text-base font-roboto font-medium text-primary-500">Acquérir les bases d'Excel</p>

                  <!-- Tag IA -->
                  <AtomsTag variant="soft" color="purple" size="md">
                    15 collaborateurs pourraient être intéressés par cette compétence
                  </AtomsTag>

                  <!-- Details -->
                  <div class="flex flex-col gap-2 text-base font-roboto text-primary-900">
                    <p><span class="text-primary-500 font-bold">Objectif :</span> Maîtriser les fondamentaux d'Excel pour gagner en efficacité au quotidien</p>
                    <p><span class="text-primary-500 font-bold">Date :</span> 30 septembre 2025</p>
                    <p><span class="text-primary-500 font-bold">Durée :</span> 7 heures</p>
                  </div>

                  <!-- Button -->
                  <div class="mt-auto pt-2 flex justify-end">
                    <AtomsButton variant="tertiary" size="md" class="pr-0">
                      Voir le programme
                      <template #icon-right>
                        <LucideChevronRight :size="17" :stroke-width="1" />
                      </template>
                    </AtomsButton>
                  </div>
                </div>

                <!-- Image - 50% width -->
                <div class="hidden md:block w-1/2">
                  <img
                    src="/annonces/formation.jpg"
                    alt="Formation Excel"
                    class="w-full h-full object-cover"
                  />
                </div>
              </div>

            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import {
  Pencil,
  FileQuestion, 
  Users,
  UserPlus2 as LucideUserPlus2,
  ClipboardList as LucideClipboardList,
  BookOpen as LucideBookOpen,
  ChevronRight as LucideChevronRight
} from 'lucide-vue-next'

const route = useRoute()
const router = useRouter()

useHead({
  title: 'Accueil RH - Tholka',
})

// État de la sidebar mobile
const isSidebarOpen = ref(false)

// Menu items (déclaré avant pour pouvoir l'utiliser dans l'initialisation)
const secondaryMenuItems = [
  { id: 'general', label: 'Général' },
  { id: 'action-rh', label: 'Action RH' }
]

// État actif du menu - initialisé depuis l'URL si présent
const getInitialTab = () => {
  const tabFromUrl = route.query.tab
  const validTabs = secondaryMenuItems.map(item => item.id)
  return validTabs.includes(tabFromUrl) ? tabFromUrl : 'general'
}
const getInitialTabIndex = () => {
  const tab = getInitialTab()
  return secondaryMenuItems.findIndex(item => item.id === tab)
}
const activeTab = ref(getInitialTab())
const activeTabIndex = ref(getInitialTabIndex())

// Données Général
const quickAccessItems = [
  { label: 'Créer une annonce', icon: Pencil, color: 'primary' },
  { label: 'Outil de ticketing', icon: FileQuestion, color: 'primary' },
  { label: 'Organigramme', icon: Users, color: 'primary' }
]

const documents = [
  { label: 'Procédure de pose de congés', url: '#' },
  { label: 'Organigramme Direction Communication', url: '#' }
]

const contacts = [
  { name: 'DRH', email: 'paul-duchemin@enterprise.com' },
]

const newProfiles = [
  {
    name: 'Camille Dupont',
    imageUrl: '/profiles/first_profile.jpg',
    imagePosition: '15% 0%',
    contractType: 'Informatique',
    description: 'Technicienne support IT'
  },
  {
    name: 'Hugo Martin',
    imageUrl: '/profiles/second_profile.jpg',
    imagePosition: '28% 0%',
    contractType: 'SAV',
    description: 'Chargé de clientèle'
  },
  {
    name: 'Sarah Bellamy',
    imageUrl: '/profiles/third_profile.jpg',
    imagePosition: '28% 0%',
    contractType: 'Logistique',
    description: 'Responsable logistique'
  },
  {
    name: 'Thomas Renaud',
    imageUrl: '/profiles/fourth_profile.jpg',
    imagePosition: '72% 0%',
    contractType: 'Commercial',
    description: 'Responsable commercial'
  }
]

// Gestion du changement de menu - persiste l'onglet dans l'URL
const handleMenuChange = (data) => {
  activeTab.value = data.item.id
  activeTabIndex.value = data.index
  // Met à jour l'URL sans recharger la page (replace pour ne pas polluer l'historique)
  router.replace({ query: { ...route.query, tab: activeTab.value } })
}

// Données Action RH
const actionsRHColumns = [
  { key: 'tache', label: 'Tâches', type: 'text' },
  { key: 'date', label: 'Date', type: 'text' },
  { key: 'service', label: 'Service', type: 'text' },
  { key: 'collaborateur', label: 'Collaborateur', type: 'text' },
  { key: 'statut', label: 'Statut', type: 'tag' },
  { key: 'acces', label: 'Accès', type: 'action' }
]

const actionsRHData = ref([
  {
    tache: 'Demande de congés',
    date: '25/09/2025',
    service: 'Marketing',
    collaborateur: 'Julie Martin',
    statut: { text: 'En attente', variant: 'soft', color: 'orange', statusColor: 'orange' },
    acces: [{ icon: 'ChevronRight', action: 'view' }]
  },
  {
    tache: 'Arrêt maladie',
    date: '24/09/2025',
    service: 'Développement',
    collaborateur: 'Thomas DUPUIS',
    statut: { text: 'Traité', variant: 'soft', color: 'green', statusColor: 'green' },
    acces: [{ icon: 'ChevronRight', action: 'view' }]
  },
  {
    tache: 'Note de frais',
    date: '23/09/2025',
    service: 'Commerce',
    collaborateur: 'Claire BERNARD',
    statut: { text: 'Refusé', variant: 'soft', color: 'primary', statusColor: 'primary' },
    acces: [{ icon: 'ChevronRight', action: 'view' }]
  },
  {
    tache: 'Demande de formation',
    date: '22/09/2025',
    service: 'Design',
    collaborateur: 'Lucas PETIT',
    statut: { text: 'En attente', variant: 'soft', color: 'orange', statusColor: 'orange' },
    acces: [{ icon: 'ChevronRight', action: 'view' }]
  },
  {
    tache: 'Mobilité interne',
    date: '20/09/2025',
    service: 'Production',
    collaborateur: 'Sophie LEROY',
    statut: { text: 'En attente', variant: 'soft', color: 'orange', statusColor: 'orange' },
    acces: [{ icon: 'ChevronRight', action: 'view' }]
  },
  {
    tache: 'MAJ passeport de compét.',
    date: '20/09/2025',
    service: 'Direction',
    collaborateur: 'Maxime LAURENT',
    statut: { text: 'Traité', variant: 'soft', color: 'green', statusColor: 'green' },
    acces: [{ icon: 'ChevronRight', action: 'view' }]
  },
  {
    tache: 'Validation télétravail',
    date: '18/09/2025',
    service: 'Support IT',
    collaborateur: 'Emma DUBOIS',
    statut: { text: 'Traité', variant: 'soft', color: 'green', statusColor: 'green' },
    acces: [{ icon: 'ChevronRight', action: 'view' }]
  }
])

const handleActionClick = (data) => {
  console.log('Action clicked:', data.row)
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
</style>
