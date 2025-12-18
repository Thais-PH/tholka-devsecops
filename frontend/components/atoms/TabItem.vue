<template>
  <button
    type="button"
    :class="itemClasses"
    @click="$emit('click')"
    @mouseenter="isHovered = true"
    @mouseleave="isHovered = false"
  >
    <span :class="textClasses">{{ label }}</span>
  </button>
</template>

<script setup>
import { ref, computed } from 'vue'

const props = defineProps({
  label: {
    type: String,
    required: true
  },
  variant: {
    type: String,
    default: 'default',
    validator: (value) => ['default', 'active'].includes(value)
  }
})

defineEmits(['click'])

const isHovered = ref(false)

const itemClasses = computed(() => {
  const baseClasses = [
    'flex flex-row items-center justify-center',
    'px-4 py-2',
    'h-[38px]',
    'min-w-fit',
    'transition-all duration-300 ease-in-out',
    'focus:outline-none',
    'focus:ring-0',
    'outline-none',
    'rounded-full',
    'whitespace-nowrap'
  ]

  if (props.variant === 'active') {
    return [
      ...baseClasses,
      'bg-primary-500'
    ]
  } else {
    return [
      ...baseClasses,
      'bg-white'
    ]
  }
})

const textClasses = computed(() => {
  const baseClasses = [
    'font-roboto font-normal text-base leading-[140%]',
    'transition-colors duration-300 ease-in-out'
  ]

  if (props.variant === 'active') {
    return [
      ...baseClasses,
      'text-white'
    ]
  } else if (isHovered.value && props.variant === 'default') {
    return [
      ...baseClasses,
      'text-primary-500'
    ]
  } else {
    return [
      ...baseClasses,
      'text-primary-500/50'
    ]
  }
})
</script>