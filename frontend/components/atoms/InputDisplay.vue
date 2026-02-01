<template>
  <div class="flex flex-col gap-[15px] w-full">
    <!-- Label -->
    <label
      v-if="label"
      class="text-base font-roboto text-primary-900"
    >
      {{ label }}
    </label>

    <!-- Display Field -->
    <div 
      class="flex flex-row items-center px-4 py-[14px] bg-white border border-Grey-500 rounded-lg min-h-[50px]"
    >
      <!-- Content -->
      <div class="flex items-center gap-2">
        <!-- File icon -->
        <LucideFileText 
          v-if="fileIcon" 
          :size="17" 
          :stroke-width="1" 
          class="text-Grey-500 shrink-0" 
        />
        
        <!-- Value (slot ou valeur par défaut) -->
        <span 
          class="font-roboto text-base"
          :class="valueClass"
        >
          <slot>{{ modelValue || placeholder }}</slot>
        </span>
      </div>

      <!-- Action icon -->
      <button
        v-if="copyable"
        type="button"
        class="ml-4 p-1 hover:bg-Grey-300 rounded transition-colors shrink-0"
        @click="handleCopy"
        :title="copied ? 'Copié !' : 'Copier'"
      >
        <LucideCheck v-if="copied" :size="17" :stroke-width="1" class="text-Green-500" />
        <LucideCopy v-else :size="17" :stroke-width="1" class="text-Grey-500" />
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { 
  Copy as LucideCopy, 
  Check as LucideCheck,
  FileText as LucideFileText 
} from 'lucide-vue-next'

const props = defineProps({
  modelValue: {
    type: String,
    default: ''
  },
  label: {
    type: String,
    default: ''
  },
  placeholder: {
    type: String,
    default: ''
  },
  copyable: {
    type: Boolean,
    default: false
  },
  fileIcon: {
    type: Boolean,
    default: false
  },
  bold: {
    type: Boolean,
    default: false
  }
})

const emit = defineEmits(['copy'])

const copied = ref(false)

const valueClass = computed(() => {
  const classes = ['text-primary-900']
  if (props.bold) {
    classes.push('font-semibold')
  }
  return classes.join(' ')
})

const handleCopy = async () => {
  if (props.modelValue) {
    try {
      await navigator.clipboard.writeText(props.modelValue)
      copied.value = true
      emit('copy', props.modelValue)
      setTimeout(() => {
        copied.value = false
      }, 2000)
    } catch (err) {
      console.error('Erreur lors de la copie:', err)
    }
  }
}
</script>
