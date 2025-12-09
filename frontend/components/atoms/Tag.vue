<template>
  <span 
    :class="badgeClasses"
    :style="color === 'purple' && variant === 'soft' ? { backgroundColor: 'rgba(127, 58, 218, 0.05)' } : {}"
  >
    <!-- Puce de statut colorée -->
    <span v-if="statusColor" :class="statusIndicatorClasses"></span>
    
    <!-- Icône sparkles pour purple -->
    <svg v-else-if="color === 'purple'" class="size-3.5 shrink-0" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
      <defs>
        <linearGradient id="sparklesGradient" x1="0%" y1="0%" x2="100%" y2="100%">
          <stop offset="0%" style="stop-color:#3A3B99;stop-opacity:1" />
          <stop offset="100%" style="stop-color:#7F3ADA;stop-opacity:1" />
        </linearGradient>
      </defs>
      <path d="M9.937 15.5A2 2 0 0 0 8.5 14.063l-6.135-1.582a.5.5 0 0 1 0-.962L8.5 9.936A2 2 0 0 0 9.937 8.5l1.582-6.135a.5.5 0 0 1 .962 0L14.063 8.5A2 2 0 0 0 15.5 9.937l6.135 1.582a.5.5 0 0 1 0 .962L15.5 14.063a2 2 0 0 0-1.437 1.437l-1.582 6.135a.5.5 0 0 1-.962 0L9.937 15.5Z" stroke="url(#sparklesGradient)" stroke-width="1" fill="none"/>
      <path d="M19.25 3a.25.25 0 0 1 .5 0v.5h.5a.25.25 0 0 1 0 .5h-.5v.5a.25.25 0 0 1-.5 0v-.5h-.5a.25.25 0 0 1 0-.5h.5V3ZM3 6a.25.25 0 0 1 .5 0v.5h.5a.25.25 0 0 1 0 .5h-.5v.5a.25.25 0 0 1-.5 0v-.5h-.5a.25.25 0 0 1 0-.5h.5V6Z" stroke="url(#sparklesGradient)" stroke-width="1" fill="none"/>
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

// Classes de base Preline pour les badges
const baseBadgeClasses = 'inline-flex items-center gap-x-1.5 rounded-full text-xs font-medium'

// Tailles selon Preline
const sizeClasses = {
  md: 'py-1 px-2 text-xs',
  lg: 'py-1.5 px-3 text-sm'
}

// Variantes et couleurs selon le design system
const variantColorClasses = {
  // Solid variants
  solid: {
    primary: 'bg-primary-500 text-Light',
    secondary: 'bg-secondary-500 text-Light', 
    green: 'bg-Green-500 text-Light',
    orange: 'bg-Orange-500 text-Light',
    yellow: 'bg-Yellow-500 text-Light',
    black: 'bg-Black text-Light',
    white: 'bg-Light text-Black border border-Grey-300',
    purple: 'bg-IA-500 text-Light'
  },
  // Soft variants (Classes du design system)
  soft: {
    primary: 'bg-primary-300 text-primary-500',
    secondary: 'bg-secondary-300 text-secondary-500',
    green: 'bg-Green-300 text-Green-500',
    orange: 'bg-Orange-300 text-Orange-500', 
    yellow: 'bg-Yellow-300 text-Yellow-700',
    black: 'bg-Grey-500 text-Black',
    white: 'bg-Light/15 text-Light',
    purple: 'text-primary-500'
  },
  // Stroke/Outline variants
  stroke: {
    primary: 'border border-primary-500 text-primary-500',
    secondary: 'border border-secondary-500 text-secondary-500',
    green: 'border border-Green-500 text-Green-500',
    orange: 'border border-Orange-500 text-Orange-500',
    yellow: 'border border-Yellow-500 text-Yellow-500', 
    black: 'border border-Black text-Black',
    white: 'border border-Light text-Light',
    purple: 'border border-IA-500 text-IA-500'
  }
}

// Classes pour les indicateurs de statut (Design system)
const statusIndicatorClasses = computed(() => {
  if (!props.statusColor) return ''
  
  const colorMap = {
    green: 'size-1.5 bg-Green-500 rounded-full',
    orange: 'size-1.5 bg-Orange-500 rounded-full', 
    yellow: 'size-1.5 bg-Yellow-500 rounded-full'
  }
  
  return colorMap[props.statusColor] || ''
})

// Classes finales du badge
const badgeClasses = computed(() => {
  let classes = [baseBadgeClasses, sizeClasses[props.size]]
  classes.push(variantColorClasses[props.variant][props.color])
  return classes.join(' ')
})
</script>

<!--
  Tag.vue
  - variants: solid, soft, stroke
  - colors: primary, secondary, green, orange, yellow, default
  - layout: inline-flex; padding: var(--Spacing-Spacing-4, 4px) var(--Spacing-Spacing-8, 8px); justify-content:center; align-items:center; gap: var(--Spacing-Spacing-4, 4px);
-->
