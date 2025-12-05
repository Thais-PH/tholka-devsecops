<!-- filepath: /home/lisa/projects/tholka/frontend/components/atoms/Radio.vue -->
<template>
  <div class="flex items-start gap-[16px]">
    <!-- Radio -->
    <div class="flex items-start pt-1">
      <input
        :id="id"
        v-model="selected"
        type="radio"
        :value="value"
        :name="name"
        :disabled="disabled"
        class="custom-radio w-[16px] h-[16px] bg-white border border-primary-300 rounded-full cursor-pointer transition-colors duration-200"
        :class="{ 'error-radio': error }"
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
    default: () => `radio-${Math.random().toString(36).substr(2, 9)}`
  },
  modelValue: {
    type: [String, Number, Boolean],
    default: null
  },
  value: {
    type: [String, Number, Boolean],
    required: true
  },
  name: {
    type: String,
    required: true
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

const selected = computed({
  get() {
    return props.modelValue
  },
  set(newValue) {
    emit('update:modelValue', newValue)
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
    value: event.target.value
  })
}
</script>

<style scoped>
.custom-radio {
  --tw-ring-color: #3A3B99 !important;
}

.custom-radio:focus {
  outline: none !important;
  box-shadow: 0 0 0 2px #3A3B99 !important;
  border-color: #3A3B99 !important;
}

.custom-radio:checked {
  background-color: #3A3B99 !important;
  border-color: #3A3B99 !important;
}

.custom-radio:checked:focus {
  background-color: #3A3B99 !important;
  border-color: #3A3B99 !important;
  box-shadow: 0 0 0 2px #3A3B99 !important;
}

/* États hover */
.custom-radio:hover:not(:disabled) {
  border-color: #5A5BB0 !important;
}

.custom-radio:checked:hover:not(:disabled) {
  background-color: #5A5BB0 !important;
  border-color: #5A5BB0 !important;
}

/* États error */
.custom-radio.error-radio {
  border-color: #EB5035 !important;
  background-color: #FFFFFF !important;
}

.custom-radio.error-radio:focus {
  outline: none !important;
  box-shadow: 0 0 0 2px #EB5035 !important;
  border-color: #EB5035 !important;
}

.custom-radio.error-radio:checked {
  background-color: #EB5035 !important;
  border-color: #EB5035 !important;
}

.custom-radio.error-radio:checked:focus {
  background-color: #EB5035 !important;
  border-color: #EB5035 !important;
  box-shadow: 0 0 0 2px #EB5035 !important;
}

.custom-radio.error-radio:hover:not(:disabled) {
  border-color: #EB5035 !important;
}

.custom-radio.error-radio:checked:hover:not(:disabled) {
  background-color: #EB5035 !important;
  border-color: #EB5035 !important;
}

/* États disabled */
.custom-radio:disabled {
  cursor: not-allowed !important;
  --tw-ring-color: #3A3B9950 !important;
  border: none !important;
}

.custom-radio:disabled {
  background-color: #FFFFFF50 !important;
}

.custom-radio:disabled:checked {
  background-color: #3A3B9950 !important;
  border: none !important;
}

.custom-radio:disabled:focus {
  box-shadow: none !important;
}

.custom-radio:disabled:checked:focus {
  box-shadow: none !important;
}
</style>