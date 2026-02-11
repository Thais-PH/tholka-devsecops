<template>
  <div
    :class="alertClasses"
    role="alert"
    tabindex="-1"
  >
    <!-- Contenu principal -->
    <div class="flex flex-col lg:flex-row items-center gap-3 lg:gap-[32px] flex-1 justify-center">
      <!-- Message et Icône -->
      <div class="flex items-center gap-[8px]">
        <!-- Message -->
        <span :class="textClasses">
          <slot>{{ message }}</slot>
        </span>
        
        <!-- Icône (Sparkles pour IA, AlertCircle pour les autres) -->
        <LucideSparkles v-if="variant.startsWith('ia')" :size="20" :stroke-width="1" :class="iconColor" class="shrink-0" />
        <LucideAlertCircle v-else :size="20" :stroke-width="1" :class="iconColor" class="shrink-0" />
      </div>

      <!-- Slot action personnalisé OU bouton "Lu" par défaut -->
      <template v-if="!isDismissed && dismissible">
        <!-- Slot pour action personnalisée -->
        <slot name="action">
          <!-- Bouton "Lu" pour variantes IA (style custom) -->
          <button
            v-if="variant.startsWith('ia')"
            type="button"
            class="ia-dismiss-btn shrink-0"
            @click="handleDismiss"
          >
            <span>Lu</span>
            <LucideCheck :size="17" :stroke-width="1" />
          </button>

          <!-- Bouton "Lu" pour autres variantes -->
          <AtomsButton
            v-else
            variant="secondary"
            size="sm"
            @click="handleDismiss"
          >
            Lu
            <template #icon-right>
              <LucideCheck :size="17" :stroke-width="1" />
            </template>
          </AtomsButton>
        </slot>
      </template>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  variant: {
    type: String,
    default: 'info',
    validator: (value) => ['warning-soft', 'warning-solid', 'info', 'success-soft', 'success-solid', 'ia-solid', 'ia-soft'].includes(value)
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
  const base = 'flex flex-row items-center p-[12px] h-auto lg:h-[50px] rounded-lg transition-all duration-300 font-roboto w-full'
  
  const variants = {
    'warning-soft': 'bg-Orange-300 border-l-2 border-Orange-500',
    'warning-solid': 'bg-Orange-500',
    'info': 'bg-secondary-500',
    'success-soft': 'bg-Green-300 border-l-2 border-Green-500',
    'success-solid': 'bg-Green-500',
    'ia-solid': 'bg-gradient-to-br from-[#3A3B99] to-[#7F3ADA]',
    'ia-soft': 'bg-[rgba(127,58,218,0.05)] border-l-2 border-[#7F3ADA]'
  }

  return [base, variants[props.variant]]
})

const textClasses = computed(() => {
  const base = 'text-base font-roboto'
  
  if (props.variant === 'warning-soft') {
    return `${base} text-Orange-500`
  } else if (props.variant === 'success-soft') {
    return `${base} text-Green-500`
  } else if (props.variant === 'ia-soft') {
    return `${base} text-[#6420BE]`
  } else if (props.variant === 'ia-solid') {
    return `${base} text-Light`
  }
  return `${base} text-Light`
})

const iconColor = computed(() => {
  if (props.variant === 'warning-soft') {
    return 'text-Orange-500'
  } else if (props.variant === 'success-soft') {
    return 'text-Green-500'
  } else if (props.variant === 'ia-soft') {
    return 'text-[#6420BE]'
  } else if (props.variant === 'ia-solid') {
    return 'text-Light'
  }
  return 'text-Light'
})

// Import des icônes
import { AlertCircle as LucideAlertCircle, Sparkles as LucideSparkles, Check as LucideCheck } from 'lucide-vue-next'
</script>

<style scoped>
/* Bouton custom pour alerte IA */
.ia-dismiss-btn {
  box-sizing: border-box;
  display: flex;
  flex-direction: row;
  justify-content: center;
  align-items: center;
  padding: 4px 8px;
  gap: 4px;
  min-width: 54px;
  height: 26px;
  border: 1px solid #6420BE;
  border-radius: 8px;
  background: transparent;
  font-family: 'Roboto', sans-serif;
  font-style: normal;
  font-weight: 400;
  font-size: 14px;
  line-height: 130%;
  text-align: center;
  color: #6420BE;
  cursor: pointer;
  transition: all 0.2s ease;
}

.ia-dismiss-btn:hover {
  background: #FFFFFF;
  color: #6420BE;
  border-color: #FFFFFF;
}

.ia-dismiss-btn:hover svg {
  stroke: #6420BE;
}
</style>