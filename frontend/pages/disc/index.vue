<template>
  <div class="flex flex-col w-full min-h-screen bg-secondary-300">
    <!-- Header -->
    <OrganismsNavbar :is-sidebar-open="isSidebarOpen" @toggle-sidebar="isSidebarOpen = !isSidebarOpen" />

    <!-- Content avec Sidebar -->
    <div class="flex w-full" style="margin-top: 82.73px;">
      <!-- Sidebar -->
      <OrganismsSidebarCollaborateur active-item="test-disc" :is-open="isSidebarOpen" @close="isSidebarOpen = false" />

      <!-- Main Content -->
      <div class="relative flex flex-col items-start p-6 lg:p-[32px] gap-5 flex-1 ml-0 lg:ml-[300px]">
        <!-- Video/GIF Overlay -->
        <Transition name="fade">
          <div
            v-if="showVideoOverlay"
            class="absolute inset-0 z-50 flex items-center justify-center bg-white/80 backdrop-blur-sm"
          >
            <!-- GIF pour tous les profils -->
            <img
              :src="videoSource"
              alt="Reveal animation"
              class="max-w-[500px] max-h-[500px] w-auto h-auto object-contain"
              @load="startGifTimer"
            />
          </div>
        </Transition>

        <!-- Progress Bar (Outside the card) -->
        <div class="w-full">
          <MoleculesProgressBar :percentage="(getQuestionNumberInCategory() / getQuestionsCountInCategory()) * 100" />
        </div>

        <!-- Test Form -->
        <div class="flex flex-col items-center px-4 md:px-[40px] pt-[40px] pb-[80px] gap-12 lg:gap-[96px] w-full bg-white rounded-[20px]">

          <!-- Question -->
          <div v-if="currentQuestion" class="w-full flex flex-col items-center gap-12 lg:gap-[96px]">
            <!-- Tag Row: catégorie + numéro de question -->
            <div class="flex flex-col md:flex-row justify-between items-center gap-2 md:gap-0 w-full px-0">
              <span class="inline-flex items-center justify-center px-4 py-2 bg-[#EBEBF5] text-[#3A3B99] rounded-[20px] font-roboto font-normal text-sm text-center">
                {{ getCategoryIndex() + 1 }}/{{ getTotalCategories() }} - {{ currentQuestion.category }}
              </span>
              <p class="font-roboto font-medium text-base text-[#3A3B99] text-center">Question {{ getQuestionNumberInCategory() }}/{{ getQuestionsCountInCategory() }}</p>
            </div>

            <!-- Titre de la question (séparé) -->
            <h2 class="font-nunito font-bold text-2xl md:text-[40px] md:leading-[55px] text-center text-[#3A3B99] max-w-[770px] px-4">{{ currentQuestion.question }}</h2>
            
            <!-- Answer Options Row -->
            <!-- Ordre fixe: rouge (pas du tout), jaune (partiellement), vert (plutôt), bleu (vraiment) -->
            <!-- La lettre DISC associée change selon la question mais reste cachée -->
            <div class="flex flex-row flex-wrap justify-center items-center gap-6 lg:gap-[64px] w-full">
              <div
                v-for="(option, index) in currentQuestion.options"
                :key="index"
                class="flex flex-col items-center gap-6 w-[180px] md:w-[220px] lg:w-[250px]"
              >
                <!-- Icon Circle - Icône fixe selon l'index (position) -->
                <div
                  class="flex items-center justify-center rounded-full transition-all w-[180px] h-[180px] md:w-[220px] md:h-[220px] lg:w-[247px] lg:h-[247px]"
                  :class="answers[currentQuestionIndex] === option.color ? 'bg-primary-500' : 'bg-[rgba(58,59,153,0.1)]'"
                >
                  <!-- Index 0: Pas du tout d'accord = Rouge -->
                  <img
                    v-if="index === 0"
                    src="~/assets/icons/red.svg"
                    alt="Pas du tout d'accord"
                    class="w-28 h-28 md:w-36 md:h-36 lg:w-40 lg:h-40"
                  />
                  <!-- Index 1: Partiellement d'accord = Jaune -->
                  <img
                    v-else-if="index === 1"
                    src="~/assets/icons/yellow.svg"
                    alt="Partiellement d'accord"
                    class="w-28 h-28 md:w-36 md:h-36 lg:w-40 lg:h-40"
                  />
                  <!-- Index 2: Plutôt d'accord = Vert -->
                  <img
                    v-else-if="index === 2"
                    src="~/assets/icons/green.svg"
                    alt="Plutôt d'accord"
                    class="w-32 h-32 md:w-40 md:h-40 lg:w-44 lg:h-44"
                  />
                  <!-- Index 3: Vraiment d'accord = Bleu -->
                  <img
                    v-else-if="index === 3"
                    src="~/assets/icons/blue.svg"
                    alt="Vraiment d'accord"
                    class="w-32 h-32 md:w-40 md:h-40 lg:w-44 lg:h-44"
                  />
                </div>

                <!-- Button - Le texte est fixe, la lettre DISC (option.color) est cachée -->
                <AtomsButton
                  variant="primary"
                  size="lg"
                  class="w-full !text-[14px] md:!text-[16px] lg:!text-[20px] whitespace-nowrap"
                  @click="selectAnswerAndNext(option.color)"
                >
                  {{ option.text }}
                </AtomsButton>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, nextTick, onUnmounted } from 'vue'
import { useRouter } from 'vue-router'
import { DISC_QUESTIONS } from '~/types/disc'

// Import des vidéos
import videoRouge from '~/assets/videos/reveal rouge.gif'
import videoJaune from '~/assets/videos/reveal jaune.gif'
import videoVert from '~/assets/videos/reveal vert.gif'
import videoBleu from '~/assets/videos/reveal bleu.gif'

const router = useRouter()

const answers = ref<(string | null)[]>(new Array(DISC_QUESTIONS.length).fill(null))
const currentQuestionIndex = ref(0)
const currentQuestion = ref(DISC_QUESTIONS[0])

// État pour l'overlay vidéo
const showVideoOverlay = ref(false)
const isSidebarOpen = ref(false)

// Calcul du profil dominant
const discCounts = computed(() => {
  const counts = { D: 0, I: 0, S: 0, C: 0 }
  answers.value.forEach((answer) => {
    if (answer && answer in counts) {
      counts[answer as keyof typeof counts]++
    }
  })
  return counts
})

const dominantProfile = computed(() => {
  const profiles = ['D', 'I', 'S', 'C'] as const
  let maxValue = 0
  let maxProfile: 'D' | 'I' | 'S' | 'C' = 'D'

  profiles.forEach(profile => {
    const value = discCounts.value[profile]
    if (value > maxValue) {
      maxValue = value
      maxProfile = profile
    }
  })

  return maxProfile
})

// Source de la vidéo selon le profil dominant
const videoSource = computed(() => {
  const videoMap: { [key: string]: string } = {
    D: videoRouge,    // Dominance - Rouge
    I: videoJaune,    // Influence - Jaune
    S: videoVert,     // Stabilité - Vert
    C: videoBleu      // Conformité - Bleu
  }
  return videoMap[dominantProfile.value] || videoBleu
})

const timerId = ref<NodeJS.Timeout | null>(null)

// Gestion du GIF (pas d'événement ended, donc on utilise un timer)
const startGifTimer = () => {
  // Durées spécifiques selon le profil (couleur)
  const durations: { [key: string]: number } = {
    D: 5200, // Rouge: 5.2s
    I: 5700, // Jaune: 5.7s
    S: 4170, // Vert: 4.17s (inchangé)
    C: 4700  // Bleu: 4.7s
  }

  const duration = durations[dominantProfile.value] || 4170

  timerId.value = setTimeout(() => {
    router.push('/disc/result')
  }, duration)
}

onUnmounted(() => {
  if (timerId.value) {
    clearTimeout(timerId.value)
  }
})

const selectAnswerAndNext = (color: string) => {
  // Retire le focus du bouton pour éviter que le style "actif/hover" persiste sur la question suivante
  if (document.activeElement instanceof HTMLElement) {
    document.activeElement.blur()
  }

  answers.value[currentQuestionIndex.value] = color
  
  if (currentQuestionIndex.value < DISC_QUESTIONS.length - 1) {
    currentQuestionIndex.value++
    currentQuestion.value = DISC_QUESTIONS[currentQuestionIndex.value]
  } else {
    // Dernière question, afficher la vidéo en overlay
    // On utilise localStorage pour plus de fiabilité
    localStorage.setItem('discAnswers', JSON.stringify(answers.value))
    sessionStorage.setItem('discAnswers', JSON.stringify(answers.value)) // Backup
    showVideoOverlay.value = true
  }
}

const getQuestionsCountInCategory = () => {
  if (!currentQuestion.value) return 0
  return DISC_QUESTIONS.filter(q => q.category === currentQuestion.value.category).length
}

const getQuestionNumberInCategory = () => {
  if (!currentQuestion.value) return 0
  const questionsInCategory = DISC_QUESTIONS.filter(q => q.category === currentQuestion.value.category)
  const currentQuestionInCategory = questionsInCategory.findIndex(q => q.question === currentQuestion.value.question)
  return currentQuestionInCategory + 1
}

// Récupérer toutes les catégories uniques
const getCategories = () => {
  const categories: string[] = []
  DISC_QUESTIONS.forEach(q => {
    if (!categories.includes(q.category)) {
      categories.push(q.category)
    }
  })
  return categories
}

const getTotalCategories = () => {
  return getCategories().length
}

const getCategoryIndex = () => {
  if (!currentQuestion.value) return 0
  const categories = getCategories()
  return categories.indexOf(currentQuestion.value.category)
}
</script>

<style scoped>
/* Transition fade pour l'overlay vidéo */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
