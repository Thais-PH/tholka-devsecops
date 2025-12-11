<template>
  <div class="flex flex-col items-start px-[24px] py-[20px] gap-[16px] w-[413px] bg-white rounded-lg shadow-sm">
    <!-- Calendar Grid -->
    <div class="w-full">
      <!-- Month Navigation -->
      <div class="flex items-center justify-between mb-4">
        <button
          @click="previousMonth"
          class="p-2 hover:bg-Grey-100 rounded-lg transition"
        >
          <LucideChevronLeft size="20" class="text-primary-500" />
        </button>
        <span class="text-sm font-semibold text-primary-500">
          {{ monthYearLabel }}
        </span>
        <button
          @click="nextMonth"
          class="p-2 hover:bg-Grey-100 rounded-lg transition"
        >
          <LucideChevronRight size="20" class="text-primary-500" />
        </button>
      </div>

      <!-- Days of Week -->
      <div class="grid grid-cols-7 gap-1 mb-2">
        <div
          v-for="day in weekDays"
          :key="day"
          class="text-center text-xs font-semibold text-Grey-500 py-2"
        >
          {{ day }}
        </div>
      </div>

      <!-- Calendar Days -->
      <div class="grid grid-cols-7 gap-1">
        <button
          v-for="day in calendarDays"
          :key="`${day.month}-${day.date}`"
          @click="selectDate(day)"
          :class="[
            'p-2 text-sm font-medium transition',
            day.currentMonth
              ? isToday(day) 
                ? 'bg-secondary-300 text-primary-500 font-bold rounded-full'
                : isSelected(day)
                ? 'bg-primary-500 text-white rounded-full'
                : 'text-primary-900 hover:bg-Grey-100 rounded-lg'
              : 'text-Grey-300 cursor-default rounded-lg'
          ]"
          :disabled="!day.currentMonth"
        >
          {{ day.date }}
        </button>
      </div>
    </div>

    <!-- Events List - 3 event cards vertically -->
    <div class="flex flex-col w-full gap-3">
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
import { ref, computed } from 'vue'

interface Event {
  day: string
  monthYear: string
  tagLabel?: string
  title: string
  year?: number
}

interface CalendarDay {
  date: number
  month: number
  year: number
  currentMonth: boolean
}

const weekDays = ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim']

const currentDate = ref<Date>(new Date())
const selectedDate = ref<Date | null>(null)

const monthYearLabel = computed(() => {
  const months = [
    'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
    'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'
  ]
  return `${months[currentDate.value.getMonth()]} ${currentDate.value.getFullYear()}`
})

const calendarDays = computed(() => {
  const year = currentDate.value.getFullYear()
  const month = currentDate.value.getMonth()
  
  // Premier jour du mois
  const firstDay = new Date(year, month, 1).getDay()
  // Nombre de jours dans le mois
  const daysInMonth = new Date(year, month + 1, 0).getDate()
  // Nombre de jours dans le mois précédent
  const daysInPrevMonth = new Date(year, month, 0).getDate()
  
  const days: CalendarDay[] = []
  
  // Jours du mois précédent
  const adjustedFirstDay = firstDay === 0 ? 6 : firstDay - 1
  for (let i = adjustedFirstDay; i > 0; i--) {
    days.push({
      date: daysInPrevMonth - i + 1,
      month: month - 1,
      year: month === 0 ? year - 1 : year,
      currentMonth: false
    })
  }
  
  // Jours du mois actuel
  for (let i = 1; i <= daysInMonth; i++) {
    days.push({
      date: i,
      month: month,
      year: year,
      currentMonth: true
    })
  }
  
  // Jours du mois suivant
  const remainingDays = 42 - days.length
  for (let i = 1; i <= remainingDays; i++) {
    days.push({
      date: i,
      month: month + 1,
      year: month === 11 ? year + 1 : year,
      currentMonth: false
    })
  }
  
  return days
})

const previousMonth = () => {
  currentDate.value = new Date(currentDate.value.getFullYear(), currentDate.value.getMonth() - 1, 1)
}

const nextMonth = () => {
  currentDate.value = new Date(currentDate.value.getFullYear(), currentDate.value.getMonth() + 1, 1)
}

const selectDate = (day: CalendarDay) => {
  if (day.currentMonth) {
    selectedDate.value = new Date(day.year, day.month, day.date)
  }
}

const isToday = (day: CalendarDay): boolean => {
  const today = new Date()
  return (
    day.date === today.getDate() &&
    day.month === today.getMonth() &&
    day.year === today.getFullYear() &&
    day.currentMonth
  )
}

const isSelected = (day: CalendarDay): boolean => {
  if (!selectedDate.value) return false
  return (
    day.date === selectedDate.value.getDate() &&
    day.month === selectedDate.value.getMonth() &&
    day.year === selectedDate.value.getFullYear() &&
    day.currentMonth
  )
}

// Example events - replace with your data
const events = ref<Event[]>([
  {
    day: '15',
    monthYear: 'janv.',
    tagLabel: 'Réunion',
    title: 'Réunion d\'équipe',
    year: 2025
  },
  {
    day: '20',
    monthYear: 'janv.',
    tagLabel: 'Deadline',
    title: 'Deadline projet frontend',
    year: 2025
  },
  {
    day: '25',
    monthYear: 'janv.',
    tagLabel: 'Conférence',
    title: 'Conférence Vue 3',
    year: 2025
  }
])

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
