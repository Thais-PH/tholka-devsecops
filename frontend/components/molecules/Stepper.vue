<template>
  <div class="flex flex-row items-center w-full max-w-[824px] h-[60px]">
    <AtomsStep
      v-for="(step, index) in steps"
      :key="index"
      :step-number="index + 1"
      :label="step.label || step"
      :is-active="index === currentStep"
      :is-first="index === 0"
      :is-last="index === steps.length - 1"
    />
  </div>
</template>

<script setup>
const props = defineProps({
  steps: {
    type: Array,
    required: true,
  },
  currentStep: {
    type: Number
  }
})
</script>