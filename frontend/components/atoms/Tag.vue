<template>
  <span 
  :class="tagClasses" 
  :style="tagStyle"
  >
    <!-- Puce verte 5px×5px -->
    <span class="w-[5px] h-[5px] bg-Green-500 rounded-full flex-shrink-0"></span>
    <slot />
  </span>
</template>

<script setup>
const props = defineProps({
  variant: {
    type: String,
    default: 'solid',
    validator: (v) => ['solid', 'soft', 'stroke'].includes(v)
  },
  color: {
    type: String,
    default: 'default',
    validator: (v) => ['primary', 'secondary', 'green', 'orange', 'yellow', 'default'].includes(v)
  },
  size: {
    type: String,
    default: 'md',
    validator: (v) => ['md', 'lg'].includes(v)
  }
})

// Styles selon la taille (inline styles to keep spacing consistent with design tokens)
const tagStyles = {
  md: 'padding: var(--Spacing-Spacing-4, 4px) var(--Spacing-Spacing-8, 8px); display: inline-flex; justify-content: center; align-items: center; gap: var(--Spacing-Spacing-4, 4px); white-space: nowrap; border-radius: var(--Radius-radius-20, 20px);',
  lg: 'padding: var(--Spacing-Spacing-8, 8px); display: inline-flex; justify-content: center; align-items: center; gap: var(--Spacing-Spacing-4, 4px); white-space: nowrap; border-radius: var(--Radius-radius-20, 20px);'
}

const tagStyle = computed(() => tagStyles[props.size])

import { computed } from 'vue'

const tagClasses = computed(() => {
  const baseStyles = {
    md: 'inline-flex justify-center items-center gap-[4px] rounded-[9999px] font-roboto text-[12px] leading-[140%] font-normal whitespace-nowrap text-center',
    lg: 'inline-flex justify-center items-center gap-[4px] rounded-[9999px] font-roboto text-[12px] leading-[140%] font-normal whitespace-nowrap text-center'
  }
  const base = baseStyles[props.size]

  const colorMap = {
    primary: {
      solid: 'bg-primary-500 text-Light',
      soft: 'bg-primary-300 text-primary-500',
      stroke: 'border border-primary-500 text-primary-500 bg-transparent'
    },
    secondary: {
      solid: 'bg-secondary-500 text-Light',
      soft: 'bg-secondary-300 text-secondary-500',
      stroke: 'border border-secondary-500 text-secondary-500 bg-transparent'
    },
    green: {
      solid: 'bg-Green-500 text-Light',
      soft: 'bg-Green-300 text-Green-500',
      stroke: 'border border-Green-500 text-Green-500 bg-transparent'
    },
    orange: {
      solid: 'bg-Orange-500 text-Light',
      soft: 'bg-Orange-300 text-Orange-500',
      stroke: 'border border-Orange-500 text-Orange-500 bg-transparent'
    },
    yellow: {
      solid: 'bg-Yellow-500 text-Light',
      soft: 'bg-Yellow-300 text-Yellow-500',
      stroke: 'border border-Yellow-500 text-Yellow-500 bg-transparent'
    },
    default: {
      solid: 'bg-Black text-Light',
      soft: 'bg-Grey-300 text-Black',
      stroke: 'border border-Black text-Black bg-transparent'
    }
  }

  const choice = (colorMap[props.color] && colorMap[props.color][props.variant]) ? colorMap[props.color][props.variant] : colorMap.default[props.variant]

  return [base, choice].join(' ')
})
</script>

<!--
  Tag.vue
  - variants: solid, soft, stroke
  - colors: primary, secondary, green, orange, yellow, default
  - layout: inline-flex; padding: var(--Spacing-Spacing-4, 4px) var(--Spacing-Spacing-8, 8px); justify-content:center; align-items:center; gap: var(--Spacing-Spacing-4, 4px);
-->
