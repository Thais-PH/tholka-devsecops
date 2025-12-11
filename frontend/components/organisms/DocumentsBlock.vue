<template>
  <div class="flex flex-col items-start px-[24px] py-[20px] gap-[16px] w-full max-w-[356px] max-h-[163px] bg-white rounded-lg shadow-sm">
    <!-- Header -->
    <div class="flex justify-between items-center w-full">
      <h5 class="text-h5 text-primary-500">{{ title }}</h5>
      <LucideFile size="24" stroke-width="1" class="text-Orange-500" />
    </div>

    <!-- Documents List -->
    <div class="flex flex-col items-start w-full">
      <AtomsButton
        v-for="(document, index) in documents"
        :key="index"
        variant="tertiary"
        size="sm"
        justify="start"
        @click="handleDocumentClick(document)"
      >
        {{ document.label }}
        <template #icon-right>
          <LucideChevronRight :size="17" :stroke-width="1" />
        </template>
      </AtomsButton>
    </div>
  </div>
</template>

<script setup lang="ts">
interface Document {
  label: string
  url?: string
}

const props = defineProps<{
  title?: string
  documents: Document[]
}>()

const emit = defineEmits<{
  'document-click': [document: Document]
}>()

const handleDocumentClick = (document: Document) => {
  if (document.url) {
    window.open(document.url, '_blank')
  }
  emit('document-click', document)
}
</script>