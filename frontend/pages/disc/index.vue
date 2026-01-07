<template>
  <div class="flex flex-col w-full min-h-screen bg-secondary-300">
    <!-- Header -->
    <OrganismsNavbar />

    <!-- Content avec Sidebar -->
    <div class="flex w-full" style="margin-top: 82.73px;">
      <!-- Sidebar -->
      <OrganismsSidebarCollaborateur active-item="test-disc" />

      <!-- Main Content -->
      <div class="flex flex-col items-start p-[32px] gap-[20px] flex-1" style="margin-left: 300px;">
        <!-- Progress Bar (Outside the card) -->
        <div class="w-full max-w-[1324px]">
          <MoleculesProgressBar :percentage="(currentQuestionIndex + 1) / DISC_QUESTIONS.length * 100" />
        </div>

        <!-- Test Form -->
        <div class="flex flex-col items-center p-[32px] gap-[24px] w-full max-w-[1324px] bg-white rounded-lg h-[580px]">

          <!-- Question -->
          <div v-if="currentQuestion" class="w-full flex flex-col justify-between flex-1">
            <div class="flex flex-col gap-2">
              <div class="flex justify-between items-center">
                <span class="inline-block px-4 bg-[#EBEBF5] text-[#3A3B99] rounded-full font-roboto font-normal text-sm" style="height: 34px; display: flex; align-items: center; justify-content: center;">
                  {{ currentQuestion.category }}
                </span>
                <p class="text-base font-roboto font-medium text-primary-500">Question {{ getQuestionNumberInCategory() }}/{{ getQuestionsCountInCategory() }}</p>
              </div>
              <h2 class="text-h2 font-sans text-primary-500 text-center line-clamp-3">{{ currentQuestion.question }}</h2>
            </div>
            
            <!-- Answer Options Row -->
            <div class="flex items-center justify-center gap-8">
              <div
                v-for="(option, index) in getSortedOptions(currentQuestion.options)"
                :key="index"
                class="flex flex-col items-center gap-4"
              >
                <!-- Icon Circle -->
                <div
                  class="flex items-center justify-center rounded-full transition-all"
                  :style="{
                    width: '247px',
                    height: '247px',
                    backgroundColor: answers[currentQuestionIndex] === option.color ? '#3A3B99' : '#3A3B991A'
                  }"
                >
                  <img
                    v-if="option.color === 'D'"
                    src="~/assets/icons/red.svg"
                    alt="Dominance"
                    class="w-24 h-24"
                  />
                  <img
                    v-else-if="option.color === 'I'"
                    src="~/assets/icons/yellow.svg"
                    alt="Influence"
                    class="w-24 h-24"
                  />
                  <img
                    v-else-if="option.color === 'S'"
                    src="~/assets/icons/green.svg"
                    alt="Stabilité"
                    class="w-24 h-24"
                  />
                  <img
                    v-else-if="option.color === 'C'"
                    src="~/assets/icons/blue.svg"
                    alt="Conformité"
                    class="w-24 h-24"
                  />
                </div>

                <!-- Button -->
                <button
                  class="px-4 py-3 font-roboto font-normal text-base rounded-lg bg-primary-500 text-white hover:bg-primary-700 transition-all"
                  :style="{ width: '250px' }"
                  @click="selectAnswerAndNext(option.color)"
                >
                  {{ option.text }}
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { DISC_QUESTIONS } from '~/types/disc'

const router = useRouter()

const answers = ref<(string | null)[]>(new Array(DISC_QUESTIONS.length).fill(null))
const currentQuestionIndex = ref(0)

const currentQuestion = ref(DISC_QUESTIONS[0])

const selectAnswerAndNext = (color: string) => {
  answers.value[currentQuestionIndex.value] = color
  
  if (currentQuestionIndex.value < DISC_QUESTIONS.length - 1) {
    currentQuestionIndex.value++
    currentQuestion.value = DISC_QUESTIONS[currentQuestionIndex.value]
  } else {
    // Dernière question, soumettre le test
    sessionStorage.setItem('discAnswers', JSON.stringify(answers.value))
    router.push('/disc/transition')
  }
}

const getSortedOptions = (options: any[]) => {
  const discOrder = ['D', 'I', 'S', 'C']
  return [...options].sort((a, b) => discOrder.indexOf(a.color) - discOrder.indexOf(b.color))
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
</script>
