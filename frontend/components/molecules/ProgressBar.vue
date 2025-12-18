<template>
  <div class="w-full">
    <div class="flex items-center justify-between mb-2">
      <span v-if="label" class="text-sm font-medium text-primary-900">{{ label }}</span>
      <span class="text-sm font-medium text-primary-900">{{ percentage }}%</span>
    </div>
    <div class="w-full h-2 bg-grey-200 rounded-full overflow-hidden">
      <div
        class="h-full rounded-full transition-all duration-300"
        :style="{
          width: `${percentage}%`,
          backgroundColor: color
        }"
      />
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  percentage: {
    type: Number,
    required: true,
    default: 0,
    validator: (value) => value >= 0 && value <= 100
  },
  label: {
    type: String,
    default: ''
  },
  color: {
    type: String,
    default: '#3A3B99'
  }
})
</script>
