<template>
  <div class="flex flex-col 3xl:flex-row gap-6 w-full">
    <!-- Organigramme Block -->
    <div class="w-full 3xl:w-1/2 bg-white rounded-lg px-[14px] py-5 border border-Grey-300">
      <div class="flex flex-col" :class="showPoleSelector ? 'mb-5' : 'mb-[56px]'">
        <div class="flex justify-between items-start" :class="showPoleSelector ? 'mb-[40px]' : ''">
          <div class="flex flex-col gap-6">
            <h5 class="text-h5 font-bold text-primary-500 font-sans">Organigramme</h5>
            <!-- Mode texte fixe (Collaborateur) - en dessous du titre -->
            <span v-if="!showPoleSelector" class="font-sans font-bold text-[18px] text-primary-500">Pôle : {{ currentPole }}</span>
          </div>
          <LucideUsers2 :size="24" :stroke-width="1" class="text-Orange-500" />
        </div>
        <!-- Sélecteur de pôle (RH uniquement) -->
        <div v-if="showPoleSelector" class="flex justify-end -mr-[14px]">
          <MoleculesFilterBar
            :filters="organigrammeFilters"
            variant="light"
            dropdown-position="right"
            @update-filter="handleOrganigrammeFilterUpdate"
            @apply-filter="handleOrganigrammeFilterApply"
          />
        </div>
      </div>

      <!-- Affichage hiérarchique par niveau -->
      <div class="flex flex-col gap-4">
        <div 
          v-for="levelGroup in hierarchyByPole" 
          :key="levelGroup.level"
          class="relative"
        >
          <!-- Connecteur L vers le niveau parent (SVG) -->
          <svg 
            v-if="levelGroup.level > 0"
            class="absolute pointer-events-none overflow-visible"
            :style="{
              left: `${getLevelPadding(levelGroup.level - 1) + 12}px`,
              top: '-16px',
              width: `calc(100% - ${getLevelPadding(levelGroup.level - 1) + 12}px)`,
              height: `${GAP_LEVELS + CARD_HEIGHT + (isMobile ? (levelGroup.collaborators.length - 1) * (CARD_HEIGHT + GAP_CARDS) : Math.ceil(levelGroup.collaborators.length / 2 - 1) * (CARD_HEIGHT + GAP_CARDS)) + MID_Y}px`
            }"
          >
            <!-- Ligne verticale principale du L -->
            <line 
              x1="0" 
              :y1="0" 
              x2="0" 
              :y2="GAP_LEVELS + MID_Y"
              stroke="#AEACAC" 
              stroke-width="1"
            />
            <!-- Ligne horizontale du L vers la première card -->
            <line 
              x1="0" 
              :y1="GAP_LEVELS + MID_Y" 
              :x2="getLevelPadding(levelGroup.level) - getLevelPadding(levelGroup.level - 1) - 12" 
              :y2="GAP_LEVELS + MID_Y"
              stroke="#AEACAC" 
              stroke-width="1"
            />
            
            <!-- Desktop: connecteurs verticaux et horizontaux pour les lignes suivantes -->
            <template v-if="!isMobile">
              <g v-for="(_, rowIdx) in Math.ceil(levelGroup.collaborators.length / 2)" :key="'row-' + rowIdx">
                <!-- Trait horizontal entre les 2 cards de cette ligne (si 2 cards sur cette ligne) -->
                <rect 
                  v-if="rowIdx * 2 + 1 < levelGroup.collaborators.length"
                  x="50%"
                  :y="GAP_LEVELS + MID_Y + rowIdx * (CARD_HEIGHT + GAP_CARDS)"
                  :width="GAP_CARDS"
                  height="1"
                  fill="#AEACAC"
                />
                <!-- Trait vertical de continuation vers la ligne suivante (si il y a une ligne suivante) -->
                <line 
                  v-if="(rowIdx + 1) * 2 < levelGroup.collaborators.length"
                  x1="0"
                  :y1="GAP_LEVELS + MID_Y + rowIdx * (CARD_HEIGHT + GAP_CARDS)"
                  x2="0"
                  :y2="GAP_LEVELS + MID_Y + (rowIdx + 1) * (CARD_HEIGHT + GAP_CARDS)"
                  stroke="#AEACAC" 
                  stroke-width="1"
                />
                <!-- Ligne horizontale vers la première card de la ligne suivante -->
                <line 
                  v-if="(rowIdx + 1) * 2 < levelGroup.collaborators.length"
                  x1="0"
                  :y1="GAP_LEVELS + MID_Y + (rowIdx + 1) * (CARD_HEIGHT + GAP_CARDS)"
                  :x2="getLevelPadding(levelGroup.level) - getLevelPadding(levelGroup.level - 1) - 12"
                  :y2="GAP_LEVELS + MID_Y + (rowIdx + 1) * (CARD_HEIGHT + GAP_CARDS)"
                  stroke="#AEACAC" 
                  stroke-width="1"
                />
              </g>
            </template>
            
            <!-- Mobile: connecteurs en L vers chaque card -->
            <template v-else>
              <g v-for="(_, cardIdx) in levelGroup.collaborators.length - 1" :key="'card-' + cardIdx">
                <!-- Continuation verticale principale du L -->
                <line 
                  x1="0"
                  :y1="GAP_LEVELS + MID_Y + cardIdx * (CARD_HEIGHT + GAP_CARDS)"
                  x2="0"
                  :y2="GAP_LEVELS + MID_Y + (cardIdx + 1) * (CARD_HEIGHT + GAP_CARDS)"
                  stroke="#AEACAC" 
                  stroke-width="1"
                />
                <!-- Ligne horizontale vers chaque card suivante -->
                <line 
                  x1="0"
                  :y1="GAP_LEVELS + MID_Y + (cardIdx + 1) * (CARD_HEIGHT + GAP_CARDS)"
                  :x2="getLevelPadding(levelGroup.level) - getLevelPadding(levelGroup.level - 1) - 12"
                  :y2="GAP_LEVELS + MID_Y + (cardIdx + 1) * (CARD_HEIGHT + GAP_CARDS)"
                  stroke="#AEACAC" 
                  stroke-width="1"
                />
              </g>
            </template>
          </svg>

          <!-- Cards du niveau -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-3" :class="{ 'pl-6': levelGroup.level === 1, 'pl-12': levelGroup.level === 2, 'pl-16': levelGroup.level >= 3 }">
            <MoleculesCard
              v-for="collaborator in levelGroup.collaborators"
              :key="collaborator.id"
              type="profile"
              :image-url="collaborator.imageUrl"
              :title="collaborator.name"
              :contract-type="collaborator.pole"
              :description="collaborator.position"
              :disc-icon="collaborator.discProfile"
              :show-profile-link="false"
              :fixed-height="`${CARD_HEIGHT}px`"
              :full-width="true"
            />
          </div>
        </div>

        <!-- Message si aucun collaborateur dans ce pôle -->
        <div v-if="hierarchyByPole.length === 0" class="text-center text-Grey-500 py-8">
          Aucun collaborateur dans ce pôle
        </div>
      </div>
    </div>

    <!-- DISC Block -->
    <div class="w-full 3xl:w-1/2 bg-white rounded-lg px-[23px] py-5 border border-Grey-300 flex flex-col gap-6" style="min-height: 600px;">
      <div class="flex justify-between items-center w-full">
        <h5 class="text-h5 font-bold text-primary-500 font-sans">Répartition DISC</h5>
        <LucidePieChart :size="24" :stroke-width="1" class="text-Orange-500" />
      </div>

      <div class="flex flex-1 items-center justify-center py-6">
        <div class="relative w-full aspect-square">
          <!-- DISC circulaire avec 4 quadrants -->
          <div class="relative w-full h-full rounded-full overflow-hidden">
            <!-- Quadrant D (Rouge - haut droit) -->
            <div class="absolute top-0 right-0 w-1/2 h-1/2 bg-Red-disc" style="border-radius: 0 100% 0 0;"></div>
            <!-- Quadrant I (Jaune - bas droit) -->
            <div class="absolute bottom-0 right-0 w-1/2 h-1/2 bg-Yellow-disc" style="border-radius: 0 0 100% 0;"></div>
            <!-- Quadrant S (Vert - bas gauche) -->
            <div class="absolute bottom-0 left-0 w-1/2 h-1/2 bg-Green-disc" style="border-radius: 0 0 0 100%;"></div>
            <!-- Quadrant C (Bleu - haut gauche) -->
            <div class="absolute top-0 left-0 w-1/2 h-1/2 bg-Blue-disc" style="border-radius: 100% 0 0 0;"></div>
            
            <!-- Lettres DISC - centrées et alignées (positions en pourcentage) -->
            <div class="absolute font-sans font-bold text-[clamp(40px,17vw,88px)] leading-none text-white/50" style="left: 23%; top: 21%;">C</div>
            <div class="absolute font-sans font-bold text-[clamp(40px,17vw,88px)] leading-none text-white/50" style="left: 66%; top: 21%;">D</div>
            <div class="absolute font-sans font-bold text-[clamp(40px,17vw,88px)] leading-none text-white/50" style="left: 23%; top: 63%;">S</div>
            <div class="absolute font-sans font-bold text-[clamp(40px,17vw,88px)] leading-none text-white/50" style="left: 70%; top: 63%;">I</div>
          </div>
          
          <!-- Pastilles pour chaque personne (positions en pourcentage) -->
          <div
            v-for="person in discPositions"
            :key="person.id"
            class="disc-pastille absolute flex items-center justify-center bg-Black rounded-full w-[8%] aspect-square min-w-[32px] max-w-[42px] cursor-pointer"
            :style="{
              left: `${person.xPercent}%`,
              top: `${person.yPercent}%`
            }"
          >
            <span class="text-Light font-roboto text-xs sm:text-base">{{ person.initials }}</span>
            <!-- Tooltip -->
            <div class="disc-tooltip">
              <span class="disc-tooltip-text">{{ person.name }}</span>
              <div class="disc-tooltip-beak"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, watch, onMounted, onUnmounted } from 'vue'
import { Users2 as LucideUsers2, PieChart as LucidePieChart } from 'lucide-vue-next'

// Constantes pour les connecteurs
const CARD_HEIGHT = 134
const GAP_CARDS = 12 // gap-3
const GAP_LEVELS = 16 // gap-4
const MID_Y = CARD_HEIGHT / 2 // 67px

// Responsive: détecter si mobile (1 colonne) ou desktop (2 colonnes)
const isMobile = ref(false)

const checkIsMobile = () => {
  if (typeof window !== 'undefined') {
    isMobile.value = window.innerWidth < 640 // breakpoint sm: 640px
  }
}

onMounted(() => {
  checkIsMobile()
  window.addEventListener('resize', checkIsMobile)
})

onUnmounted(() => {
  window.removeEventListener('resize', checkIsMobile)
})

// Types
interface Collaborator {
  id: number
  name: string
  position: string
  pole: string
  discProfile: string
  imageUrl: string
  department: string
  status: string
  managerId: number | null
}

// Props
const props = defineProps<{
  collaborators: Collaborator[]
  showPoleSelector?: boolean
  fixedPole?: string
}>()

// Pôle courant (soit fixé, soit sélectionné)
const selectedPole = ref(props.fixedPole || 'RH')

// Pôle actuellement actif
const currentPole = computed(() => {
  return props.fixedPole || selectedPole.value
})

// Watch pour mettre à jour si fixedPole change
watch(() => props.fixedPole, (newPole) => {
  if (newPole) {
    selectedPole.value = newPole
  }
})

// Liste des pôles disponibles pour l'organigramme
const availablePoles = computed(() => {
  const poles = new Set(props.collaborators.map(c => c.pole))
  return Array.from(poles).sort()
})

// Helper pour le padding par niveau
const getLevelPadding = (level: number) => {
  if (level <= 0) return 0
  if (level === 1) return 24
  if (level === 2) return 48
  return 64
}

// Configuration du filtre pour l'organigramme
const organigrammeFilters = computed(() => [
  {
    id: 'pole',
    label: 'Pôle',
    options: availablePoles.value.map(pole => ({ id: pole, label: pole })),
    value: [selectedPole.value],
    singleSelect: true
  }
])

// Handlers pour le filtre organigramme
const handleOrganigrammeFilterUpdate = ({ id, value }: { id: string; value: string[] }) => {
  if (id === 'pole' && value.length > 0) {
    selectedPole.value = value[0]
  }
}

const handleOrganigrammeFilterApply = ({ id, value }: { id: string; value: string[] }) => {
  if (id === 'pole' && value.length > 0) {
    selectedPole.value = value[0]
  }
}

// Calculer le niveau hiérarchique de chaque collaborateur dans un pôle
const hierarchyByPole = computed(() => {
  const poleCollaborators = props.collaborators.filter(
    c => c.pole === currentPole.value
  )

  // Fonction pour calculer le niveau hiérarchique (0 = top)
  const calculateLevel = (collaborator: typeof poleCollaborators[0], visited = new Set<number>()): number => {
    if (visited.has(collaborator.id)) return 0 // Éviter les boucles
    visited.add(collaborator.id)

    if (collaborator.managerId === null) {
      return 0 // Top level - pas de manager
    }

    const manager = props.collaborators.find(c => c.id === collaborator.managerId)
    if (!manager || manager.pole !== currentPole.value) {
      return 0 // Manager n'existe pas ou est dans un autre pôle
    }

    return 1 + calculateLevel(manager, visited)
  }

  // Calculer le niveau pour chaque collaborateur du pôle
  const withLevels = poleCollaborators.map(c => ({
    ...c,
    level: calculateLevel(c)
  }))

  // Trier par niveau (les plus importants d'abord)
  withLevels.sort((a, b) => a.level - b.level)

  // Grouper par niveau
  const levels: Array<{ level: number; collaborators: typeof withLevels }> = []
  withLevels.forEach(c => {
    let levelGroup = levels.find(l => l.level === c.level)
    if (!levelGroup) {
      levelGroup = { level: c.level, collaborators: [] }
      levels.push(levelGroup)
    }
    levelGroup.collaborators.push(c)
  })

  // Trier les groupes par niveau
  levels.sort((a, b) => a.level - b.level)

  return levels
})

// Collaborateurs du pôle pour le DISC
const poleCollaborators = computed(() => {
  return props.collaborators.filter(c => c.pole === currentPole.value)
})

// DISC positions: placer les pastilles pour chaque personne du pôle sélectionné
const discPositions = computed(() => {
  // Zones pour chaque profil DISC (en pourcentage du conteneur)
  const zones: Record<string, { minX: number; maxX: number; minY: number; maxY: number; centerX: number; centerY: number }> = {
    C: { minX: 12, maxX: 38, minY: 23, maxY: 46, centerX: 23, centerY: 35 },   // Quart haut gauche (bleu)
    D: { minX: 62, maxX: 88, minY: 23, maxY: 46, centerX: 73, centerY: 35 },   // Quart haut droit (rouge)
    I: { minX: 62, maxX: 88, minY: 54, maxY: 77, centerX: 73, centerY: 65 },   // Quart bas droit (jaune)
    S: { minX: 12, maxX: 38, minY: 54, maxY: 77, centerX: 23, centerY: 65 }    // Quart bas gauche (vert)
  }

  // Grouper les collaborateurs du pôle par profil DISC
  const byProfile: Record<string, typeof poleCollaborators.value> = { C: [], D: [], I: [], S: [] }
  poleCollaborators.value.forEach((person) => {
    if (byProfile[person.discProfile]) {
      byProfile[person.discProfile].push(person)
    }
  })

  // Créer les positions en répartissant dans chaque zone (en pourcentage)
  const positions: Array<{ id: number; name: string; initials: string; xPercent: number; yPercent: number }> = []
  Object.entries(byProfile).forEach(([profile, persons]) => {
    const zone = zones[profile]
    if (!zone) return

    persons.forEach((person, idx) => {
      // Extraire les initiales (première lettre du prénom et du nom)
      const nameParts = person.name.split(' ')
      const initials = nameParts.length >= 2
        ? `${nameParts[0][0]}${nameParts[1][0]}`
        : nameParts[0].substring(0, 2)

      let xPercent: number, yPercent: number

      if (persons.length === 1) {
        // Si une seule personne, position centrale
        xPercent = zone.centerX
        yPercent = zone.centerY
      } else {
        // Répartir en grille dans la zone
        const cols = Math.ceil(Math.sqrt(persons.length))
        const rows = Math.ceil(persons.length / cols)
        const col = idx % cols
        const row = Math.floor(idx / cols)
        
        // Calculer la position avec espacement dans la zone
        const xStep = (zone.maxX - zone.minX) / (cols + 1)
        const yStep = (zone.maxY - zone.minY) / (rows + 1)
        
        xPercent = zone.minX + xStep * (col + 1)
        yPercent = zone.minY + yStep * (row + 1)
      }

      positions.push({
        id: person.id,
        name: person.name,
        initials: initials.toUpperCase(),
        xPercent,
        yPercent
      })
    })
  })

  return positions
})
</script>

<style scoped>
/* Styles pour les tooltips DISC */
.disc-pastille {
  position: absolute;
}

.disc-tooltip {
  position: absolute;
  bottom: calc(100% + 10px);
  left: 50%;
  transform: translateX(-50%);
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 8px 10px;
  background: #0E0E0E;
  border-radius: 4px;
  white-space: nowrap;
  opacity: 0;
  visibility: hidden;
  transition: opacity 0.2s ease, visibility 0.2s ease;
  z-index: 50;
}

.disc-pastille:hover .disc-tooltip {
  opacity: 1;
  visibility: visible;
}

.disc-tooltip-text {
  font-family: 'Roboto', sans-serif;
  font-style: normal;
  font-weight: 400;
  font-size: 16px;
  line-height: 140%;
  text-align: center;
  color: #FFFFFF;
}

.disc-tooltip-beak {
  position: absolute;
  width: 24px;
  height: 15px;
  left: calc(50% - 12px);
  bottom: -10px;
  background: #0E0E0E;
  border-radius: 1px;
  clip-path: polygon(50% 100%, 0 0, 100% 0);
}
</style>
