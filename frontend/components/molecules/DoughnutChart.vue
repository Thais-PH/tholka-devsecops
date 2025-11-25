<template>
  <div class="flex flex-col justify-center items-center gap-[10px]">
    <!-- Chart -->
    <div class="relative w-[200px] h-[200px]">
      <apexchart
        type="donut"
        :options="chartOptions"
        :series="series"
        height="200"
        width="200"
      />
      
      <!-- Center Content -->
      <div class="absolute inset-0 flex flex-col justify-center items-center pointer-events-none">
        <div class="flex flex-col justify-center items-center w-[157px] h-[156px] bg-Light rounded-full">
          <h2 class="text-h2 font-sans text-primary-500 leading-none">{{ centerValue }}</h2>
          <p class="text-base font-roboto text-center text-primary-900">{{ centerLabel }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
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
    },
    animations: {
      enabled: true,
      speed: 800,
      animateGradually: {
        enabled: true,
        delay: 150
      },
      dynamicAnimation: {
        enabled: true,
        speed: 350
      }
    }
  },
  plotOptions: {
    pie: {
      donut: {
        size: '10%'
      }
    }
  },
  colors: props.colors,
  series: props.series,
  labels: props.labels,
  legend: {
    show: false
  },
  dataLabels: {
    enabled: false
  },
  stroke: {
    width: 5, // Même valeur que l'exemple Preline
    colors: ['#efeeee'] // Blanc pour l'espacement
  },
  grid: {
    padding: {
      top: -12,
      bottom: -12,
      left: -12,
      right: -12
    }
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
    enabled: true,
    style: {
      fontSize: '14px',
      fontFamily: 'Roboto, sans-serif'
    },
    y: {
      formatter: (value) => `${value}%`
    }
  }
}))
</script>