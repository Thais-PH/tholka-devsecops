<template>
  <div class="flex flex-col items-start p-5 w-full h-full min-h-[303px] bg-white rounded-lg box-border overflow-hidden">
    <!-- Title Section -->
    <div class="flex flex-col items-start gap-1 w-full flex-shrink-0">
      <!-- Header Row -->
      <div class="flex flex-row justify-between items-center w-full">
        <h5 class="text-h5 text-primary-500">{{ title }}</h5>
        <LucideUsers2 :size="24" :stroke-width="1" class="text-Orange-500" />
      </div>

      <!-- Month/Year Selector -->
      <div class="relative">
        <button
          class="flex flex-row justify-center items-center py-1 gap-1 text-sm text-primary-900 font-roboto"
          @click="toggleDropdown"
        >
          <span>{{ selectedMonthLabel }}</span>
          <LucideChevronDown :size="17" :stroke-width="1" class="text-primary-500" />
        </button>

        <!-- Dropdown Menu -->
        <div
          v-if="isDropdownOpen"
          class="absolute top-full left-0 mt-1 bg-white border border-Grey-300 rounded-lg shadow-lg z-10 max-h-48 overflow-y-auto"
        >
          <button
            v-for="option in monthOptions"
            :key="option.value"
            class="w-full px-4 py-2 text-sm text-left text-primary-900 hover:bg-secondary-300 font-roboto"
            @click="selectMonth(option)"
          >
            {{ option.label }}
          </button>
        </div>
      </div>
    </div>

    <!-- Chart Section -->
    <div class="flex flex-row justify-between items-center w-full flex-1 min-h-0">
      <!-- Legend -->
      <div class="flex flex-col items-start gap-2">
        <!-- Départs -->
        <div class="flex flex-row items-center gap-[5px] lg:gap-[20px]">
          <AtomsTag
            variant="soft"
            color="orange"
            size="md"
            status-color="orange"
            class="min-w-[76px]"
          >
            <span class="text-xs font-xs font-roboto">Départs</span>
          </AtomsTag>
          <span class="text-xs font-xs font-roboto text-primary-700 min-w-[20px] text-right">{{ departures }}</span>
        </div>

        <!-- Arrivées -->
        <div class="flex flex-row items-center gap-[5px] lg:gap-[20px]">
          <AtomsTag
            variant="soft"
            color="secondary"
            size="md"
            status-color="secondary"
            class="min-w-[76px]"
          >
            <span class="text-xs font-xs font-roboto">Arrivées</span>
          </AtomsTag>
          <span class="text-xs font-xs font-roboto text-primary-700 min-w-[20px] text-right">{{ arrivals }}</span>
        </div>

        <!-- En poste -->
        <div class="flex flex-row items-center gap-[5px] lg:gap-[20px]">
          <AtomsTag
            variant="soft"
            color="green"
            size="md"
            status-color="green"
            class="min-w-[76px]"
          >
            <span class="text-xs font-xs font-roboto">En poste</span>
          </AtomsTag>
          <span class="text-xs font-xs font-roboto text-primary-700 min-w-[20px] text-right">{{ inPosition }}</span>
        </div>
      </div>

      <!-- Doughnut Chart -->
      <div class="w-[187px] h-[187px] flex-shrink-0">
        <MoleculesDoughnutChart
          :series="chartSeries"
          :labels="chartLabels"
          :colors="chartColors"
          :center-value="computedCenterValue"
          :center-label="centerLabel"
          :size="187"
        />
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import { Users2 as LucideUsers2, ChevronDown as LucideChevronDown } from 'lucide-vue-next'

const props = defineProps({
  title: {
    type: String,
    default: 'Collaborateurs'
  },
  centerValue: {
    type: [String, Number],
    default: null
  },
  centerLabel: {
    type: String,
    default: 'Collaborateurs'
  },
  departures: {
    type: Number,
    default: 20
  },
  arrivals: {
    type: Number,
    default: 30
  },
  inPosition: {
    type: Number,
    default: 80
  }
})

// Computed pour la valeur centrale (utilise la prop ou calcule le total)
const computedCenterValue = computed(() => {
  if (props.centerValue !== null) {
    return props.centerValue
  }
  return props.departures + props.arrivals + props.inPosition
})

// Données du chart
const chartSeries = computed(() => [props.inPosition, props.arrivals, props.departures])
const chartLabels = ref(['En poste', 'Arrivées', 'Départs'])
const chartColors = ref(['#1CAB78', '#55C3E9', '#F07F47']) // [green, secondary/cyan, orange]

// Month/Year Dropdown
const isDropdownOpen = ref(false)
const selectedMonth = ref({ label: 'Janvier 2026', value: '2026-01' })

const monthOptions = [
  { label: 'Janvier 2026', value: '2026-01' },
  { label: 'Décembre 2025', value: '2025-12' },
  { label: 'Novembre 2025', value: '2025-11' },
  { label: 'Octobre 2025', value: '2025-10' },
  { label: 'Septembre 2025', value: '2025-09' },
  { label: 'Août 2025', value: '2025-08' }
]

const selectedMonthLabel = computed(() => selectedMonth.value.label)

const toggleDropdown = () => {
  isDropdownOpen.value = !isDropdownOpen.value
}

const selectMonth = (option: { label: string; value: string }) => {
  selectedMonth.value = option
  isDropdownOpen.value = false
}

// Close dropdown when clicking outside
const closeDropdown = () => {
  isDropdownOpen.value = false
}
</script>
