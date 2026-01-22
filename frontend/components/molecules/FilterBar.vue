<template>
  <div class="flex flex-row items-start gap-6">
    <!-- Filtre par catégorie -->
    <div v-if="showCategory" class="relative">
      <button
        @click="toggleDropdown('category')"
        class="flex flex-row justify-center items-center px-6 py-3 gap-1 h-[38px] rounded-lg transition-colors"
        :class="variant === 'dark' ? 'text-Light hover:bg-white/10' : 'bg-white text-primary-500 hover:bg-Grey-300'"
      >
        <span class="text-base font-roboto">{{ categoryLabel }}</span>
        <LucideChevronDown :size="24" :stroke-width="1" :class="{ 'rotate-180': openDropdown === 'category' }" class="transition-transform" />
      </button>
      
      <!-- Dropdown catégorie -->
      <div
        v-if="openDropdown === 'category'"
        class="absolute top-full left-0 mt-2 min-w-[200px] bg-white rounded-lg shadow-lg border border-Grey-300 z-50"
      >
        <button
          v-for="option in categoryOptions"
          :key="option.value"
          @click="selectCategory(option)"
          class="w-full px-4 py-3 text-left text-base font-roboto text-primary-500 hover:bg-primary-300 first:rounded-t-lg last:rounded-b-lg"
          :class="{ 'bg-primary-300': selectedCategory?.value === option.value }"
        >
          {{ option.label }}
        </button>
      </div>
    </div>

    <!-- Filtre par type -->
    <div v-if="showType" class="relative">
      <button
        @click="toggleDropdown('type')"
        class="flex flex-row justify-center items-center px-6 py-3 gap-1 h-[38px] rounded-lg transition-colors"
        :class="variant === 'dark' ? 'text-Light hover:bg-white/10' : 'bg-white text-primary-500 hover:bg-Grey-300'"
      >
        <span class="text-base font-roboto">{{ typeLabel }}</span>
        <LucideChevronDown :size="24" :stroke-width="1" :class="{ 'rotate-180': openDropdown === 'type' }" class="transition-transform" />
      </button>
      
      <!-- Dropdown type -->
      <div
        v-if="openDropdown === 'type'"
        class="absolute top-full left-0 mt-2 min-w-[200px] bg-white rounded-lg shadow-lg border border-Grey-300 z-50"
      >
        <button
          v-for="option in typeOptions"
          :key="option.value"
          @click="selectType(option)"
          class="w-full px-4 py-3 text-left text-base font-roboto text-primary-500 hover:bg-primary-300 first:rounded-t-lg last:rounded-b-lg"
          :class="{ 'bg-primary-300': selectedType?.value === option.value }"
        >
          {{ option.label }}
        </button>
      </div>
    </div>

    <!-- Filtre par modalité -->
    <div v-if="showModality" class="relative">
      <button
        @click="toggleDropdown('modality')"
        class="flex flex-row justify-center items-center px-6 py-3 gap-1 h-[38px] rounded-lg transition-colors"
        :class="variant === 'dark' ? 'text-Light hover:bg-white/10' : 'bg-white text-primary-500 hover:bg-Grey-300'"
      >
        <span class="text-base font-roboto">{{ modalityLabel }}</span>
        <LucideChevronDown :size="24" :stroke-width="1" :class="{ 'rotate-180': openDropdown === 'modality' }" class="transition-transform" />
      </button>
      
      <!-- Dropdown modalité -->
      <div
        v-if="openDropdown === 'modality'"
        class="absolute top-full left-0 mt-2 min-w-[200px] bg-white rounded-lg shadow-lg border border-Grey-300 z-50"
      >
        <button
          v-for="option in modalityOptions"
          :key="option.value"
          @click="selectModality(option)"
          class="w-full px-4 py-3 text-left text-base font-roboto text-primary-500 hover:bg-primary-300 first:rounded-t-lg last:rounded-b-lg"
          :class="{ 'bg-primary-300': selectedModality?.value === option.value }"
        >
          {{ option.label }}
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { ChevronDown as LucideChevronDown } from 'lucide-vue-next'

const props = defineProps({
  variant: {
    type: String,
    default: 'dark',
    validator: (v) => ['dark', 'light'].includes(v)
  },
  showCategory: {
    type: Boolean,
    default: true
  },
  showType: {
    type: Boolean,
    default: true
  },
  showModality: {
    type: Boolean,
    default: true
  },
  categoryOptions: {
    type: Array,
    default: () => [
      { label: 'Toutes les catégories', value: 'all' },
      { label: 'Management', value: 'management' },
      { label: 'Informatique', value: 'informatique' },
      { label: 'Communication', value: 'communication' },
      { label: 'Ressources Humaines', value: 'rh' }
    ]
  },
  typeOptions: {
    type: Array,
    default: () => [
      { label: 'Tous les types', value: 'all' },
      { label: 'Parcours', value: 'parcours' },
      { label: 'Capsule', value: 'capsule' },
      { label: 'Formation présentielle', value: 'presentiel' }
    ]
  },
  modalityOptions: {
    type: Array,
    default: () => [
      { label: 'Toutes les modalités', value: 'all' },
      { label: 'E-learning', value: 'elearning' },
      { label: 'Présentiel', value: 'presentiel' },
      { label: 'Blended', value: 'blended' }
    ]
  },
  defaultCategoryLabel: {
    type: String,
    default: 'Catégorie'
  },
  defaultTypeLabel: {
    type: String,
    default: 'Type de formation'
  },
  defaultModalityLabel: {
    type: String,
    default: 'Modalité'
  }
})

const emit = defineEmits(['filter-change'])

const openDropdown = ref(null)
const selectedCategory = ref(null)
const selectedType = ref(null)
const selectedModality = ref(null)

const categoryLabel = computed(() => selectedCategory.value?.label || props.defaultCategoryLabel)
const typeLabel = computed(() => selectedType.value?.label || props.defaultTypeLabel)
const modalityLabel = computed(() => selectedModality.value?.label || props.defaultModalityLabel)

const toggleDropdown = (dropdown) => {
  openDropdown.value = openDropdown.value === dropdown ? null : dropdown
}

const selectCategory = (option) => {
  selectedCategory.value = option.value === 'all' ? null : option
  openDropdown.value = null
  emitFilterChange()
}

const selectType = (option) => {
  selectedType.value = option.value === 'all' ? null : option
  openDropdown.value = null
  emitFilterChange()
}

const selectModality = (option) => {
  selectedModality.value = option.value === 'all' ? null : option
  openDropdown.value = null
  emitFilterChange()
}

const emitFilterChange = () => {
  emit('filter-change', {
    category: selectedCategory.value,
    type: selectedType.value,
    modality: selectedModality.value
  })
}

// Fermer les dropdowns quand on clique ailleurs
const handleClickOutside = (event) => {
  if (!event.target.closest('.relative')) {
    openDropdown.value = null
  }
}

onMounted(() => {
  document.addEventListener('click', handleClickOutside)
})

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside)
})
</script>
