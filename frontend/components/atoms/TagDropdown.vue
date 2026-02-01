<template>
  <div class="relative inline-block" ref="dropdownRef">
    <!-- Trigger Button (Tag avec dropdown) -->
    <button
      type="button"
      class="flex items-center"
      @click.stop="toggleDropdown"
    >
      <AtomsTag
        :color="currentOption?.color || 'primary'"
        :variant="currentOption?.variant || 'solid'"
        :size="currentOption?.size || 'md'"
        :status-color="currentOption?.statusColor || null"
      >
        {{ currentOption?.label || modelValue }}
        <LucideChevronDown v-if="!isOpen" :size="20" :stroke-width="1.5" />
        <LucideChevronUp v-else :size="20" :stroke-width="1.5" />
      </AtomsTag>
    </button>

    <!-- Dropdown Menu -->
    <Transition
      enter-active-class="transition ease-out duration-200"
      enter-from-class="opacity-0 translate-y-1"
      enter-to-class="opacity-100 translate-y-0"
      leave-active-class="transition ease-in duration-150"
      leave-from-class="opacity-100 translate-y-0"
      leave-to-class="opacity-0 translate-y-1"
    >
      <div
        v-if="isOpen"
        class="absolute left-0 top-full mt-2 flex flex-col items-start gap-2 z-50"
      >
        <button
          v-for="option in options"
          :key="option.value"
          type="button"
          @click="selectOption(option)"
        >
          <AtomsTag
            :color="option.color || 'primary'"
            :variant="option.variant || 'solid'"
            :size="option.size || 'md'"
            :status-color="option.statusColor || null"
          >
            {{ option.label }}
          </AtomsTag>
        </button>
      </div>
    </Transition>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { ChevronDown as LucideChevronDown, ChevronUp as LucideChevronUp } from 'lucide-vue-next'

const props = defineProps({
  modelValue: {
    type: String,
    default: ''
  },
  options: {
    type: Array,
    required: true,
    // Chaque option : { value: string, label: string, color: string, variant?: string, size?: string, statusColor?: string }
    default: () => []
  }
})

const emit = defineEmits(['update:modelValue', 'change'])

const dropdownRef = ref(null)
const isOpen = ref(false)

const currentOption = computed(() => {
  return props.options.find(opt => opt.value === props.modelValue)
})

const toggleDropdown = () => {
  isOpen.value = !isOpen.value
}

const selectOption = (option) => {
  emit('update:modelValue', option.value)
  emit('change', option)
  isOpen.value = false
}

const handleClickOutside = (event) => {
  if (dropdownRef.value && !dropdownRef.value.contains(event.target)) {
    isOpen.value = false
  }
}

onMounted(() => {
  document.addEventListener('click', handleClickOutside)
})

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside)
})
</script>
