<template>
  <Teleport to="body">
    <Transition
      enter-active-class="transition ease-out duration-200"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition ease-in duration-150"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div 
        v-if="isOpen"
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
        role="dialog"
        tabindex="-1"
        aria-labelledby="modal-new-offer-title"
        aria-modal="true"
      >
        <!-- Backdrop -->
        <div 
          class="absolute inset-0 bg-Black bg-opacity-50"
          @click="handleClose"
        ></div>
        
        <!-- Modal Dialog -->
        <Transition
          enter-active-class="transition ease-out duration-200"
          enter-from-class="opacity-0 scale-95"
          enter-to-class="opacity-100 scale-100"
          leave-active-class="transition ease-in duration-150"
          leave-from-class="opacity-100 scale-100"
          leave-to-class="opacity-0 scale-95"
        >
          <div 
            v-if="isOpen"
            class="relative w-full max-w-[1137px] max-h-[90vh] overflow-y-auto bg-Light rounded-lg shadow-xl"
          >
            <!-- Modal Content -->
            <div class="flex flex-col justify-center items-center p-6 md:p-10 gap-8">
              
              <!-- Close Button -->
              <button
                type="button"
                class="absolute top-2.5 right-2.5 flex items-center justify-center w-[38px] h-[38px] rounded-lg hover:bg-Grey-300 transition-colors"
                aria-label="Fermer"
                @click="handleClose"
              >
                <LucideX :size="16" :stroke-width="1.5" class="text-primary-900" />
              </button>

              <!-- Icon -->
              <div class="flex items-center justify-center w-[62px] h-[62px] bg-Yellow-500/30 border-[7px] border-Yellow-300 rounded-full">
                <LucidePenSquare :size="26" :stroke-width="1" class="text-Yellow-700" />
              </div>

              <!-- Title -->
              <h2 
                id="modal-new-offer-title"
                class="text-lg font-medium text-primary-500 text-center font-roboto"
              >
                Comment souhaitez-vous procéder ?
              </h2>

              <!-- Content -->
              <div class="flex flex-col items-center gap-8 w-full">
                
                <!-- Choices -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 w-full max-w-[935px]">
                  
                  <!-- Choice 1: Manual -->
                  <button
                    type="button"
                    class="choice-card"
                    :class="{ 'choice-card--selected': selectedChoice === 'manual' }"
                    @click="selectedChoice = 'manual'"
                  >
                    <h3 class="choice-card__title">Créer une annonce manuellement</h3>
                    <img 
                      src="~/assets/img/illustration-manual.png" 
                      alt=""
                      class="w-[136px] h-[146px] object-contain"
                      onerror="this.style.display='none'"
                    />
                    <p class="choice-card__description">
                      Remplissez le formulaire pour créer votre annonce.
                    </p>
                  </button>

                  <!-- Choice 2: Import file -->
                  <button
                    type="button"
                    class="choice-card"
                    :class="{ 'choice-card--selected': selectedChoice === 'import' }"
                    @click="selectedChoice = 'import'"
                  >
                    <h3 class="choice-card__title">Importez un fichier</h3>
                    <img 
                      src="~/assets/img/illustration-import.png" 
                      alt=""
                      class="w-[136px] h-[146px] object-contain"
                      onerror="this.style.display='none'"
                    />
                    <p class="choice-card__description">
                      Téléchargez le ou les fichiers contenant les informations de l'annonce.
                    </p>
                  </button>

                  <!-- Choice 3: ATS Integration -->
                  <button
                    type="button"
                    class="choice-card"
                    :class="{ 'choice-card--selected': selectedChoice === 'ats' }"
                    @click="selectedChoice = 'ats'"
                  >
                    <h3 class="choice-card__title">Utilisez une intégration d'outil (ATS)</h3>
                    <img 
                      src="~/assets/img/illustration-ats.png" 
                      alt=""
                      class="w-[175px] h-[146px] object-contain"
                      onerror="this.style.display='none'"
                    />
                    <p class="choice-card__description">
                      Connectez-vous à un outil tiers pour importer une annonce existante.
                    </p>
                  </button>

                </div>

                <!-- Button Group -->
                <div class="flex flex-col sm:flex-row items-stretch sm:items-start gap-2 w-full max-w-[935px]">
                  <AtomsButton 
                    variant="secondary" 
                    size="md" 
                    class="flex-1"
                    @click="handleClose"
                  >
                    Annuler
                  </AtomsButton>
                  <AtomsButton 
                    variant="primary" 
                    size="md" 
                    class="flex-1"
                    :disabled="!selectedChoice"
                    @click="handleContinue"
                  >
                    Continuer
                  </AtomsButton>
                </div>

              </div>
            </div>
          </div>
        </Transition>
      </div>
    </Transition>
  </Teleport>
</template>

<script setup>
import { ref, watch } from 'vue'
import { X as LucideX, PenSquare as LucidePenSquare } from 'lucide-vue-next'

const props = defineProps({
  isOpen: {
    type: Boolean,
    default: false
  }
})

const emit = defineEmits(['close', 'continue'])

// Selected choice state
const selectedChoice = ref(null)

// Reset selection when modal closes
watch(() => props.isOpen, (newVal) => {
  if (!newVal) {
    selectedChoice.value = null
  }
})

const handleClose = () => {
  emit('close')
}

const handleContinue = () => {
  if (selectedChoice.value) {
    emit('continue', selectedChoice.value)
  }
}
</script>

<style scoped>
.choice-card {
  box-sizing: border-box;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  padding: 24px 16px;
  gap: 24px;
  min-height: 343px;
  background: #FFFFFF;
  border: 1px solid #EFEEEE;
  border-radius: 8px;
  cursor: pointer;
  transition: all 0.2s ease;
}

.choice-card:hover {
  border-color: #3A3B99;
  box-shadow: 0 4px 12px rgba(58, 59, 153, 0.1);
}

.choice-card--selected {
  border-color: #3A3B99;
  border-width: 2px;
  background: rgba(58, 59, 153, 0.02);
}

.choice-card__title {
  width: 100%;
  font-family: 'Nunito', sans-serif;
  font-style: normal;
  font-weight: 700;
  font-size: 18px;
  line-height: 120%;
  text-align: center;
  color: #3A3B99;
}

.choice-card__description {
  width: 100%;
  font-family: 'Roboto', sans-serif;
  font-style: normal;
  font-weight: 400;
  font-size: 16px;
  line-height: 140%;
  text-align: left;
  color: #050D2E;
}
</style>
