<template>
  <div class="flex flex-col w-full min-h-screen bg-secondary-300">
    <!-- Header -->
    <OrganismsNavbar />

    <!-- Content avec Sidebar -->
    <div class="flex w-full" style="margin-top: 82.73px;">
      <!-- Sidebar -->
      <OrganismsSidebarCollaborateur active-item="equipe" />

      <!-- Main Content -->
      <div class="flex flex-col items-start p-[32px] gap-[24px] flex-1" style="margin-left: 300px;">
        <!-- Header avec Switch et Filtres -->
        <div class="flex items-center justify-between w-full max-w-[1324px]">
          <!-- View Switch Button (Gauche) -->
          <div class="flex items-center gap-[8px] bg-white rounded-[20px] p-[4px] border border-Grey-300">
            <button
              @click="currentView = 'directory'"
              :class="[
                'px-4 py-2 rounded-[16px] font-roboto text-sm transition-colors',
                currentView === 'directory'
                  ? 'bg-primary-500 text-white'
                  : 'bg-transparent text-primary-500 hover:bg-Grey-100'
              ]"
            >
              Annuaire
            </button>
            <button
              @click="currentView = 'mapping'"
              :class="[
                'px-4 py-2 rounded-[16px] font-roboto text-sm transition-colors',
                currentView === 'mapping'
                  ? 'bg-primary-500 text-white'
                  : 'bg-transparent text-primary-500 hover:bg-Grey-100'
              ]"
            >
              Cartographie
            </button>
          </div>

          <!-- Filters Section (Droite) -->
          <div v-if="currentView === 'directory'" class="flex gap-[12px]">
            <MoleculesFilter
              v-for="(filter, index) in filters"
              :key="index"
              :filter-label="`${filter.label}`"
              :filter-options="filter.options"
              @apply-filters="(selected) => applyFilter(index, selected)"
            />
          </div>
        </div>

        <!-- Directory View -->
        <div v-if="currentView === 'directory'" class="w-full flex flex-col gap-[24px]">
          <!-- Collaborators Grid - Responsive layout with Tailwind breakpoints -->
          <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-[16px] w-full auto-rows-max">
            <div class="w-full flex justify-center" v-for="collaborator in paginatedCollaborators" :key="collaborator.id">
              <MoleculesCard
                type="profile"
                :image-url="collaborator.imageUrl"
                :title="collaborator.name"
                :contract-type="collaborator.pole"
                :description="collaborator.position"
                :disc-icon="collaborator.discProfile"
              />
            </div>
          </div>

          <!-- Pagination -->
          <div class="flex justify-center w-full mt-[24px]">
            <MoleculesPagination
              :current-page.number="currentPage"
              :total-pages.number="totalPages"
              @page-change="handlePageChange"
            />
          </div>
        </div>

        <!-- Mapping View -->
        <div v-else-if="currentView === 'mapping'" class="w-full flex flex-col gap-[24px] max-w-[1324px]">
          <div class="bg-white rounded-lg p-[32px] border border-Grey-300 min-h-[500px] flex items-center justify-center">
            <p class="text-Grey-500 font-roboto">Vue cartographie - En développement</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'

const currentView = ref<'directory' | 'mapping'>('directory')
const currentPage = ref(1)
const itemsPerPage = 12

const handlePageChange = (page: number) => {
  currentPage.value = page
}

// Mock data for collaborators
const collaborators = ref([
  {
    id: 1,
    name: 'Alice Dupont',
    position: 'Gestionnaire RH',
    pole: 'RH',
    discProfile: 'C',
    imageUrl: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=150&h=150&fit=crop',
    department: 'RH',
    status: 'Actif'
  },
  {
    id: 2,
    name: 'Bob Martin',
    position: 'Développeur Senior',
    pole: 'Informatique',
    discProfile: 'D',
    imageUrl: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&h=150&fit=crop',
    department: 'IT',
    status: 'Actif'
  },
  {
    id: 3,
    name: 'Claire Leblanc',
    position: 'Responsable Marketing',
    pole: 'Communication',
    discProfile: 'I',
    imageUrl: 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=150&h=150&fit=crop',
    department: 'Marketing',
    status: 'Actif'
  },
  {
    id: 4,
    name: 'David Moreau',
    position: 'Chef de Projet',
    pole: 'Data & Analytics',
    discProfile: 'S',
    imageUrl: 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=150&h=150&fit=crop',
    department: 'Projets',
    status: 'Actif'
  },
  {
    id: 5,
    name: 'Emma Girard',
    position: 'Designer UX/UI',
    pole: 'Designer',
    discProfile: 'I',
    imageUrl: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&h=150&fit=crop',
    department: 'Design',
    status: 'Actif'
  },
  {
    id: 6,
    name: 'Frank Petit',
    position: 'Comptable',
    pole: 'Comptabilité',
    discProfile: 'C',
    imageUrl: 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=150&h=150&fit=crop',
    department: 'Finance',
    status: 'Actif'
  },
  {
    id: 7,
    name: 'Gabrielle Simon',
    position: 'Responsable Ventes',
    pole: 'SAV',
    discProfile: 'D',
    imageUrl: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=150&h=150&fit=crop',
    department: 'Ventes',
    status: 'Actif'
  },
  {
    id: 8,
    name: 'Henri Roux',
    position: 'Développeur Front',
    pole: 'Informatique',
    discProfile: 'D',
    imageUrl: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&h=150&fit=crop',
    department: 'IT',
    status: 'Actif'
  },
  {
    id: 9,
    name: 'Isabelle Blanc',
    position: 'Assistante Administrative',
    pole: 'RH',
    discProfile: 'S',
    imageUrl: 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=150&h=150&fit=crop',
    department: 'Admin',
    status: 'Actif'
  },
  {
    id: 10,
    name: 'Jacques Olivier',
    position: 'Responsable IT',
    pole: 'Informatique',
    discProfile: 'C',
    imageUrl: 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=150&h=150&fit=crop',
    department: 'IT',
    status: 'Actif'
  },
  {
    id: 11,
    name: 'Karine Mercier',
    position: 'Superviseur Production',
    pole: 'Logistique',
    discProfile: 'D',
    imageUrl: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=150&h=150&fit=crop',
    department: 'Production',
    status: 'Actif'
  },
  {
    id: 12,
    name: 'Laurent Bonnet',
    position: 'Directeur Général',
    pole: 'Communication',
    discProfile: 'D',
    imageUrl: 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=150&h=150&fit=crop',
    department: 'Direction',
    status: 'Actif'
  },
  {
    id: 13,
    name: 'Marie Leclerc',
    position: 'Manager RH',
    pole: 'RH',
    discProfile: 'I',
    imageUrl: 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=150&h=150&fit=crop',
    department: 'RH',
    status: 'Actif'
  },
  {
    id: 14,
    name: 'Nicolas Vasseur',
    position: 'Développeur Back',
    pole: 'Informatique',
    discProfile: 'C',
    imageUrl: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&h=150&fit=crop',
    department: 'IT',
    status: 'Actif'
  },
  {
    id: 15,
    name: 'Olivier Renaud',
    position: 'Community Manager',
    pole: 'Communication',
    discProfile: 'I',
    imageUrl: 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=150&h=150&fit=crop',
    department: 'Marketing',
    status: 'Actif'
  },
  {
    id: 16,
    name: 'Patricia Gras',
    position: 'Coordinatrice Projet',
    pole: 'Support',
    discProfile: 'S',
    imageUrl: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=150&h=150&fit=crop',
    department: 'Projets',
    status: 'Actif'
  }
])

// Filter configuration
const filters = ref([
  {
    label: 'Catégorie',
    options: [
      { id: 'management_leadership', label: 'Management & Leadership' },
      { id: 'comp_comportementales', label: 'Compétences comportementales' },
      { id: 'performance_org', label: 'Performance & Organisation' },
      { id: 'outils_pratique', label: 'Outils & Pratique' },
      { id: 'ressources_humaines', label: 'Ressources Humaines' },
      { id: 'comp_metier', label: 'Compétences métier' },
      { id: 'dev_personnel', label: 'Développement personnel' },
      { id: 'culture_valeurs', label: 'Culture & Valeurs de l\'entreprise' }
    ]
  },
  {
    label: 'Profil DISC',
    options: [
      { id: 'dominance', label: 'Rouge', color: '#EB5035' },
      { id: 'influence', label: 'Jaune', color: '#FFD83B' },
      { id: 'stabilite', label: 'Vert', color: '#45CA24' },
      { id: 'conformite', label: 'Bleu', color: '#6B7280' }
    ]
  },
  {
    label: 'Pôle',
    options: [
      { id: 'communication', label: 'Communication' },
      { id: 'comptabilite', label: 'Comptabilité' },
      { id: 'rh', label: 'RH' },
      { id: 'informatique', label: 'Informatique' },
      { id: 'data_analytics', label: 'Data & Analytics' },
      { id: 'designer', label: 'Designer' },
      { id: 'sav', label: 'SAV' },
      { id: 'logistique', label: 'Logistique' },
      { id: 'support_pole', label: 'Support' }
    ]
  }
])

const activeFilters = ref<{ [key: number]: string[] }>({})

const applyFilter = (filterIndex: number, selected: string[]) => {
  activeFilters.value[filterIndex] = selected
  // Réinitialiser la pagination quand les filtres changent
  currentPage.value = 1
}

// Filtered collaborators
const filteredCollaborators = computed(() => {
  return collaborators.value.filter((collaborator) => {
    // Filtre Catégorie (index 0)
    if (activeFilters.value[0] && activeFilters.value[0].length > 0) {
      // Pas encore implémenté côté collaborators, donc on laisse passer
    }

    // Filtre Profil DISC (index 1)
    if (activeFilters.value[1] && activeFilters.value[1].length > 0) {
      const discFilterMap: { [key: string]: string } = {
        'dominance': 'D',
        'influence': 'I',
        'stabilite': 'S',
        'conformite': 'C'
      }
      const selectedDiscProfiles = activeFilters.value[1].map(id => discFilterMap[id]).filter(Boolean)
      if (selectedDiscProfiles.length > 0 && !selectedDiscProfiles.includes(collaborator.discProfile)) {
        return false
      }
    }

    // Filtre Pôle (index 2)
    if (activeFilters.value[2] && activeFilters.value[2].length > 0) {
      const poleFilterMap: { [key: string]: string } = {
        'communication': 'Communication',
        'comptabilite': 'Comptabilité',
        'rh': 'RH',
        'informatique': 'Informatique',
        'data_analytics': 'Data & Analytics',
        'designer': 'Designer',
        'sav': 'SAV',
        'logistique': 'Logistique',
        'support_pole': 'Support'
      }
      const selectedPoles = activeFilters.value[2].map(id => poleFilterMap[id]).filter(Boolean)
      if (selectedPoles.length > 0 && !selectedPoles.includes(collaborator.pole)) {
        return false
      }
    }

    return true
  })
})

// Pagination
const totalPages = computed(() => Math.ceil(filteredCollaborators.value.length / itemsPerPage))

const paginatedCollaborators = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage
  const end = start + itemsPerPage
  return filteredCollaborators.value.slice(start, end)
})
</script>
