<template>
  <div class="flex flex-col items-start px-[24px] py-[20px] gap-[16px] w-full max-w-[356px] max-h-[171px] bg-white rounded-lg shadow-sm">
    <!-- Header -->
    <div class="flex justify-between items-center w-full">
      <h5 class="text-h5 text-primary-500">{{ title }}</h5>
      <LucideRocket :size="24" :stroke-width="1" class="text-Orange-500" />
    </div>

    <!-- Quick Access List -->
    <div class="flex flex-col items-start w-full gap-1">
      <div 
        v-for="(access, index) in quickAccess" 
        :key="index"
        class="flex flex-row items-center w-full gap-0"
      >
        <!-- Icône avec couleur -->
        <div 
          class="flex items-center justify-center w-[33px] h-[26px] rounded-lg flex-shrink-0"
          :class="getIconBackgroundColor(access.color)"
        >
          <component :is="access.icon" :size="17" :stroke-width="1.5" class="text-Light" />
        </div>

        <!-- Wrapper pour le bouton -->
        <div class="flex-1">
          <AtomsButton
            variant="tertiary"
            size="sm"
            justify="start"
            class="inline-flex"
            @click="handleAccessClick(access)"
          >
            {{ access.label }}
          </AtomsButton>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import type { Component } from 'vue'

interface QuickAccess {
  label: string
  icon: Component
  color: 'primary' | 'secondary' | 'orange' | 'green'
  url?: string
  action?: () => void
}

defineProps<{
  title?: string
  quickAccess: QuickAccess[]
}>()

const emit = defineEmits<{
  'access-click': [access: QuickAccess]
}>()

const getIconBackgroundColor = (color: QuickAccess['color']) => {
  const colors = {
    'primary': 'bg-primary-500',
    'secondary': 'bg-secondary-500',
    'orange': 'bg-Orange-500',
    'green': 'bg-Green-500'
  }
  return colors[color] || 'bg-primary-500'
}

const handleAccessClick = (access: QuickAccess) => {
  if (access.action) {
    access.action()
  } else if (access.url) {
    window.open(access.url, '_blank')
  }
  emit('access-click', access)
}
</script>