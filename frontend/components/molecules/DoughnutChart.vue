<template>
  <div class="flex flex-col justify-center items-center gap-[10px]">
    <!-- Chart -->
    <div class="relative w-[200px] h-[200px]">
      <ClientOnly>
        <apexchart
          type="donut"
          :options="chartOptions"
          :series="props.series"
          height="200"
          width="200"
        />
      </ClientOnly>
      
      <!-- Center Content -->
      <div class="absolute inset-0 flex flex-col justify-center items-center pointer-events-none">
        <div class="flex flex-col justify-center items-center w-[140px] h-[140px] bg-Light rounded-full">
          <h2 class="text-h2 font-sans text-primary-500 leading-none">{{ centerValue }}</h2>
          <p class="text-base font-roboto text-center text-primary-900">{{ centerLabel }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  series: {
    type: Array,
    required: true,
  },
  labels: {
    type: Array,
    required: true,
  },
  colors: {
    type: Array,
    default: () => ['#1CAB78', '#55C3E9', '#F07F47']
  },
  centerValue: {
    type: [String, Number],
    default: '50'
  },
  centerLabel: {
    type: String,
    default: 'Collaborateurs'
  }
})

const chartOptions = computed(() => ({
  chart: {
    type: 'donut',
    height: 200,
    width: 200,
    fontFamily: 'Roboto, sans-serif',
    toolbar: {
      show: false
    },
    zoom: {
      enabled: false
    }
  },
  plotOptions: {
    pie: {
      donut: {
        size: '35%',
        background: 'transparent'
      }
    }
  },
  colors: props.colors,
  labels: props.labels,
  series: props.series,
  legend: {
    show: false
  },
  dataLabels: {
    enabled: false
  },
  stroke: {
    show: true,
    width: 4,
    colors: ['#ECF8FD']
  },
  states: {
    hover: {
      filter: {
        type: 'none'
      }
    },
    active: {
      filter: {
        type: 'none'
      }
    }
  },
  tooltip: {
    enabled: false
  }
}))
</script>