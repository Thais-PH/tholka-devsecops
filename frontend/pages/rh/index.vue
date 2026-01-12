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
        <div class="flex flex-col gap-6 p-6 lg:px-[52px] py-[32px] max-w-[1364px] mx-auto">

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
          <div v-else-if="activeTab === 'action-rh'" class="flex items-center justify-center h-64 bg-white rounded-lg">
            <p class="text-primary-900">Contenu Action RH à venir...</p>
          </div>
        </div>
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import {
  Pencil,
  FileQuestion, 
  Users,
  UserPlus2 as LucideUserPlus2
} from 'lucide-vue-next'

useHead({
  title: 'Accueil RH - Tholka',
})

// État de la sidebar mobile
const isSidebarOpen = ref(false)

// État actif du menu
const activeTab = ref('general')
const activeTabIndex = ref(0)

const secondaryMenuItems = [
  { id: 'general', label: 'Général' },
  { id: 'action-rh', label: 'Action RH' }
]

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

const handleMenuChange = (data) => {
  activeTab.value = data.item.id
  activeTabIndex.value = data.index
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
