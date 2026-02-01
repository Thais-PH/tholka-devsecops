<template>
  <div class="flex flex-row items-center" :class="containerClasses">
    <AtomsStep
      v-for="(step, index) in steps"
      :key="index"
      class="flex-1"
      :step-number="index + 1"
      :label="step.label || step"
      :is-active="getIsActive(step, index)"
      :is-completed="getIsCompleted(step, index)"
      :is-rejected="step.rejected || false"
      :is-first="index === 0"
      :is-last="index === steps.length - 1"
      :show-number="!mini"
      :mini="mini"
    />
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  steps: {
    type: Array,
    required: true,
  },
  currentStep: {
    type: Number,
    default: null
  },
  mini: {
    type: Boolean,
    default: false
  }
})

// Classes du container selon le mode
const containerClasses = computed(() => {
  return props.mini ? '' : 'w-full max-w-[824px] h-[60px]'
})

// Détermine si une étape est active
const getIsActive = (step, index) => {
  // Si le step a une propriété active, l'utiliser
  if (typeof step.active === 'boolean') {
    return step.active
  }
  // Si currentStep est défini, utiliser ce mode
  if (props.currentStep !== null) {
    return index === props.currentStep
  }
  // Sinon, pas d'état actif (utiliser completed/rejected des steps)
  return false
}

// Détermine si une étape est complétée
const getIsCompleted = (step, index) => {
  // Si le step a une propriété completed, l'utiliser
  if (typeof step.completed === 'boolean') {
    return step.completed
  }
  // Sinon, utiliser currentStep
  if (props.currentStep !== null) {
    return index < props.currentStep
  }
  return false
}
</script>