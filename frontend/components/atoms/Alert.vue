<template>
  <div
    :class="alertClasses"
    role="alert"
    tabindex="-1"
  >
    <!-- Contenu principal -->
    <div class="flex items-center gap-[32px] flex-1 justify-center">
      <!-- Message et Icône -->
      <div class="flex items-center gap-[8px]">
        <!-- Message -->
        <span :class="textClasses">
          <slot>{{ message }}</slot>
        </span>
        
        <!-- Icône -->
        <LucideAlertCircle :size="20" :stroke-width="1" :class="iconColor" />
      </div>

      <!-- Bouton "Lu" (disparaît au clic) -->
      <button
        v-if="!isDismissed"
        type="button"
        :class="buttonClasses"
        @click="handleDismiss"
      >
        <span class="text-sm font-normal text-center">Lu</span>
        <LucideCheck :size="17" :stroke-width="1" />
      </button>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  variant: {
    type: String,
    default: 'info',
    validator: (value) => ['warning-soft', 'warning-solid', 'info', 'success-soft', 'success-solid'].includes(value)
  },
  message: {
    type: String,
    default: ''
  },
  dismissible: {
    type: Boolean,
    default: true
  }
})

const emit = defineEmits(['dismiss'])

const isDismissed = ref(false)

const handleDismiss = () => {
  isDismissed.value = true
  emit('dismiss')
}

const alertClasses = computed(() => {
  const base = 'flex flex-row items-center p-[12px] h-[50px] rounded-lg transition-all duration-300 font-roboto'
  
  const variants = {
    'warning-soft': 'bg-Orange-300 border-l-2 border-Orange-500',
    'warning-solid': 'bg-Orange-500',
    'info': 'bg-secondary-500',
    'success-soft': 'bg-Green-300 border-l-2 border-Green-500',
    'success-solid': 'bg-Green-500'
  }

  return [base, variants[props.variant]]
})

const textClasses = computed(() => {
  const base = 'text-base font-normal'
  
  if (props.variant === 'warning-soft') {
    return `${base} text-Orange-500`
  } else if (props.variant === 'success-soft') {
    return `${base} text-Green-500`
  }
  return `${base} text-white`
})

const iconColor = computed(() => {
  if (props.variant === 'warning-soft') {
    return 'text-Orange-500'
  } else if (props.variant === 'success-soft') {
    return 'text-Green-500'
  }
  return 'text-white'
})

const buttonClasses = computed(() => {
  const base = 'flex flex-row justify-center items-center px-2 py-1 gap-1 h-[26px] border rounded-lg transition-all'
  const isSoft = props.variant.includes('soft')
  
  if (props.variant.startsWith('warning')) {
    return isSoft 
      ? `${base} border-Orange-500 text-Orange-500 hover:bg-Orange-500 hover:text-white`
      : `${base} border-white text-white hover:bg-white hover:text-Orange-500`
  } else if (props.variant.startsWith('success')) {
    return isSoft
      ? `${base} border-Green-500 text-Green-500 hover:bg-Green-500 hover:text-white`
      : `${base} border-white text-white hover:bg-white hover:text-Green-500`
  }
  return `${base} border-white text-white hover:bg-white hover:text-secondary-500`
})
</script>