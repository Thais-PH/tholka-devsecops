<template>
  <div class="flex flex-col items-center gap-3 md:flex-row md:flex-nowrap md:items-center md:gap-6">
    <MoleculesFilter
      v-for="filter in filters"
      :key="filter.id"
      :filter-label="filter.label"
      :filter-options="filter.options"
      :model-value="filter.value"
      :variant="filterVariant"
      @update:modelValue="(val) => $emit('update-filter', { id: filter.id, value: val })"
      @apply-filters="(val) => $emit('apply-filter', { id: filter.id, value: val })"
    />
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  filters: {
    type: Array,
    required: true,
    default: () => []
  },
  variant: {
    type: String,
    default: 'dark',
    validator: (v) => ['dark', 'light'].includes(v)
  }
})

defineEmits(['update-filter', 'apply-filter'])

// Map legacy FilterBar variants to MoleculesFilter variants
// 'dark' = used on dark background -> transparent/text style
// 'light' = used on light background -> solid/button style
const filterVariant = computed(() => {
  return props.variant === 'dark' ? 'text' : 'button'
})
</script>

