<template>
  <div class="flex flex-col gap-[15px]" style="width: 400px;">
    <!-- Label (si fourni) -->
    <label
      v-if="label"
      :for="id"
      class="text-base font-roboto text-primary-900"
    >
      {{ label }}
    </label>

    <!-- Input Container -->
    <div class="flex flex-col gap-[10px]">
      <!-- Input Field -->
      <div class="relative">
        <input
          :id="id"
          v-model="inputValue"
          :type="type"
          :placeholder="placeholder"
          :disabled="disabled"
          :readonly="readonly"
          class="custom-input w-full h-[53px] py-[14px] bg-white border rounded-lg text-base font-roboto transition-colors duration-200"
          :class="[getInputClasses, (iconRight || iconBottom) ? 'pl-[16px] pr-[49px]' : 'px-[16px]']"
          @focus="handleFocus"
          @blur="handleBlur"
          @input="handleInput"
        />

        <!-- Icon Right (Chevron Left) -->
        <div
          v-if="iconRight"
          class="absolute inset-y-0 right-0 flex items-center pr-[16px] pointer-events-none"
        >
          <LucideChevronLeft :size="17" :stroke-width="1" class="text-Grey-500" />
        </div>

        <!-- Icon Bottom (Chevron Down) -->
        <div
          v-if="iconBottom"
          class="absolute inset-y-0 right-0 flex items-center pr-[16px] pointer-events-none"
        >
          <LucideChevronDown :size="17" :stroke-width="1" class="text-Grey-500" />
        </div>

        <!-- Error Icon -->
        <div
          v-if="error && !iconRight && !iconBottom"
          class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none"
        >
          <LucideInfo :size="17" :stroke-width="1" class="text-Red-500" />
        </div>

        <!-- Success Icon -->
        <div
          v-if="success && !iconRight && !iconBottom && !error"
          class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none"
        >
          <svg class="w-4 h-4 text-Green-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="20 6 9 17 4 12"></polyline>
          </svg>
        </div>
      </div>

      <!-- Hint Text -->
      <p
        v-if="hint"
        class="text-sm font-roboto"
        :class="getHintClasses"
      >
        {{ hint }}
      </p>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const props = defineProps({
  id: {
    type: String,
    default: () => `input-${Math.random().toString(36).substr(2, 9)}`
  },
  modelValue: {
    type: [String, Number],
    default: ''
  },
  type: {
    type: String,
    default: 'text'
  },
  label: {
    type: String,
    default: ''
  },
  placeholder: {
    type: String,
    default: ''
  },
  hint: {
    type: String,
    default: ''
  },
  disabled: {
    type: Boolean,
    default: false
  },
  readonly: {
    type: Boolean,
    default: false
  },
  error: {
    type: Boolean,
    default: false
  },
  success: {
    type: Boolean,
    default: false
  },
  iconRight: {
    type: Boolean,
    default: false
  },
  iconBottom: {
    type: Boolean,
    default: false
  }
})

const emit = defineEmits(['update:modelValue', 'focus', 'blur', 'input'])

const isFocused = ref(false)

const inputValue = computed({
  get() {
    return props.modelValue
  },
  set(value) {
    emit('update:modelValue', value)
  }
})

const getInputClasses = computed(() => {
  const classes = []

  // États disabled/readonly
  if (props.disabled || props.readonly) {
    classes.push('opacity-50 cursor-not-allowed pointer-events-none')
  } else {
    classes.push('cursor-text')
  }

  // États de validation
  if (props.error) {
    classes.push('border-Red-500 text-primary-900')
  } else if (props.success) {
    classes.push('border-Green-500 text-primary-900')
  } else if (props.disabled) {
    classes.push('border-primary-300 bg-Grey-300/50')
  } else {
    classes.push('border-primary-300 text-primary-900')
  }

  // Focus states
  if (!props.disabled && !props.readonly) {
    if (props.error) {
      classes.push('focus:border-Red-500 focus:ring-2 focus:ring-Red-500/20')
    } else if (props.success) {
      classes.push('focus:border-Green-500 focus:ring-2 focus:ring-Green-500/20')
    } else {
      classes.push('focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20')
    }
  }

  return classes.join(' ')
})

const getHintClasses = computed(() => {
  if (props.error) {
    return 'text-Red-500'
  }
  if (props.success) {
    return 'text-Green-500'
  }
  return 'text-Grey-500'
})

const handleFocus = (event) => {
  isFocused.value = true
  emit('focus', event)
}

const handleBlur = (event) => {
  isFocused.value = false
  emit('blur', event)
}

const handleInput = (event) => {
  emit('input', event.target.value)
}
</script>

<style scoped>
.custom-input {
  outline: none;
}

.custom-input::placeholder {
  color: #AEACAC; /* Grey-500 */
  font-family: 'Roboto', sans-serif;
  font-weight: 400;
}

/* Supprime l'outline par défaut du navigateur */
.custom-input:focus {
  outline: none;
}

/* Style pour le texte disabled */
.custom-input:disabled {
  color: #AEACAC;
}

.custom-input:disabled::placeholder {
  color: #AEACAC;
  opacity: 0.5;
}
</style>