<template>
  <span 
  :class="tagClasses" 
  :style="tagStyle"
  >
    <!-- Puce de statut colorée -->
    <span v-if="statusColor" :class="`w-[5px] h-[5px] rounded-full flex-shrink-0 ${statusColorClass}`"></span>
    <!-- Icône sparkles pour purple -->
    <svg v-else-if="color === 'purple'" class="w-[15px] h-[15px] flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="url(#sparklesGradient)" stroke-width="1" xmlns="http://www.w3.org/2000/svg">
      <defs>
        <linearGradient id="sparklesGradient" x1="0%" y1="0%" x2="100%" y2="100%">
          <stop offset="0%" style="stop-color:#3A3B99;stop-opacity:1" />
          <stop offset="100%" style="stop-color:#7F3ADA;stop-opacity:1" />
        </linearGradient>
      </defs>
      <path d="M9.937 15.5A2 2 0 0 0 8.5 14.063l-6.135-1.582a.5.5 0 0 1 0-.962L8.5 9.936A2 2 0 0 0 9.937 8.5l1.582-6.135a.5.5 0 0 1 .962 0L14.063 8.5A2 2 0 0 0 15.5 9.937l6.135 1.582a.5.5 0 0 1 0 .962L15.5 14.063a2 2 0 0 0-1.437 1.437l-1.582 6.135a.5.5 0 0 1-.962 0L9.937 15.5Z"/>
      <path d="M19.25 3a.25.25 0 0 1 .5 0v.5h.5a.25.25 0 0 1 0 .5h-.5v.5a.25.25 0 0 1-.5 0v-.5h-.5a.25.25 0 0 1 0-.5h.5V3ZM3 6a.25.25 0 0 1 .5 0v.5h.5a.25.25 0 0 1 0 .5h-.5v.5a.25.25 0 0 1-.5 0v-.5h-.5a.25.25 0 0 1 0-.5h.5V6Z"/>
    </svg>
    <slot />
  </span>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  variant: {
    type: String,
    default: 'solid',
    validator: (v) => ['solid', 'soft', 'stroke'].includes(v)
  },
  color: {
    type: String,
    default: 'black',
    validator: (v) => ['primary', 'secondary', 'green', 'orange', 'yellow', 'black', 'white', 'purple'].includes(v)
  },
  size: {
    type: String,
    default: 'md',
    validator: (v) => ['md', 'lg'].includes(v)
  },
  statusColor: {
    type: String,
    default: null,
    validator: (v) => v === null || ['green', 'orange', 'yellow'].includes(v)
  }
})

// Styles selon la taille (inline styles to keep spacing consistent with design tokens)
const tagStyles = {
  md: 'padding: var(--Spacing-Spacing-4, 4px) var(--Spacing-Spacing-8, 8px); display: inline-flex; justify-content: center; align-items: center; gap: var(--Spacing-Spacing-4, 4px); white-space: nowrap; border-radius: var(--Radius-radius-20, 20px);',
  lg: 'padding: var(--Spacing-Spacing-8, 8px); display: inline-flex; justify-content: center; align-items: center; gap: var(--Spacing-Spacing-4, 4px); white-space: nowrap; border-radius: var(--Radius-radius-20, 20px);'
}

const tagStyle = computed(() => {
  let baseStyle = tagStyles[props.size]
  
  // Ajouter le background color pour purple soft
  if (props.color === 'purple' && props.variant === 'soft') {
    baseStyle += ' background-color: rgba(127, 58, 218, 0.05);'
  }
  
  return baseStyle
})

const statusColorClass = computed(() => {
  const statusColorMap = {
    green: 'bg-Green-500',
    orange: 'bg-Orange-500', 
    yellow: 'bg-Yellow-500'
  }
  return statusColorMap[props.statusColor] || ''
})

const tagClasses = computed(() => {
  const baseStyles = {
    md: 'inline-flex justify-center items-center gap-[4px] rounded-[9999px] font-roboto text-[12px] leading-[140%] font-normal whitespace-nowrap text-center',
    lg: 'inline-flex justify-center items-center gap-[4px] rounded-[9999px] font-roboto text-[12px] leading-[140%] font-normal whitespace-nowrap text-center'
  }
  const base = baseStyles[props.size]

  // Pour purple soft, on retourne seulement les classes de base car le background sera en style inline
  if (props.color === 'purple' && props.variant === 'soft') {
    return `${base} text-[#3A3B99]`
  }

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
    black: {
      solid: 'bg-Black text-Light',
      soft: 'bg-Grey-500 text-Black',
      stroke: 'border border-Black text-Black bg-transparent'
    },
    white: {
      solid: 'bg-Light text-Black',
      soft: 'bg-Light/15 text-Light',
      stroke: 'border border-Light text-Light bg-transparent'
    },
    purple: {
      solid: '',
      soft: 'text-[#3A3B99]',
      stroke: ''
    }
  }

  const choice = (colorMap[props.color] && colorMap[props.color][props.variant]) ? colorMap[props.color][props.variant] : colorMap.black[props.variant]

  return [base, choice].join(' ')
})
</script>

<!--
  Tag.vue
  - variants: solid, soft, stroke
  - colors: primary, secondary, green, orange, yellow, default
  - layout: inline-flex; padding: var(--Spacing-Spacing-4, 4px) var(--Spacing-Spacing-8, 8px); justify-content:center; align-items:center; gap: var(--Spacing-Spacing-4, 4px);
-->
