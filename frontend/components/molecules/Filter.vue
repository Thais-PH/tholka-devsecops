<template>
  <div class="relative">
    <!-- Dropdown Button -->
    <button
      @click="isOpen = !isOpen"
      class="h-[38px] px-4 py-2 inline-flex items-center justify-center gap-x-2 text-sm rounded-lg bg-Light border border-Grey-300 text-primary-500 hover:bg-Grey-100 transition-colors font-roboto font-normal"
    >
      {{ filterLabel }}
      <svg
        class="shrink-0 size-4 transition-transform"
        :class="{ 'rotate-180': isOpen }"
        xmlns="http://www.w3.org/2000/svg"
        width="24"
        height="24"
        viewBox="0 0 24 24"
        fill="none"
        stroke="currentColor"
        stroke-width="2"
        stroke-linecap="round"
        stroke-linejoin="round"
      >
        <path d="m6 9 6 6 6-6" />
      </svg>
    </button>

    <!-- Dropdown Content -->
    <div
      v-show="isOpen"
      @click.stop
      class="absolute right-0 mt-2 w-64 bg-Light border border-Grey-300 rounded-lg shadow-lg z-50"
    >
      <!-- Filter Options -->
      <div class="p-4 max-h-96 overflow-y-auto">
        <div v-for="option in filterOptions" :key="option.id" class="mb-3">
          <label class="flex items-center justify-between cursor-pointer">
            <span class="text-sm font-roboto text-primary-900">{{ option.label }}</span>
            <input
              type="checkbox"
              :value="option.id"
              v-model="selectedFilters"
              class="w-4 h-4 rounded border-Grey-500 text-primary-500"
            />
          </label>
        </div>
      </div>

      <!-- Apply Button -->
      <div class="p-4">
        <button
          @click="applyFilters"
          class="w-full h-[38px] px-4 py-2 inline-flex items-center justify-center text-sm rounded-lg bg-primary-500 text-Light hover:bg-primary-700 transition-colors font-roboto font-normal"
        >
          Appliquer
        </button>
      </div>
    </div>

    <!-- Overlay to close dropdown -->
    <div
      v-if="isOpen"
      @click="isOpen = false"
      class="fixed inset-0 z-40"
    />
  </div>
</template>

<script setup>
import { ref } from 'vue'

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
  }
})

const emit = defineEmits(['update:modelValue', 'apply-filters'])

const isOpen = ref(false)
const selectedFilters = ref([...props.modelValue])

const applyFilters = () => {
  emit('update:modelValue', selectedFilters.value)
  emit('apply-filters', selectedFilters.value)
  isOpen.value = false
}
</script>
