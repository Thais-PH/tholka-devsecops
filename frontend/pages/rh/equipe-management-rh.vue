<template>
  <div class="flex flex-col w-full h-screen bg-secondary-300 overflow-hidden">
    <!-- Header -->
    <OrganismsNavbar
      variant="rh"
      :is-sidebar-open="isSidebarOpen"
      @toggle-sidebar="isSidebarOpen = !isSidebarOpen"
    />

    <!-- Content avec Sidebar -->
    <div class="flex flex-1 overflow-hidden pt-[82.73px]">
      <!-- Sidebar -->
      <OrganismsSidebarRH
        active-item="equipe"
        :is-open="isSidebarOpen"
        @close="isSidebarOpen = false"
      />

      <!-- Main Content -->
      <main class="flex-1 lg:ml-[300px] overflow-y-auto">
        <div class="flex flex-col items-start p-[32px] gap-[24px] w-full">
        <!-- Header avec Switch et Filtres -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 w-full max-w-[1324px]">
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
          <div v-if="currentView === 'directory'" class="flex flex-wrap gap-[12px]">
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
          <div class="grid gap-[16px] w-full auto-rows-max" style="grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));">
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
        <div v-else-if="currentView === 'mapping'" class="w-full flex flex-col gap-[24px]">
          <div class="flex flex-col lg:flex-row gap-[24px] w-full">
            <!-- Organigramme Block -->
            <div class="w-full lg:w-1/2 bg-white rounded-lg p-[20px] border border-Grey-300" style="min-height: 480px;">
              <div class="flex flex-col gap-[16px] mb-[32px]">
                <div class="flex justify-between items-center">
                  <h5 class="text-xl font-semibold text-primary-500">Organigramme</h5>
                  <LucideUsersRound :size="24" :stroke-width="1.5" class="text-Orange-500" />
                </div>
                <div class="flex items-center justify-between gap-3">
                  <label class="text-sm font-semibold text-primary-500">Pôle</label>
                  <select
                    v-model="selectedPoleMapping"
                    class="w-[220px] h-[40px] px-3 py-2 border border-Grey-300 rounded-lg text-sm text-primary-500 bg-white focus:outline-none focus:ring-2 focus:ring-Orange-500"
                  >
                    <option v-for="pole in poleOptions" :key="pole" :value="pole">{{ pole }}</option>
                  </select>
                </div>
              </div>

              <div class="overflow-x-auto pb-4">
                <div class="relative min-w-[800px]" :style="{ height: `${layoutHeight}px` }">
                  <!-- Connecteurs -->
                  <svg class="absolute inset-0 pointer-events-none" :style="{ width: '100%', height: `${layoutHeight}px` }">
                    <g stroke="#AEACAC" stroke-width="1" fill="none">
                      <template v-for="(link, idx) in connectors" :key="`link-${idx}`">
                        <path
                          v-if="link.type === 'parent'"
                          :d="`M ${link.x1} ${link.y1} L ${link.x1} ${link.y2} L ${link.x2} ${link.y2}`"
                        />
                        <line
                          v-else
                          :x1="link.x1"
                          :y1="link.y1"
                          :x2="link.x2"
                          :y2="link.y2"
                        />
                      </template>
                    </g>
                  </svg>

                  <!-- Cartes positionnées -->
                  <div
                    v-for="node in layoutNodes"
                    :key="node.id"
                    class="absolute origin-top-left"
                    :style="{
                      left: `${node.x}px`,
                      top: `${node.y}px`,
                      transform: `scale(${cardScale})`
                    }"
                  >
                    <MoleculesCard
                      type="profile"
                      :image-url="node.person.imageUrl"
                      :title="node.person.name"
                      :contract-type="node.person.pole"
                      :description="node.person.position"
                      :disc-icon="node.person.discProfile"
                      :show-profile-link="false"
                    />
                  </div>
                </div>
              </div>
            </div>

            <!-- DISC Block -->
            <div class="w-full lg:w-1/2 bg-white rounded-lg p-[20px] border border-Grey-300 flex flex-col gap-[24px]" style="min-height: 480px;">
              <div class="flex justify-between items-center w-full">
                <h5 class="text-xl font-semibold text-primary-500">Répartition DISC</h5>
                <LucideChartPie :size="24" :stroke-width="1.5" class="text-Orange-500" />
              </div>

              <div class="flex flex-1 items-center justify-center">
                <div class="relative w-full max-w-[520px] aspect-square">
                  <!-- DISC circulaire avec 4 quadrants -->
                  <div class="relative w-full h-full rounded-full overflow-hidden">
                    <!-- Quadrant D (Rouge - haut droit) -->
                    <div class="absolute top-0 right-0 w-1/2 h-1/2 bg-[#EB4335]" style="border-radius: 0 100% 0 0;"></div>
                    <!-- Quadrant I (Jaune - bas droit) -->
                    <div class="absolute bottom-0 right-0 w-1/2 h-1/2 bg-[#FFD83B]" style="border-radius: 0 0 100% 0;"></div>
                    <!-- Quadrant S (Vert - bas gauche) -->
                    <div class="absolute bottom-0 left-0 w-1/2 h-1/2 bg-[#45CA24]" style="border-radius: 0 0 0 100%;"></div>
                    <!-- Quadrant C (Bleu - haut gauche) -->
                    <div class="absolute top-0 left-0 w-1/2 h-1/2 bg-[#476EF6]" style="border-radius: 100% 0 0 0;"></div>
                    
                    <!-- Lettres DISC - centrées et alignées -->
                    <div class="absolute" style="left: 23%; top: 21%; font-family: 'Nunito'; font-weight: 700; font-size: clamp(3rem, 10vw, 5.5rem); line-height: 1; color: rgba(253, 253, 253, 0.5);">C</div>
                    <div class="absolute" style="left: 66%; top: 21%; font-family: 'Nunito'; font-weight: 700; font-size: clamp(3rem, 10vw, 5.5rem); line-height: 1; color: rgba(253, 253, 253, 0.5);">D</div>
                    <div class="absolute" style="left: 23%; top: 63%; font-family: 'Nunito'; font-weight: 700; font-size: clamp(3rem, 10vw, 5.5rem); line-height: 1; color: rgba(253, 253, 253, 0.5);">S</div>
                    <div class="absolute" style="left: 70%; top: 63%; font-family: 'Nunito'; font-weight: 700; font-size: clamp(3rem, 10vw, 5.5rem); line-height: 1; color: rgba(253, 253, 253, 0.5);">I</div>
                  </div>
                  
                  <!-- Pastilles pour chaque personne -->
                  <div
                    v-for="person in discPositions"
                    :key="person.id"
                    class="absolute flex items-center justify-center bg-black rounded-full cursor-pointer transition-transform hover:scale-110 group"
                    :style="{
                      left: `${person.x}%`,
                      top: `${person.y}%`,
                      width: '8%',
                      height: '8%'
                    }"
                  >
                    <span class="text-white font-roboto text-[calc(clamp(0.5rem,_1vw_+_0.2rem,_1rem))]">{{ person.initials }}</span>
                    <!-- Tooltip personnalisé -->
                    <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-2 bg-primary-900 text-white text-sm font-roboto rounded-lg whitespace-nowrap opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 pointer-events-none z-50">
                      {{ person.name }}
                      <div class="absolute top-full left-1/2 transform -translate-x-1/2 -mt-1 border-4 border-transparent border-t-primary-900"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      </main>
    </div>
  </div>

</template>

<script setup lang="ts">
import { ref, computed, watch } from 'vue'

useHead({
  title: 'Équipe & Management - Tholka RH',
})

// État de la sidebar mobile
const isSidebarOpen = ref(false)

type Person = {
  id: number
  name: string
  position: string
  pole: string
  discProfile: string
  imageUrl: string
  subordinates?: Person[]
}

const currentView = ref<'directory' | 'mapping'>('directory')
const currentPage = ref(1)
const itemsPerPage = 12
const depthOffset = 25
const levelGap = 20 // px spacing between cards in a level
const cardScale = 0.6 // réduit à 0.6 pour gérer le niveau supplémentaire
const baseCardWidth = 272
const baseCardHeight = 134
const cardWidth = baseCardWidth * cardScale
const cardHeight = baseCardHeight * cardScale
const horizontalGap = 80 // réduit pour gérer le niveau supplémentaire
const horizontalGapLevel1 = 40 // resserre la ligne du milieu (niveau 1)
const horizontalGapLevel2 = 30 // resserre encore plus le niveau 2
const verticalGap = 50 // réduit pour gérer 4 niveaux
const levelOffsetX = 50 // réduit pour éviter que les cartes sortent
const maxCardsPerRow = 2 // limite à 2 cartes par ligne
const parentConnectorOffset = 12

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
    label: 'Pôle',
    options: [
      { id: 'Communication', label: 'Communication' },
      { id: 'RH', label: 'RH' },
      { id: 'Informatique', label: 'Informatique' },
      { id: 'Designer', label: 'Design' },
      { id: 'Comptabilité', label: 'Comptabilité' },
      { id: 'SAV', label: 'SAV' },
      { id: 'Logistique', label: 'Logistique' },
      { id: 'Support', label: 'Support' }
    ]
  },
  {
    label: 'Profil DISC',
    options: [
      { id: 'D', label: 'Rouge', color: '#EB5035' },
      { id: 'I', label: 'Jaune', color: '#FFD83B' },
      { id: 'S', label: 'Vert', color: '#45CA24' },
      { id: 'C', label: 'Bleu', color: '#6B7280' }
    ]
  }
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

  const poleFilter = selectedFilters.value['Pôle']
  if (poleFilter && poleFilter.length) {
    result = result.filter((person) => poleFilter.includes(person.pole))
  }

  const discFilter = selectedFilters.value['Profil DISC']
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

// Organigramme data structure (avec niveau RH au-dessus)
const poleOptions = computed(() => {
  const set = new Set<string>()
  collaborators.value.forEach((c) => {
    if (c.pole) set.add(c.pole)
  })
  return Array.from(set)
})

const selectedPoleMapping = ref('')

watch(poleOptions, (opts) => {
  if (!selectedPoleMapping.value && opts.length) {
    selectedPoleMapping.value = opts[0]
  } else if (selectedPoleMapping.value && !opts.includes(selectedPoleMapping.value)) {
    selectedPoleMapping.value = opts[0] || ''
  }
}, { immediate: true })

const organigrammeData = computed<{ chef: Person } | null>(() => {
  const rhLead = collaborators.value.find((c) => c.pole === 'RH') || collaborators.value[0]
  if (!rhLead || !selectedPoleMapping.value) return null

  // Récupérer tous les membres du pôle sélectionné (sans le RH)
  const poleMembers = collaborators.value.filter(
    (c) => c.pole === selectedPoleMapping.value && c.id !== rhLead.id
  )

  if (poleMembers.length === 0) {
    // Si le pôle n'a pas de membres (RH ne compte pas), retourner just le RH sans subordinates
    return {
      chef: {
        ...rhLead,
        subordinates: []
      }
    }
  }

  // Fonctions de classification par seniority
  const isDirector = (person: Person) => {
    const title = person.position.toLowerCase()
    return title.includes('directeur') || title.includes('directrice') || title.includes('pdg')
  }

  const isResponsable = (person: Person) => {
    const title = person.position.toLowerCase()
    return (title.includes('responsable') || title.includes('manager')) && !isDirector(person)
  }

  // Trier les membres par niveau hiérarchique
  const directors = poleMembers.filter(isDirector)
  const responsables = poleMembers.filter(isResponsable)
  const juniors = poleMembers.filter((p) => !isDirector(p) && !isResponsable(p))

  // Construire la hiérarchie : directeurs > responsables > juniors
  let level1: Person[] = []

  if (directors.length > 0) {
    // Directeurs en niveau 1, tous les autres en subordinates
    level1 = directors.map((dir) => ({
      ...dir,
      subordinates: responsables.concat(juniors)
    }))
  } else if (responsables.length > 0) {
    // Pas de directeur : responsables en niveau 1, juniors distribués sous eux
    level1 = responsables.map((resp, idx) => ({
      ...resp,
      subordinates: juniors.filter((_, jIdx) => jIdx % Math.max(1, responsables.length) === idx)
    }))
  } else {
    // Que des juniors : tous en niveau 1 sans subordinates
    level1 = juniors.map((j) => ({
      ...j,
      subordinates: []
    }))
  }

  return {
    chef: {
      ...rhLead,
      subordinates: level1
    }
  }
})

// Construire les niveaux de l'organigramme pour un padding horizontal régulier
const organigrammeLevels = computed(() => {
  const levels: Person[][] = []
  if (!organigrammeData.value) return levels

  const walk = (person: Person, depth: number) => {
    if (!levels[depth]) levels[depth] = []
    levels[depth].push(person)
    person.subordinates?.forEach((sub) => walk(sub, depth + 1))
  }
  walk(organigrammeData.value.chef, 0)
  return levels
})

// Layout: positions and connectors
type PositionedNode = { id: number; person: Person; x: number; y: number }
type Connector = { x1: number; y1: number; x2: number; y2: number; type: 'parent' | 'sibling' }

const layoutNodes = computed<PositionedNode[]>(() => {
  const nodes: PositionedNode[] = []
  organigrammeLevels.value.forEach((level, depth) => {
    const offsetX = depth * levelOffsetX
    let gapX = horizontalGap
    if (depth === 1) gapX = horizontalGapLevel1
    if (depth === 2) gapX = horizontalGapLevel2

    level.forEach((person, idx) => {
      const col = idx % maxCardsPerRow
      const row = Math.floor(idx / maxCardsPerRow)
      const x = offsetX + col * (cardWidth + gapX)
      const y = depth * (cardHeight + verticalGap) + row * (cardHeight + verticalGap)
      nodes.push({ id: person.id, person, x, y })
    })
  })
  return nodes
})

const layoutHeight = computed(() => {
  let maxY = 0
  organigrammeLevels.value.forEach((level, depth) => {
    const rows = Math.ceil(level.length / maxCardsPerRow)
    const bottomY = depth * (cardHeight + verticalGap) + (rows - 1) * (cardHeight + verticalGap) + cardHeight
    if (bottomY > maxY) maxY = bottomY
  })
  return maxY + 40 // extra breathing room
})

const connectors = computed<Connector[]>(() => {
  const links: Connector[] = []
  const nodeById = new Map<number, PositionedNode>()
  layoutNodes.value.forEach((n) => nodeById.set(n.id, n))

  // Parent-child connectors (from bottom-left of parent to mid-left of child)
  const walk = (person: Person) => {
    const parentNode = nodeById.get(person.id)
    person.subordinates?.forEach((child) => {
      const childNode = nodeById.get(child.id)
      if (parentNode && childNode) {
        const xStart = parentNode.x + parentConnectorOffset
        links.push({
          x1: xStart,
          y1: parentNode.y + cardHeight,
          x2: childNode.x,
          y2: childNode.y + cardHeight / 2,
          type: 'parent'
        })
      }
      walk(child)
    })
  }
  if (organigrammeData.value) {
    walk(organigrammeData.value.chef)
  }

  // Sibling connectors (mid-right to mid-left)
  organigrammeLevels.value.forEach((level) => {
    level.forEach((person, idx) => {
      const currentRow = Math.floor(idx / maxCardsPerRow)
      const nextRow = Math.floor((idx + 1) / maxCardsPerRow)
      // Skip sibling connector when next card is on the next wrapped row
      if (currentRow !== nextRow) return

      const currentNode = nodeById.get(person.id)
      const nextPerson = level[idx + 1]
      if (currentNode && nextPerson) {
        const nextNode = nodeById.get(nextPerson.id)
        if (nextNode) {
          links.push({
            x1: currentNode.x + cardWidth,
            y1: currentNode.y + cardHeight / 2,
            x2: nextNode.x,
            y2: nextNode.y + cardHeight / 2,
            type: 'sibling'
          })
        }
      }
    })
  })

  return links
})

// DISC positions: placer les pastilles pour chaque personne de l'organigramme
const allOrganigrammePersons = computed(() => {
  const persons: Person[] = []
  const walk = (person: Person) => {
    persons.push(person)
    person.subordinates?.forEach(walk)
  }
  if (organigrammeData.value) {
    walk(organigrammeData.value.chef)
  }
  return persons
})

const discPositions = computed(() => {
  // Zones pour chaque profil DISC (cercle 520x520 divisé en 4 quadrants)
  // Coordonnées plus précises pour le DISC HTML/CSS
  const zones: Record<string, { minX: number; maxX: number; minY: number; maxY: number; centerX: number; centerY: number }> = {
    C: { minX: 60, maxX: 200, minY: 120, maxY: 240, centerX: 120, centerY: 180 },   // Quart haut gauche (bleu)
    D: { minX: 320, maxX: 460, minY: 120, maxY: 240, centerX: 380, centerY: 180 },  // Quart haut droit (rouge)
    I: { minX: 320, maxX: 460, minY: 280, maxY: 400, centerX: 380, centerY: 340 },  // Quart bas droit (jaune)
    S: { minX: 60, maxX: 200, minY: 280, maxY: 400, centerX: 120, centerY: 340 }   // Quart bas gauche (vert)
  }

  // Grouper les personnes par profil DISC
  const byProfile: Record<string, Person[]> = { C: [], D: [], I: [], S: [] }
  allOrganigrammePersons.value.forEach((person) => {
    if (byProfile[person.discProfile]) {
      byProfile[person.discProfile].push(person)
    }
  })

  // Créer les positions en répartissant dans chaque zone
  const positions: Array<{ id: number; name: string; initials: string; x: number; y: number }> = []
  Object.entries(byProfile).forEach(([profile, persons]) => {
    const zone = zones[profile]
    if (!zone) return

    persons.forEach((person, idx) => {
      // Extraire les initiales (première lettre du prénom et du nom)
      const nameParts = person.name.split(' ')
      const initials = nameParts.length >= 2
        ? `${nameParts[0][0]}${nameParts[1][0]}`
        : nameParts[0].substring(0, 2)

      let x: number, y: number

      if (persons.length === 1) {
        // Si une seule personne, position centrale
        x = zone.centerX
        y = zone.centerY
      } else {
        // Répartir en grille dans la zone
        const cols = Math.ceil(Math.sqrt(persons.length))
        const rows = Math.ceil(persons.length / cols)
        const col = idx % cols
        const row = Math.floor(idx / cols)
        
        // Calculer la position avec espacement dans la zone
        const xStep = (zone.maxX - zone.minX) / (cols + 1)
        const yStep = (zone.maxY - zone.minY) / (rows + 1)
        
        x = zone.minX + xStep * (col + 1)
        y = zone.minY + yStep * (row + 1)
      }

      positions.push({
        id: person.id,
        name: person.name,
        initials: initials.toUpperCase(),
        x: (x / 520) * 100,
        y: (y / 520) * 100
      })
    })
  })

  return positions
})

</script>
