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
      <!-- Sidebar RH -->
      <OrganismsSidebarRH
        :is-open="isSidebarOpen"
        active-item="recrutement"
        @close="isSidebarOpen = false"
      />

      <!-- Main Content -->
      <main class="flex-1 overflow-y-auto hide-scrollbar lg:ml-[300px]">
        <div class="flex flex-col items-start p-4 md:px-[52px] md:py-8 gap-6 md:gap-8 w-full">
          
          <!-- Header: Titre + Bouton -->
          <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 w-full">
            <h1 class="text-h3 md:text-h1 text-primary-500">Recrutement</h1>
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 w-full sm:w-auto">
              <AtomsButton variant="secondary" size="md">
                Voir les offres archivées
              </AtomsButton>
              <AtomsButton variant="primary" size="md" @click="showNewOfferModal = true">
                <template #icon-left>
                  <LucidePlus :size="20" :stroke-width="1" />
                </template>
                Nouvelle offre d'emploi
              </AtomsButton>
            </div>
          </div>

          <!-- Stats Cards Section -->
          <div class="flex flex-col items-start p-4 md:px-5 md:py-4 gap-6 w-full bg-white rounded-lg">
            <h4 class="text-h4 text-primary-500">Dernières offres publiées</h4>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6 w-full">
              <div
                v-for="(offer, index) in activeOffers"
                :key="index"
                class="flex flex-col items-start p-6 bg-white rounded-lg border border-Grey-300"
              >
                <div class="flex flex-col gap-6 w-full">
                  <!-- Tag + Titre -->
                  <div class="flex flex-col gap-2">
                    <AtomsTag
                      variant="soft"
                      color="primary"
                      status-color="primary"
                      size="md"
                      class="w-fit"
                    >
                      {{ offer.status }}
                    </AtomsTag>
                    <span class="text-base font-sans font-bold text-primary-500 line-clamp-2">
                      {{ offer.title }}
                    </span>
                  </div>
                  <!-- Candidats count -->
                  <span class="text-xs font-roboto text-primary-900">
                    {{ offer.candidates }} candidats
                  </span>
                </div>
              </div>
            </div>
          </div>

          <!-- Table Section -->
          <div class="w-full bg-white rounded-lg">
            <MoleculesTable
              :data="candidaturesData"
              :columns="candidaturesColumns"
              variant="simple"
              :striped="false"
              :hover="true"
              @row-click="handleActionClick"
              @action-click="handleActionClick"
            />
          </div>

        </div>
      </main>
    </div>

    <!-- Modal Nouvelle Offre -->
    <MoleculesModalNewOffer
      :is-open="showNewOfferModal"
      @close="showNewOfferModal = false"
      @continue="handleNewOfferContinue"
    />
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { Plus as LucidePlus } from 'lucide-vue-next'

useHead({
  title: 'Recrutement - Tholka RH',
})

// État de la sidebar mobile
const isSidebarOpen = ref(false)

// État de la modale nouvelle offre
const showNewOfferModal = ref(false)

// Données des offres actives (cartes stats)
const activeOffers = [
  {
    title: 'Comptable fournisseur',
    status: 'Publiée',
    candidates: 13
  },
  {
    title: 'Chargé·e de missions QSE',
    status: 'Publiée',
    candidates: 4
  },
  {
    title: 'Comptable fournisseur',
    status: 'Publiée',
    candidates: 9
  },
  {
    title: 'Assistant·e Marketing',
    status: 'Publiée',
    candidates: 12
  },
  {
    title: 'Chargé·e de mission RH',
    status: 'Publiée',
    candidates: 27
  }
]

// Colonnes du tableau
const candidaturesColumns = [
  { key: 'annonce', label: 'Annonces', type: 'text', sortable: true },
  { key: 'service', label: 'Service', type: 'text', sortable: true },
  { key: 'candidatures', label: 'Candidatures', type: 'text', sortable: true },
  { key: 'statut', label: 'Statut', type: 'tag', sortable: true },
  { key: 'acces', label: '', type: 'action', headerClass: 'text-center', cellClass: 'text-center' }
]

// Données du tableau
const candidaturesData = ref([
  {
    annonce: 'Responsable Achats',
    service: 'Achat',
    candidatures: '7 candidats',
    statut: { text: 'Publiée', variant: 'soft', color: 'green', statusColor: 'green' },
    acces: [{ icon: 'ChevronRight', action: 'view' }]
  },
  {
    annonce: 'Développeur.se Full Stack',
    service: 'Informatique',
    candidatures: '',
    statut: { text: 'Brouillon', variant: 'soft', color: 'yellow', statusColor: 'yellow' },
    acces: [{ icon: 'ChevronRight', action: 'view' }]
  },
  {
    annonce: 'Assistant·e administratif·ve',
    service: 'Administration',
    candidatures: '16 candidats',
    statut: { text: 'En pause', variant: 'soft', color: 'orange', statusColor: 'orange' },
    acces: [{ icon: 'ChevronRight', action: 'view' }]
  },
  {
    annonce: 'Technicien·ne support informatique',
    service: 'Informatique',
    candidatures: '13 candidats',
    statut: { text: 'Publiée', variant: 'soft', color: 'green', statusColor: 'green' },
    acces: [{ icon: 'ChevronRight', action: 'view' }]
  },
  {
    annonce: 'Comptable confirmé·e',
    service: 'Comptabilité',
    candidatures: '18 candidats',
    statut: { text: 'Publiée', variant: 'soft', color: 'green', statusColor: 'green' },
    acces: [{ icon: 'ChevronRight', action: 'view' }]
  },
  {
    annonce: 'Chef·fe de projet événementiel',
    service: 'Communication',
    candidatures: '13 candidats',
    statut: { text: 'Publiée', variant: 'soft', color: 'green', statusColor: 'green' },
    acces: [{ icon: 'ChevronRight', action: 'view' }]
  },
  {
    annonce: 'UX/UI Designer',
    service: 'Informatique',
    candidatures: '',
    statut: { text: 'Brouillon', variant: 'soft', color: 'yellow', statusColor: 'yellow' },
    acces: [{ icon: 'ChevronRight', action: 'view' }]
  },
  {
    annonce: 'Chargé·e de maintenance',
    service: 'Logistique',
    candidatures: '19 candidats',
    statut: { text: 'En pause', variant: 'soft', color: 'orange', statusColor: 'orange' },
    acces: [{ icon: 'ChevronRight', action: 'view' }]
  },
  {
    annonce: 'Data Scientist',
    service: 'Data & Analytics',
    candidatures: '9 candidats',
    statut: { text: 'Publiée', variant: 'soft', color: 'green', statusColor: 'green' },
    acces: [{ icon: 'ChevronRight', action: 'view' }]
  },
  {
    annonce: 'Responsable sécurité (H/F)',
    service: 'Sécurité',
    candidatures: '30 candidats',
    statut: { text: 'Publiée', variant: 'soft', color: 'green', statusColor: 'green' },
    acces: [{ icon: 'ChevronRight', action: 'view' }]
  },
  {
    annonce: 'Conseiller·ère clientèle',
    service: 'SAV',
    candidatures: '10 candidats',
    statut: { text: 'Publiée', variant: 'soft', color: 'green', statusColor: 'green' },
    acces: [{ icon: 'ChevronRight', action: 'view' }]
  },
  {
    annonce: 'Architecte cloud',
    service: 'Infrastructure',
    candidatures: '',
    statut: { text: 'Brouillon', variant: 'soft', color: 'yellow', statusColor: 'yellow' },
    acces: [{ icon: 'ChevronRight', action: 'view' }]
  },
  {
    annonce: 'Directeur·rice commercial·e régional·e',
    service: 'Commercial',
    candidatures: '19 candidats',
    statut: { text: 'Publiée', variant: 'soft', color: 'green', statusColor: 'green' },
    acces: [{ icon: 'ChevronRight', action: 'view' }]
  },
  {
    annonce: 'Gestionnaire paie',
    service: 'Ressources Humaines',
    candidatures: '13 candidats',
    statut: { text: 'Publiée', variant: 'soft', color: 'green', statusColor: 'green' },
    acces: [{ icon: 'ChevronRight', action: 'view' }]
  }
])

const handleActionClick = (data) => {
  console.log('Action clicked:', data.row)
  // Navigation vers le détail de l'offre
}

const handleNewOfferContinue = (choice) => {
  console.log('Choice selected:', choice)
  showNewOfferModal.value = false

  // Navigation selon le choix
  switch (choice) {
    case 'manual':
      // navigateTo('/rh/recrutement/nouvelle-offre')
      break
    case 'import':
      // navigateTo('/rh/recrutement/import')
      break
    case 'ats':
      // navigateTo('/rh/recrutement/ats')
      break
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

.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>
