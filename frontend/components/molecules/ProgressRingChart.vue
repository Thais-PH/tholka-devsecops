<template>
  <div class="flex flex-col justify-center items-center gap-[10px]">
    <!-- Chart -->
    <div class="relative w-[200px] h-[200px]">
      <apexchart
        type="radialBar"
        :options="chartOptions"
        :series="[percentage]"
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
  percentage: {
    type: Number,
    required: true,
    default: 50
  },
  centerValue: {
    type: [String, Number],
    default: '50'
  },
  centerLabel: {
    type: String,
    default: 'Collaborateurs'
  },
  startAngle: {
    type: Number,
    default: 0
  },
  endAngle: {
    type: Number,
    default: 245
  },
  strokeWidth: {
    type: Number,
    default: 30
  }
})

const chartOptions = computed(() => ({
  chart: {
    type: 'radialBar',
    height: 200,
    width: 200,
    fontFamily: 'Roboto, sans-serif',
    toolbar: {
      show: false
    },
    sparkline: {
      enabled: true
    }
  },
  plotOptions: {
    radialBar: {
      startAngle: props.startAngle,
      endAngle: props.endAngle,
      hollow: {
        margin: 0,
        size: '80%',
        background: 'transparent'
      },
      track: {
        background: '#EFEEEE',
        strokeWidth: `${props.strokeWidth}px`,
        margin: 0
      },
      dataLabels: {
        show: false
      }
    }
  },
  fill: {
    type: 'gradient',
    gradient: {
      type: 'linear',
      colorStops: [
        { offset: 0, color: '#55C3E9' },
        { offset: 100, color: '#3A3B99' }
      ]
    }
  },
  stroke: {
    lineCap: 'round'
  },
  labels: ['Progress'],
  legend: {
    show: false
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