<template>
  <div class="flex flex-col items-start px-[24px] py-[20px] gap-[16px] w-full max-w-[356px] bg-white rounded-lg shadow-sm">
    <!-- Header -->
    <div class="flex justify-between items-center w-full">
      <h5 class="text-h5 text-primary-500">{{ title }}</h5>
      <LucidePalmtree size="24" stroke-width="1" class="text-Orange-500" />
    </div>

    <!-- Vacations List -->
    <div class="flex flex-col items-start w-full gap-2">
      <div 
        v-for="(vacation, index) in vacations" 
        :key="index"
        class="flex flex-row items-center w-full gap-[15px]"
      >
        <!-- Type et Statut -->
        <div class="flex flex-row items-center gap-[5px] flex-1">
          <!-- Type -->
          <span class="font-roboto font-normal text-base leading-[140%] text-primary-900 min-w-[43px]">
            {{ vacation.type }}
          </span>
          
          <!-- Statut -->
          <span 
            class="font-roboto font-medium text-base leading-[140%] flex-1 min-w-[169px]"
            :class="getStatusColor(vacation.status)"
          >
            {{ vacation.status }}
          </span>
        </div>

        <!-- Date -->
        <span class="font-roboto font-normal text-base leading-[140%] text-primary-900 w-[86px]">
          {{ vacation.date }}
        </span>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
interface Vacation {
  type: string
  status: 'Accepté' | 'En attente' | 'Refusé'
  date: string
}

defineProps<{
  title?: string
  vacations: Vacation[]
}>()

const getStatusColor = (status: Vacation['status']) => {
  const colors = {
    'Accepté': 'text-Green-500',
    'En attente': 'text-primary-500',
    'Refusé': 'text-Orange-500'
  }
  return colors[status] || 'text-primary-900'
}
</script>