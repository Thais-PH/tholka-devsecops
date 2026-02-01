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
        aria-labelledby="modal-compatibility-title"
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
            class="relative w-full max-w-[649px] bg-Light rounded-lg shadow-xl"
          >
            <!-- Modal Content -->
            <div class="flex flex-col items-center p-10 gap-6">
              
              <!-- Close Button -->
              <button
                type="button"
                class="absolute top-2.5 right-2.5 w-[38px] h-[38px] flex items-center justify-center rounded-lg hover:bg-Grey-300 transition-colors"
                aria-label="Fermer"
                @click="handleClose"
              >
                <LucideX :size="16" :stroke-width="1.5" class="text-primary-900" />
              </button>

              <!-- Icon -->
              <div class="flex items-center justify-center w-[62px] h-[62px] bg-Yellow-500/30 border-[7px] border-Yellow-300 rounded-full">
                <LucideLightbulb :size="26" :stroke-width="1.5" class="text-Yellow-700" />
              </div>

              <!-- Content -->
              <div class="flex flex-col items-start gap-2.5 w-full">
                <!-- Title -->
                <h3 
                  id="modal-compatibility-title"
                  class="w-full font-roboto font-medium text-lg text-primary-500 text-center"
                >
                  Compatibilité du profil
                </h3>

                <!-- Description -->
                <p class="w-full font-roboto font-normal text-base text-primary-900 leading-[140%]">
                  Cet indicateur mesure l'<span class="font-bold">adéquation entre le profil du candidat et le poste à pourvoir</span>.<br />
                  Il combine l'analyse du CV (compétences, expérience) et les résultats du test DISC afin d'évaluer la cohérence globale avec les attentes du poste.
                </p>
                <p class="w-full font-roboto font-normal text-base text-primary-900 leading-[140%]">
                  Attention : si le candidat n'a pas passé le test DISC, cet indicateur apparaîtra comme vide.
                </p>
              </div>
            </div>
          </div>
        </Transition>
      </div>
    </Transition>
  </Teleport>
</template>

<script setup>
import { X as LucideX, Lightbulb as LucideLightbulb } from 'lucide-vue-next'

defineProps({
  isOpen: {
    type: Boolean,
    default: false
  }
})

const emit = defineEmits(['close'])

const handleClose = () => {
  emit('close')
}
</script>
