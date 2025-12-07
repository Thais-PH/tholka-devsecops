<!-- filepath: /home/lisa/projects/tholka/frontend/components/atoms/SearchBar.vue -->
<template>
  <div class="flex flex-row items-center" style="width: 386px; height: 50px;">
    <!-- Input -->
    <div class="relative flex-1">
      <input
        :id="id"
        v-model="searchValue"
        type="text"
        :placeholder="placeholder"
        :disabled="disabled"
        class="w-full h-[50px] px-[16px] py-[14px] bg-white border border-primary-300 rounded-l-lg text-base font-roboto text-primary-900 transition-colors duration-200 focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20"
        :class="{ 'opacity-50 cursor-not-allowed': disabled }"
        @input="handleInput"
        @keyup.enter="handleSearch"
      />
    </div>

    <!-- Button Icon -->
    <button
      type="button"
      class="flex justify-center items-center w-[46px] h-[50px] bg-primary-500 rounded-r-lg hover:bg-primary-700 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
      :disabled="disabled"
      @click="handleSearch"
    >
      <LucideSearch :size="20" :stroke-width="1.5" class="text-white" />
    </button>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const props = defineProps({
  id: {
    type: String,
    default: () => `search-${Math.random().toString(36).substr(2, 9)}`
  },
  modelValue: {
    type: String,
    default: ''
  },
  placeholder: {
    type: String,
    default: 'Label'
  },
  disabled: {
    type: Boolean,
    default: false
  }
})

const emit = defineEmits(['update:modelValue', 'search', 'input'])

const searchValue = computed({
  get() {
    return props.modelValue
  },
  set(value) {
    emit('update:modelValue', value)
  }
})

const handleInput = (event) => {
  emit('input', event.target.value)
}

const handleSearch = () => {
  if (!props.disabled) {
    emit('search', searchValue.value)
  }
}
</script>

<style scoped>
input::placeholder {
  color: #AEACAC; /* Grey-500 */
  font-family: 'Roboto', sans-serif;
  font-weight: 400;
}

input:disabled::placeholder {
  opacity: 0.5;
}
</style>