<template>
  <div class="flex flex-col items-start px-[24px] py-[20px] md:p-6 gap-[16px] w-full bg-white rounded-lg">
    <!-- Header -->
    <div class="flex justify-between items-center w-full">
      <h5 class="text-h5 text-primary-500">{{ title }}</h5>
      <LucideCalendarDays size="24" stroke-width="1" class="text-Orange-500" />
    </div>

    <!-- Events List -->
    <div class="flex flex-col w-full gap-2">
      <MoleculesCard
        v-for="(event, index) in events"
        :key="index"
        type="event"
        :date="new Date(event.year ?? new Date().getFullYear(), getMonthIndex(event.monthYear), parseInt(event.day))"
        :tag="{ text: event.tagLabel, variant: 'stroke', color: 'primary', size: 'md' }"
        :content-text="event.title"
      />
    </div>
  </div>
</template>

<script setup lang="ts">
import { defineProps } from 'vue'

interface Event {
  day: string
  monthYear: string
  tagLabel?: string
  title: string
  year?: number
}

defineProps<{
  title?: string
  events: Event[]
}>()

// Helper pour convertir le nom du mois en index
const getMonthIndex = (monthYear: string): number => {
  const months: Record<string, number> = {
    'janv.': 0, 'févr.': 1, 'mars': 2, 'avr.': 3,
    'mai': 4, 'juin': 5, 'juil.': 6, 'août': 7,
    'sept.': 8, 'oct.': 9, 'nov.': 10, 'déc.': 11
  }
  const month = monthYear.split(' ')[0]?.toLowerCase() || ''
  return months[month] || 8 // Par défaut septembre
}
</script>