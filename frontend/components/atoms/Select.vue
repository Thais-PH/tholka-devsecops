<template>
  <div class="flex flex-col gap-[15px]" style="width: 400px;">
    <!-- Label -->
    <label
      v-if="label"
      :for="id"
      class="text-base font-roboto text-primary-900"
    >
      {{ label }}
    </label>

    <!-- Select Container -->
    <div class="flex flex-col gap-[10px]">
      <!-- Custom Select Field -->
      <div class="relative" ref="selectRef">
        <button
          type="button"
          :id="id"
          class="custom-select w-full h-[53px] py-[14px] pl-[16px] pr-[49px] bg-white border rounded-lg text-base font-roboto transition-colors duration-200 text-left"
          :class="getSelectClasses"
          :disabled="disabled"
          @click="toggleDropdown"
          @focus="handleFocus"
          @blur="handleBlur"
        >
          <span :class="selectedValue ? 'text-primary-900' : 'text-Grey-500'">
            {{ displayValue || placeholder }}
          </span>
        </button>

        <!-- Chevron Icon (change selon l'état ouvert/fermé) -->
        <div
          class="absolute inset-y-0 right-0 flex items-center pr-[16px] pointer-events-none"
        >
          <LucideChevronDown v-if="!isOpen" :size="17" :stroke-width="1" class="text-Grey-500" />
          <LucideChevronUp v-else :size="17" :stroke-width="1" class="text-Grey-500" />
        </div>

        <!-- Dropdown List -->
        <div
          v-if="(isOpen || forceOpen) && !disabled"
          class="absolute z-50 w-full mt-[4px] bg-white rounded-lg shadow-lg overflow-hidden border border-primary-300 p-[8px]"
        >
          <button
            v-for="option in options"
            :key="option.value"
            type="button"
            class="w-full min-h-[38px] px-[16px] py-[8px] text-[16px] leading-[22px] font-normal font-roboto text-primary-500 bg-white hover:bg-primary-300 transition-colors duration-200 text-left rounded-lg"
            @click="selectOption(option)"
          >
            {{ option.label }}
          </button>
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
import { ref, computed, onMounted, onUnmounted } from 'vue'

const props = defineProps({
  id: {
    type: String,
    default: () => `select-${Math.random().toString(36).substr(2, 9)}`
  },
  modelValue: {
    type: [String, Number],
    default: ''
  },
  label: {
    type: String,
    default: ''
  },
  placeholder: {
    type: String,
    default: 'Sélectionner une option'
  },
  hint: {
    type: String,
    default: ''
  },
  options: {
    type: Array,
    required: true,
    default: () => []
  },
  disabled: {
    type: Boolean,
    default: false
  },
  error: {
    type: Boolean,
    default: false
  },
  forceOpen: {
    type: Boolean,
    default: false
  }
})

const emit = defineEmits(['update:modelValue', 'focus', 'blur', 'change'])

const selectRef = ref(null)
const isOpen = ref(false)
const isFocused = ref(false)

const selectedValue = computed({
  get() {
    return props.modelValue
  },
  set(value) {
    emit('update:modelValue', value)
  }
})

const displayValue = computed(() => {
  const selected = props.options.find(opt => opt.value === selectedValue.value)
  return selected ? selected.label : ''
})

const getSelectClasses = computed(() => {
  const classes = []

  // États disabled
  if (props.disabled) {
    classes.push('opacity-50 cursor-not-allowed pointer-events-none')
  } else {
    classes.push('cursor-pointer')
  }

  // États de validation
  if (props.error) {
    classes.push('border-Red-500')
  } else if (props.disabled) {
    classes.push('border-primary-300 bg-Grey-300/50')
  } else {
    classes.push('border-primary-300')
  }

  // Focus states
  if (!props.disabled) {
    if (props.error) {
      classes.push('focus:border-Red-500 focus:ring-2 focus:ring-Red-500/20')
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
  return 'text-Grey-500'
})

const toggleDropdown = () => {
  if (!props.disabled && !props.forceOpen) {
    isOpen.value = !isOpen.value
  }
}

const selectOption = (option) => {
  if (!props.forceOpen) {
    selectedValue.value = option.value
    isOpen.value = false
    emit('change', option.value)
  }
}

const handleFocus = (event) => {
  isFocused.value = true
  emit('focus', event)
}

const handleBlur = (event) => {
  // Petit délai pour permettre le clic sur une option
  setTimeout(() => {
    isFocused.value = false
    emit('blur', event)
  }, 200)
}

// Fermer le dropdown si on clique à l'extérieur (sauf si forceOpen)
const handleClickOutside = (event) => {
  if (!props.forceOpen && selectRef.value && !selectRef.value.contains(event.target)) {
    isOpen.value = false
  }
}

onMounted(() => {
  document.addEventListener('click', handleClickOutside)
  // Forcer l'ouverture si forceOpen est true
  if (props.forceOpen) {
    isOpen.value = true
  }
})

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside)
})
</script>

<style scoped>
.custom-select {
  outline: none;
}

.custom-select:focus {
  outline: none;
}
</style>