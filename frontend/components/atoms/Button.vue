<template>
  <button
    :type="type"
    :class="buttonClasses"
    :disabled="disabled"
    @click="$emit('click', $event)"
  >
    <!-- Icône gauche -->
    <slot name="icon-left" />
    
    <!-- Texte du bouton -->
    <slot />
    
    <!-- Icône droite -->
    <slot name="icon-right" />
  </button>
</template>

<script setup>
const props = defineProps({
  variant: {
    type: String,
    default: 'primary',
    validator: (value) => ['primary', 'secondary', 'tertiary', 'menu', 'forms', 'ia'].includes(value)
  },
  size: {
    type: String,
    default: 'md',
    validator: (value) => ['sm', 'md', 'lg'].includes(value)
  },
  type: {
    type: String,
    default: 'button'
  },
  disabled: Boolean,
  onWhite: Boolean
})

defineEmits(['click'])

const buttonClasses = computed(() => {
  // Classes de base
  const base = 'inline-flex flex-row justify-center items-center gap-[4px] rounded-[8px] border transition-colors focus:outline-hidden disabled:opacity-50 disabled:pointer-events-none'
  
  // Tailles avec padding + largeur minimale + typo
  const sizes = {
    // Small: 100px min, padding 4px/8px, Roboto 14px/18px
    sm: 'min-w-[100px] h-[26px] px-[8px] py-[4px] text-[14px] leading-[18px] text-normal',

    // Medium: 128px min, padding 8px/16px, Roboto 16px/22px
    md: 'min-w-[128px] h-[38px] px-[16px] py-[8px] text-[16px] leading-[22px] text-normal',

    // Large: 164px min, padding 12px/24px, Roboto Medium 20px/32px
    lg: 'min-w-[164px] h-[56px] px-[24px] py-[12px] text-[20px] leading-[32px] text-medium'
  }
  
  // Variantes de couleurs
  const variants = {
    primary: props.onWhite 
      ? 'border-transparent bg-Light text-primary-500 hover:bg-Grey-300'
      : 'border-transparent bg-primary-500 text-Light hover:bg-primary-700 focus:bg-primary-700',
    
    secondary: props.onWhite
      ? 'border-[2px] border-Light text-Light hover:bg-Light hover:text-primary-500'
      : 'border-[2px] border-Grey-500 text-Grey-500 hover:border-primary-500 hover:text-primary-500',
    
    tertiary: props.onWhite
      ? 'border-transparent text-Light hover:text-Grey-300'
      : 'border-transparent text-primary-500 hover:text-primary-700',
    
    menu: props.onWhite
      ? 'border-transparent bg-Light text-primary-500 hover:bg-Grey-300'
      : 'border-transparent bg-Grey-300 text-primary-900 hover:bg-Grey-500',
    
    forms: props.onWhite
      ? 'border-[2px] border-Grey-300 bg-Light text-primary-500 hover:border-primary-500'
      : 'border-[2px] border-Grey-300 bg-Light text-primary-900 hover:border-primary-500',
    
    ia: 'border-transparent bg-secondary-300 text-secondary-700 hover:bg-secondary-500 hover:text-Light'
  }
  
  return [base, sizes[props.size], variants[props.variant]]
})
</script>