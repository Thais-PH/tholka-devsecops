<template>
  <button
    :type="type"
    :class="buttonClasses"
    :disabled="disabled"
    @click="$emit('click', $event)"
  >
    <!-- Icône gauche (en dehors du gradient pour IA) -->
    <slot v-if="variant === 'ia'" name="icon-left" />

    <span v-if="variant === 'ia'" class="inline-flex items-center gap-[4px] text-transparent bg-clip-text bg-gradient-ia">
      <!-- Texte du bouton avec gradient -->
      <slot />
    </span>
    
    <!-- Icône droite (en dehors du gradient pour IA) -->
    <slot v-if="variant === 'ia'" name="icon-right" />

    <template v-else>
      <!-- Icône gauche -->
      <slot name="icon-left" />

      <!-- Texte du bouton -->
      <slot />

      <!-- Icône droite -->
      <slot name="icon-right" />
    </template>
  </button>
</template>

<script setup>
const props = defineProps({
  variant: {
    type: String,
    default: 'primary',
    validator: (value) => ['primary', 'secondary', 'tertiary', 'menu', 'forms', 'ia', 'navbar'].includes(value)
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
  onWhite: Boolean,
  iconOnly: Boolean,
  justify: {
    type: String,
    default: 'center',
    validator: (value) => ['start', 'center', 'end', 'between'].includes(value)
  }
})

defineEmits(['click'])

const buttonClasses = computed(() => {
  // Classes de base
  const base = 'font-roboto inline-flex flex-row items-center gap-[4px] rounded-[8px] border transition-all duration-200 focus:outline-hidden disabled:opacity-50 disabled:pointer-events-none'

  // Classe justify selon la prop
  const justifyClasses = {
    start: 'justify-start',
    center: 'justify-center',
    end: 'justify-end',
    between: 'justify-between'
  }

  // Tailles pour boutons avec texte - enlever tout padding horizontal si justify=start
  const paddingX = props.justify === 'start' ? 'px-0' : 'px-[8px]'
  const paddingXMd = props.justify === 'start' ? 'px-0' : 'px-[16px]'
  const paddingXLg = props.justify === 'start' ? 'px-0' : 'px-[24px]'

  const minWidth = props.justify === 'start' ? '' : 'min-w-[100px]'
  const minWidthMd = props.justify === 'start' ? '' : 'min-w-[128px]'
  const minWidthLg = props.justify === 'start' ? '' : 'min-w-[164px]'

  const sizes = {
    // Small: 100px min (sauf si justify=start)
    sm: `${minWidth} h-[26px] ${paddingX} py-[4px] text-[14px] leading-[18px] font-normal`,

    // Medium: 128px min (sauf si justify=start)
    md: `${minWidthMd} h-[38px] ${paddingXMd} py-[8px] text-[16px] leading-[22px] font-normal`,

    // Large: 164px min (sauf si justify=start)
    lg: `${minWidthLg} h-[56px] ${paddingXLg} py-[12px] text-[20px] leading-[32px] font-medium`
  }

  // Tailles pour boutons icon-only (carrés)
  const iconSizes = {
    sm: 'w-[26px] h-[26px] p-[4px]',
    md: 'w-[38px] h-[38px] p-[8px]',
    lg: 'w-[56px] h-[56px] p-[12px]'
  }

  // Variantes de couleurs
  const variants = {
    primary: props.onWhite 
      ? 'border-transparent bg-Light text-primary-500 hover:border-Light hover:bg-transparent hover:text-Light'
      : 'border-transparent bg-primary-500 text-Light hover:bg-primary-700 focus:bg-primary-700',

    secondary: props.onWhite
      ? 'border-[2px] border-Light text-Light hover:bg-Light hover:text-primary-500'
      : 'border-[2px] border-primary-500 text-primary-500 hover:border-primary-700 hover:text-primary-700',

    tertiary: props.onWhite
      ? 'border-transparent text-Light hover:border-b-[1px] hover:border-b-Light hover:rounded-none'
      : 'border-transparent text-primary-500 hover:border-b-[1px] hover:border-b-primary-500 hover:rounded-none',

    navbar: 'border-transparent text-primary-500 hover:border-b-[1px] hover:border-b-primary-500 hover:rounded-none',

    menu: 'border-transparent bg-transparent text-Light hover:bg-white/15',

    forms: 'border-transparent bg-transparent text-primary-500 hover:bg-primary-300',

    ia: 'border-transparent bg-transparent relative hover:rounded-none hover-border-gradient-ia text-Light'
  }

  const sizeClass = props.iconOnly ? iconSizes[props.size] : sizes[props.size]

  return [base, justifyClasses[props.justify], sizeClass, variants[props.variant]]
})
</script>