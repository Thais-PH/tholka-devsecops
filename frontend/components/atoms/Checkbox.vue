<template>
  <div class="flex items-start gap-[16px]">
    <!-- Checkbox -->
    <div class="flex items-start pt-1">
      <input
        :id="id"
        v-model="checked"
        type="checkbox"
        :value="value"
        :disabled="disabled"
        class="custom-checkbox w-[16px] h-[16px] bg-white border border-primary-300 rounded-[4px] cursor-pointer transition-colors duration-200"
        :class="{ 'error-checkbox': error }"
        @change="handleChange"
      />
    </div>

    <!-- Content -->
    <div v-if="label || hint" class="flex-1">
      <label
        v-if="label"
        :for="id"
        class="text-base font-roboto cursor-pointer transition-colors duration-200"
        :class="getTextClasses"
      >
        {{ label }}
      </label>

      <p
        v-if="hint"
        class="text-sm font-roboto mt-0.5"
        :class="getHintClasses"
      >
        {{ hint }}
      </p>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  id: {
    type: String,
    default: () => `checkbox-${Math.random().toString(36).substr(2, 9)}`
  },
  modelValue: {
    type: [Boolean, Array],
    default: false
  },
  value: {
    type: [String, Number, Boolean],
    default: null
  },
  label: {
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
  error: {
    type: Boolean,
    default: false
  }
})

const emit = defineEmits(['update:modelValue', 'change'])

const checked = computed({
  get() {
    if (Array.isArray(props.modelValue)) {
      return props.modelValue.includes(props.value)
    }
    return props.modelValue
  },
  set(newValue) {
    if (Array.isArray(props.modelValue)) {
      const updatedValue = [...props.modelValue]
      if (newValue) {
        if (!updatedValue.includes(props.value)) {
          updatedValue.push(props.value)
        }
      } else {
        const index = updatedValue.indexOf(props.value)
        if (index > -1) {
          updatedValue.splice(index, 1)
        }
      }
      emit('update:modelValue', updatedValue)
    } else {
      emit('update:modelValue', newValue)
    }
  }
})

const getTextClasses = computed(() => {
  if (props.disabled) {
    return 'text-primary-700/50 cursor-not-allowed'
  }
  if (props.error) {
    return 'text-Red-500'
  }
  return 'text-primary-900 hover:text-primary-700'
})

const getHintClasses = computed(() => {
  if (props.disabled) {
    return 'text-Grey-500/50'
  }
  if (props.error) {
    return 'text-Red-500'
  }
  return 'text-Grey-500'
})

const handleChange = (event) => {
  emit('change', {
    checked: event.target.checked,
    value: props.value
  })
}
</script>

<style scoped>
.custom-checkbox {
  --tw-ring-color: #3A3B99 !important;
}

.custom-checkbox:focus {
  outline: none !important;
  box-shadow: 0 0 0 2px #3A3B99 !important;
  border-color: #3A3B99 !important;
}

.custom-checkbox:checked {
  background-color: #3A3B99 !important;
  border-color: #3A3B99 !important;
}

.custom-checkbox:checked:focus {
  background-color: #3A3B99 !important;
  border-color: #3A3B99 !important;
  box-shadow: 0 0 0 2px #3A3B99 !important;
}

/* États hover */
.custom-checkbox:hover:not(:disabled) {
  border-color: #5A5BB0 !important;
}

.custom-checkbox:checked:hover:not(:disabled) {
  background-color: #5A5BB0 !important;
  border-color: #5A5BB0 !important;
}

/* États error */
.custom-checkbox.error-checkbox {
  border-color: #EB5035 !important;
  background-color: #FFFFFF !important;
}

.custom-checkbox.error-checkbox:focus {
  outline: none !important;
  box-shadow: 0 0 0 2px #EB5035 !important;
  border-color: #EB5035 !important;
}

.custom-checkbox.error-checkbox:checked {
  background-color: #EB5035 !important;
  border-color: #EB5035 !important;
}

.custom-checkbox.error-checkbox:checked:focus {
  background-color: #EB5035 !important;
  border-color: #EB5035 !important;
  box-shadow: 0 0 0 2px #EB5035 !important;
}

.custom-checkbox.error-checkbox:hover:not(:disabled) {
  border-color: #EB5035 !important;
}

.custom-checkbox.error-checkbox:checked:hover:not(:disabled) {
  background-color: #EB5035 !important;
  border-color: #EB5035 !important;
}

/* États disabled */
.custom-checkbox:disabled {
  cursor: not-allowed !important;
  --tw-ring-color: #3A3B9950 !important;
  border: none !important;
}

.custom-checkbox:disabled {
  background-color: #FFFFFF50 !important;
}

.custom-checkbox:disabled:checked {
  background-color: #3A3B9950 !important;
  border: none !important;
}

.custom-checkbox:disabled:focus {
  box-shadow: none !important;
}

.custom-checkbox:disabled:checked:focus {
  box-shadow: none !important;
}
</style>