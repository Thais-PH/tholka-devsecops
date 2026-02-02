<template>
  <div class="flex flex-col w-full min-h-screen bg-secondary-300">
    <!-- Header -->
    <OrganismsNavbar :is-sidebar-open="isSidebarOpen" :wide-breakpoint="true" @toggle-sidebar="isSidebarOpen = !isSidebarOpen" />

    <!-- Content avec Sidebar -->
    <div class="flex w-full" style="margin-top: 82.73px;">
      <!-- Sidebar -->
      <OrganismsSidebarCollaborateur active-item="equipe" :is-open="isSidebarOpen" :wide-breakpoint="true" @close="isSidebarOpen = false" />

      <!-- Main Content -->
      <main class="main-content-equipe flex flex-col items-start py-8 px-4 sm:px-8 gap-5 flex-1 overflow-x-hidden">
        <!-- Blocs Container -->
        <div class="flex flex-col justify-end items-end gap-[55px] w-full flex-1 relative">
          <!-- Personnes Section -->
          <div class="flex flex-col items-start gap-5 w-full">
            <!-- Secondary Menu (Annuaire / Cartographie) -->
            <MoleculesSecondaryMenu
              :items="menuItems"
              :default-active-index="activeTabIndex"
              @change="handleMenuChange"
            />

            <!-- Directory View - Grille de Cards Profile -->
            <div v-if="currentView === 'directory'" class="w-full flex flex-col">
              <!-- FilterBar alignée à gauche sur mobile, à droite sur desktop -->
              <div class="flex justify-start lg:justify-end w-full mb-6 sm:mb-[68px]">
                <MoleculesFilterBar
                  :filters="filters"
                  variant="light"
                  dropdown-position="right"
                  @update-filter="handleFilterUpdate"
                  @apply-filter="handleFilterApply"
                />
              </div>

              <!-- Cards Grid - 4 colonnes sur desktop -->
              <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-[13px] w-full">
                <MoleculesCard
                  v-for="collaborator in paginatedCollaborators"
                  :key="collaborator.id"
                  type="profile"
                  :image-url="collaborator.imageUrl"
                  :title="collaborator.name"
                  :contract-type="collaborator.pole"
                  :description="collaborator.position"
                  :disc-icon="collaborator.discProfile"
                />
              </div>

              <!-- Pagination avec gap de 55px -->
              <div class="flex justify-center w-full mt-[55px]">
                <MoleculesPagination
                  :current-page="currentPage"
                  :total-pages="totalPages"
                  @page-change="handlePageChange"
                />
              </div>
            </div>

            <!-- Mapping View -->
            <div v-else-if="currentView === 'mapping'" class="w-full flex flex-col gap-6">
              <OrganismsCartographie
                :collaborators="collaborators"
                fixed-pole="Communication"
              />
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'

const route = useRoute()
const router = useRouter()

const isSidebarOpen = ref(false)

// Menu items pour SecondaryMenu
const menuItems = [
  { id: 'annuaire', label: 'Annuaire' },
  { id: 'cartographie', label: 'Cartographie' }
]

// Récupérer l'onglet initial depuis l'URL
const getInitialTab = (): 'directory' | 'mapping' => {
  const tabParam = route.query.tab as string
  if (tabParam === 'cartographie') return 'mapping'
  return 'directory'
}

const getInitialTabIndex = (): number => {
  const tabParam = route.query.tab as string
  const index = menuItems.findIndex(item => item.id === tabParam)
  return index >= 0 ? index : 0
}

const currentView = ref<'directory' | 'mapping'>(getInitialTab())
const activeTabIndex = ref(getInitialTabIndex())
const currentPage = ref(1)
const itemsPerPage = 12

const handlePageChange = (page: number) => {
  currentPage.value = page
}

// Handler pour le changement d'onglet du SecondaryMenu
const handleMenuChange = (data: { index: number; item: { id: string; label: string } }) => {
  // Mettre à jour l'URL avec le paramètre tab
  router.replace({ query: { ...route.query, tab: data.item.id } })
  
  // Changer la vue
  if (data.item.id === 'annuaire') {
    currentView.value = 'directory'
  } else if (data.item.id === 'cartographie') {
    currentView.value = 'mapping'
  }
}

// Handlers pour FilterBar
const handleFilterUpdate = ({ id, value }: { id: string; value: string[] }) => {
  selectedFilters.value = {
    ...selectedFilters.value,
    [id]: value
  }
}

const handleFilterApply = ({ id, value }: { id: string; value: string[] }) => {
  selectedFilters.value = {
    ...selectedFilters.value,
    [id]: value
  }
  currentPage.value = 1
}

// Mock data for collaborators (même données que RH pour cohérence)
const collaborators = ref([
  {
    id: 1,
    name: 'Thomas Lemoine',
    position: 'Chargé de missions marketing',
    pole: 'Communication',
    discProfile: 'S',
    imageUrl: '/equipe/thomas-lemoine.jpg',
    department: 'RH',
    status: 'Actif',
    managerId: 17 // Chloé Garcia
  },
  {
    id: 2,
    name: 'Claire Martin',
    position: 'Chargée de missions RH',
    pole: 'RH',
    discProfile: 'C',
    imageUrl: '/equipe/claire-martin.jpg',
    department: 'RH',
    status: 'Actif',
    managerId: 14 // Emma Fournier
  },
  {
    id: 3,
    name: 'Lucas Petit',
    position: 'Chargé de recrutement',
    pole: 'Support',
    discProfile: 'I',
    imageUrl: '/equipe/lucas-petit.jpg',
    department: 'Marketing',
    status: 'Actif',
    managerId: null
  },
  {
    id: 4,
    name: 'Nathalie Leroy',
    position: 'Assistante administrative',
    pole: 'Designer',
    discProfile: 'I',
    imageUrl: '/equipe/nathalie-leroy.jpg',
    department: 'Projets',
    status: 'Actif',
    managerId: null
  },
  {
    id: 5,
    name: 'Pierre Fontaine',
    position: 'Responsable comptable',
    pole: 'Comptabilité',
    discProfile: 'D',
    imageUrl: '/equipe/pierre-fontaine.jpg',
    department: 'Design',
    status: 'Actif',
    managerId: null
  },
  {
    id: 6,
    name: 'Inès Noulanger',
    position: 'Chargée de communication interne',
    pole: 'Communication',
    discProfile: 'I',
    imageUrl: '/equipe/ines-noulanger.jpg',
    department: 'Finance',
    status: 'Actif',
    managerId: 17 // Chloé Garcia
  },
  {
    id: 7,
    name: 'Julien Moreau',
    position: 'Développeur informatique',
    pole: 'Informatique',
    discProfile: 'C',
    imageUrl: '/equipe/julien-moreau.jpg',
    department: 'Ventes',
    status: 'Actif',
    managerId: null
  },
  {
    id: 8,
    name: 'Antoine Roussel',
    position: 'Data analyst',
    pole: 'Data & Analytics',
    discProfile: 'S',
    imageUrl: '/equipe/antoine-roussel.jpg',
    department: 'IT',
    status: 'Actif',
    managerId: null
  },
  {
    id: 9,
    name: 'Camille Dupont',
    position: 'Technicienne support IT',
    pole: 'Informatique',
    discProfile: 'C',
    imageUrl: '/equipe/camille-dupont.jpg',
    department: 'Admin',
    status: 'Actif',
    managerId: 7 // Julien Moreau
  },
  {
    id: 10,
    name: 'Sarah Bellamy',
    position: 'Responsable logistique',
    pole: 'Logistique',
    discProfile: 'D',
    imageUrl: '/equipe/sarah-bellamy.jpg',
    department: 'IT',
    status: 'Actif',
    managerId: null
  },
  {
    id: 11,
    name: 'Thomas Renaud',
    position: 'Responsable commercial',
    pole: 'Commercial',
    discProfile: 'D',
    imageUrl: '/equipe/thomas-renaud.jpg',
    department: 'Production',
    status: 'Actif',
    managerId: null
  },
  {
    id: 12,
    name: 'Hugo Martin',
    position: 'Chargé de clientèle',
    pole: 'SAV',
    discProfile: 'S',
    imageUrl: '/equipe/hugo-martin.jpg',
    department: 'Direction',
    status: 'Actif',
    managerId: null
  },
  {
    id: 13,
    name: 'Léa Dubois',
    position: 'Directrice des Ressources Humaines DRH',
    pole: 'RH',
    discProfile: 'D',
    imageUrl: '/equipe/lea-dubois.jpg',
    department: 'RH',
    status: 'Actif',
    managerId: null // Top du pôle RH
  },
  {
    id: 14,
    name: 'Emma Fournier',
    position: 'Responsable du développement RH',
    pole: 'RH',
    discProfile: 'D',
    imageUrl: '/equipe/emma-fournier.jpg',
    department: 'IT',
    status: 'Actif',
    managerId: 13 // Léa Dubois
  },
  {
    id: 15,
    name: 'Lucas Bernard',
    position: 'Chargé de recrutement',
    pole: 'RH',
    discProfile: 'S',
    imageUrl: '/equipe/lucas-bernard.jpg',
    department: 'Marketing',
    status: 'Actif',
    managerId: 14 // Emma Fournier
  },
  {
    id: 16,
    name: 'Julie Masson',
    position: 'Gestionnaire de paie et administration',
    pole: 'RH',
    discProfile: 'C',
    imageUrl: '/equipe/julie-masson.jpg',
    department: 'Projets',
    status: 'Actif',
    managerId: 14 // Emma Fournier
  },
  {
    id: 17,
    name: 'Chloé Garcia',
    position: 'Directrice de la communication',
    pole: 'Communication',
    discProfile: 'D',
    imageUrl: '/equipe/chloe-garcia.jpg',
    department: 'Projets',
    status: 'Actif',
    managerId: null // Top du pôle Communication
  },
  {
    id: 18,
    name: 'Enzo Martin',
    position: 'Content Creator',
    pole: 'Communication',
    discProfile: 'C',
    imageUrl: '/equipe/enzo-martin.jpg',
    department: 'Projets',
    status: 'Actif',
    managerId: 6 // Inès Noulanger
  }
])

// Filter configuration pour FilterBar
const filters = ref([
  {
    id: 'disc',
    label: 'Profil DISC',
    options: [
      { id: 'D', label: 'Rouge' },
      { id: 'S', label: 'Vert' },
      { id: 'I', label: 'Jaune' },
      { id: 'C', label: 'Bleu' }
    ],
    value: [] as string[]
  },
  {
    id: 'pole',
    label: 'Pôle',
    options: [
      { id: 'Communication', label: 'Communication' },
      { id: 'Comptabilité', label: 'Comptabilité' },
      { id: 'RH', label: 'RH' },
      { id: 'Informatique', label: 'Informatique' },
      { id: 'Data & Analytics', label: 'Data & Analytics' },
      { id: 'Designer', label: 'Designer' },
      { id: 'SAV', label: 'SAV' },
      { id: 'Logistique', label: 'Logistique' },
      { id: 'Support', label: 'Support' },
    ],
    value: [] as string[]
  },
])

const selectedFilters = ref<Record<string, string[]>>({})

const applyFilter = (index: number, selected: string[]) => {
  const key = filters.value[index]?.label
  if (!key) return
  selectedFilters.value = {
    ...selectedFilters.value,
    [key]: selected
  }
  currentPage.value = 1
}

const filteredCollaborators = computed(() => {
  let result = collaborators.value

  const poleFilter = selectedFilters.value['pole']
  if (poleFilter && poleFilter.length) {
    result = result.filter((person) => poleFilter.includes(person.pole))
  }

  const discFilter = selectedFilters.value['disc']
  if (discFilter && discFilter.length) {
    result = result.filter((person) => discFilter.includes(person.discProfile))
  }

  return result
})

const totalPages = computed(() => {
  const pages = Math.ceil(filteredCollaborators.value.length / itemsPerPage)
  return pages || 1
})

const paginatedCollaborators = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage
  return filteredCollaborators.value.slice(start, start + itemsPerPage)
})
</script>

<style scoped>
.main-content-equipe {
  margin-left: 0;
  padding-left: 16px;
  padding-right: 16px;
}

@media (min-width: 640px) {
  .main-content-equipe {
    padding-left: 32px;
    padding-right: 32px;
  }
}

@media (min-width: 1700px) {
  .main-content-equipe {
    margin-left: 300px;
    padding-left: 52px;
    padding-right: 52px;
  }
}
</style>
