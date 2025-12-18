<template>
  <nav class="flex justify-center">
    <ul class="flex gap-x-1">
      <!-- Previous Button -->
      <li>
        <button
          @click="handlePrevious"
          :disabled="currentPage === 1"
          class="h-[38px] w-[38px] py-2 px-0 inline-flex items-center justify-center rounded-lg border border-Grey-300 text-primary-500 hover:text-primary-700 disabled:opacity-50 disabled:pointer-events-none transition-colors"
        >
          <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="m15 18-6-6 6-6" />
          </svg>
        </button>
      </li>

      <!-- Page Numbers -->
      <li v-for="page in displayedPages" :key="page">
        <template v-if="page === '...'">
          <span class="h-[38px] px-4 py-2 inline-flex items-center justify-center text-sm text-primary-900">{{ page }}</span>
        </template>
        <template v-else>
          <button
            @click="handlePageClick(page)"
            :class="[
              'h-[38px] w-[38px] py-2 px-0 inline-flex items-center justify-center rounded-lg border transition-colors font-roboto font-normal text-base',
              currentPage === page
                ? 'bg-primary-500 border-primary-500 text-Light'
                : 'border-Grey-300 text-primary-500 hover:text-primary-700'
            ]"
          >
            {{ page }}
          </button>
        </template>
      </li>

      <!-- Next Button -->
      <li>
        <button
          @click="handleNext"
          :disabled="currentPage === totalPages"
          class="h-[38px] w-[38px] py-2 px-0 inline-flex items-center justify-center rounded-lg border border-Grey-300 text-primary-500 hover:text-primary-700 disabled:opacity-50 disabled:pointer-events-none transition-colors"
        >
          <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="m9 18 6-6-6-6" />
          </svg>
        </button>
      </li>
    </ul>
  </nav>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  currentPage: {
    type: Number,
    required: true,
    default: 1
  },
  totalPages: {
    type: Number,
    required: true,
    default: 1
  },
  maxVisiblePages: {
    type: Number,
    default: 5
  }
})

const emit = defineEmits(['page-change'])

const displayedPages = computed(() => {
  const pages = []
  const totalPages = props.totalPages
  const currentPage = props.currentPage
  const maxVisible = props.maxVisiblePages

  // Always show first page
  pages.push(1)

  // Calculate range around current page
  let start = Math.max(2, currentPage - Math.floor(maxVisible / 2))
  let end = Math.min(totalPages - 1, start + maxVisible - 3)

  // Adjust start if we're near the end
  if (end === totalPages - 1) {
    start = Math.max(2, end - maxVisible + 3)
  }

  // Add ellipsis if needed
  if (start > 2) {
    pages.push('...')
  }

  // Add middle pages
  for (let i = start; i <= end; i++) {
    pages.push(i)
  }

  // Add ellipsis if needed
  if (end < totalPages - 1) {
    pages.push('...')
  }

  // Always show last page if more than 1
  if (totalPages > 1) {
    pages.push(totalPages)
  }

  return pages
})

const handlePageClick = (page) => {
  if (page !== '...') {
    emit('page-change', page)
  }
}

const handlePrevious = () => {
  if (props.currentPage > 1) {
    emit('page-change', props.currentPage - 1)
  }
}

const handleNext = () => {
  if (props.currentPage < props.totalPages) {
    emit('page-change', props.currentPage + 1)
  }
}
</script>
