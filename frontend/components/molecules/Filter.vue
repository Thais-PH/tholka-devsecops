<template>
  <div class="relative" ref="filterRef">
    <!-- Dropdown Button -->
    <button
      ref="buttonRef"
      @click="toggleDropdown"
      :class="buttonClasses"
    >
      {{ filterLabel }}
      <LucideChevronDown
        v-if="!isOpen"
        :size="24"
        :stroke-width="1"
        class="shrink-0"
      />
      <LucideChevronUp
        v-else
        :size="24"
        :stroke-width="1"
        class="shrink-0"
      />
    </button>

    <!-- Dropdown Content (position absolute, suit le bouton naturellement) -->
    <div
      v-show="isOpen"
      @click.stop
      :class="dropdownClasses"
    >
      <!-- Filter Options -->
      <div class="overflow-y-auto w-full">
        <div v-for="option in filterOptions" :key="option.id" class="mb-4 last:mb-0">
          <label class="flex items-center justify-between cursor-pointer group" :for="`filter-option-${option.id}`">
            <span :class="['text-base font-roboto transition-colors whitespace-nowrap mr-4', optionLabelClasses]">{{ option.label }}</span>
            <AtomsCheckbox
              :id="`filter-option-${option.id}`"
              :value="option.id"
              v-model="selectedFilters"
              :border-color="checkboxBorderColor"
              class="p-1"
            />
          </label>
        </div>
      </div>

      <!-- Apply Button -->
      <AtomsButton
        @click="applyFilters"
        variant="primary"
        size="md"
        :on-white="variant === 'text'"
        :class="applyButtonClasses"
      >
        Afficher les résultats
      </AtomsButton>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { ChevronDown as LucideChevronDown, ChevronUp as LucideChevronUp } from 'lucide-vue-next'

const props = defineProps({
  filterLabel: {
    type: String,
    required: true
  },
  filterOptions: {
    type: Array,
    required: true,
    default: () => []
  },
  modelValue: {
    type: Array,
    default: () => []
  },
  variant: {
    type: String,
    default: 'button',
    validator: (v) => ['button', 'text'].includes(v)
  }
})

const emit = defineEmits(['update:modelValue', 'apply-filters'])

const isOpen = ref(false)
const selectedFilters = ref([...props.modelValue])
const buttonRef = ref(null)
const filterRef = ref(null)

const toggleDropdown = () => {
  isOpen.value = !isOpen.value
}

const closeDropdown = () => {
  isOpen.value = false
}

const handleClickOutside = (event) => {
  if (filterRef.value && !filterRef.value.contains(event.target)) {
    closeDropdown()
  }
}

onMounted(() => {
  document.addEventListener('click', handleClickOutside)
})

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside)
})

const buttonClasses = computed(() => {
  if (props.variant === 'text') {
    // Style Dark
    const base = 'h-[38px] px-6 py-3 inline-flex items-center justify-center gap-x-1 text-base rounded-lg transition-colors font-roboto font-normal'
    const state = isOpen.value
      ? 'bg-white/15 text-white'
      : 'bg-transparent text-white hover:text-white/80'
    return `${base} ${state}`
  }
  // Style Light (défaut)
  const base = 'h-[38px] px-6 py-3 inline-flex items-center justify-center gap-x-1 text-base rounded-lg transition-colors font-roboto font-normal'
  const state = isOpen.value
    ? 'bg-white text-primary-500 shadow-sm'
    : 'bg-white text-primary-500 hover:bg-gray-50'
  return `${base} ${state}`
})

const dropdownClasses = computed(() => {
  // Position absolute, centré sur mobile et desktop
  const base = 'absolute top-full mt-2 left-1/2 -translate-x-1/2 min-w-[240px] w-max max-w-[calc(100vw-32px)] rounded-lg shadow-lg z-50 flex flex-col gap-5 px-6 py-4 overflow-hidden'
  if (props.variant === 'text') {
    // Dark
    return `${base} bg-[#252958]`
  }
  // Light
  return `${base} bg-white border border-Grey-200`
})

const optionLabelClasses = computed(() => {
  if (props.variant === 'text') {
    return 'text-white'
  }
  return 'text-[#050D2E]'
})

const checkboxBorderColor = computed(() => {
  if (props.variant === 'button') {
    return 'border-Grey-500' // Light variant uses Grey-500
  }
  return 'border-primary-300' // Default/Dark variant
})

const applyButtonClasses = computed(() => {
  if (props.variant === 'text') {
    // Dark: Style outline blanc sans hover effect distinct
    return 'w-full !bg-transparent !border-white !text-white hover:!bg-transparent hover:!text-white'
  }
  // Light: Bouton plein bleu (défaut composant)
  return 'w-full'
})

const applyFilters = () => {
  emit('update:modelValue', selectedFilters.value)
  emit('apply-filters', selectedFilters.value)
  closeDropdown()
}
</script>
