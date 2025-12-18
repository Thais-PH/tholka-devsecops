<template>
  <div class="flex flex-col items-start pt-[20px] pr-[24px] pb-[20px] pl-[24px] gap-[16px] bg-white rounded-lg shadow-sm">
    <!-- Header with Title and Button -->
    <div class="flex justify-between items-center w-full">
      <h5 class="text-h5 text-primary-500">{{ title }}</h5>
      <AtomsButton
        variant="tertiary"
        size="sm"
        @click="handleSeeAll"
      >
        Voir tout
        <template #icon-right>
          <LucideChevronRight :size="17" :stroke-width="1" />
        </template>
      </AtomsButton>
    </div>

    <!-- Annonces Grid - Horizontal Layout -->
    <div class="flex gap-4 w-full overflow-x-auto pb-2">
      <MoleculesCard
        v-for="(annonce, index) in annonces"
        :key="index"
        type="annonce"
        :title="annonce.title"
        :contract-type="annonce.contractType"
        :image-url="annonce.imageUrl"
      />
    </div>
  </div>
</template>

<script setup lang="ts">
interface Annonce {
  title: string
  contractType: string
  imageUrl: string
}

const props = defineProps<{
  title?: string
  annonces: Annonce[]
}>()

const emit = defineEmits<{
  'see-all': []
}>()

const handleSeeAll = () => {
  emit('see-all')
}
</script>
