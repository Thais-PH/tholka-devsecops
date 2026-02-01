<template>
  <nav class="flex flex-row items-start p-0 overflow-x-auto hide-scrollbar">
    <div class="flex flex-row items-center gap-4 whitespace-nowrap">
      <template v-for="(item, index) in items" :key="index">
        <!-- Item -->
        <div class="flex flex-row items-center gap-2.5 rounded-md">
          <!-- Icon home (optionnel) -->
          <LucideHome
            v-if="item.icon === 'home'"
            :size="18"
            :stroke-width="1"
            class="text-primary-900"
          />

          <!-- Label -->
          <NuxtLink
            v-if="item.to && index !== items.length - 1"
            :to="item.to"
            class="font-roboto font-normal text-base leading-[140%] text-center text-primary-900 hover:text-primary-500 transition-colors"
          >
            {{ item.label }}
          </NuxtLink>
          <span
            v-else
            class="font-roboto text-base leading-[140%] text-center text-primary-900"
            :class="index === items.length - 1 ? 'font-medium' : 'font-normal'"
          >
            {{ item.label }}
          </span>
        </div>

        <!-- Chevron separator (sauf pour le dernier item) -->
        <LucideChevronRight
          v-if="index !== items.length - 1"
          :size="18"
          :stroke-width="1"
          class="text-primary-900"
        />
      </template>
    </div>
  </nav>
</template>

<script setup>
import { ChevronRight as LucideChevronRight, Home as LucideHome } from 'lucide-vue-next'

defineProps({
  items: {
    type: Array,
    required: true,
    // Chaque item : { label: string, to?: string, icon?: 'home' }
    default: () => []
  }
})
</script>

<style scoped>
.hide-scrollbar::-webkit-scrollbar {
  display: none;
}

.hide-scrollbar {
  -ms-overflow-style: none;
  scrollbar-width: none;
}
</style>
