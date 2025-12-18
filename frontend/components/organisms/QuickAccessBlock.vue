<template>
  <div class="flex flex-col items-start px-[24px] py-[20px] gap-[16px] w-full bg-white rounded-lg shadow-sm">
    <!-- Header -->
    <div class="flex justify-between items-center w-full">
      <h5 class="text-h5 text-primary-500">{{ title }}</h5>
      <LucideRocket :size="24" :stroke-width="1" class="text-Orange-500" />
    </div>

    <!-- Quick Access List - Horizontal -->
    <div class="flex flex-row items-start w-full gap-6">
      <div 
        v-for="(access, index) in quickAccess" 
        :key="index"
        class="flex flex-row items-center gap-2"
      >
        <!-- Icône avec couleur -->
        <div 
          class="flex items-center justify-center w-[33px] h-[26px] rounded-lg flex-shrink-0"
          :class="getIconBackgroundColor(access.color)"
        >
          <component :is="access.icon" :size="17" :stroke-width="1.5" class="text-Light" />
        </div>

        <!-- Bouton -->
        <AtomsButton
          variant="tertiary"
          size="sm"
          justify="start"
          @click="handleAccessClick(access)"
        >
          {{ access.label }}
        </AtomsButton>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Rocket as LucideRocket } from 'lucide-vue-next'

const props = defineProps({
  title: {
    type: String,
    default: 'Accès rapides'
  },
  quickAccess: {
    type: Array,
    required: true
  }
})

const emit = defineEmits(['access-click'])

const getIconBackgroundColor = (color) => {
  const colors = {
    'primary': 'bg-primary-500',
    'secondary': 'bg-secondary-500',
    'orange': 'bg-Orange-500',
    'green': 'bg-Green-500'
  }
  return colors[color] || 'bg-primary-500'
}

const handleAccessClick = (access) => {
  if (access.action) {
    access.action()
  } else if (access.url) {
    window.open(access.url, '_blank')
  }
  emit('access-click', access)
}
</script>
