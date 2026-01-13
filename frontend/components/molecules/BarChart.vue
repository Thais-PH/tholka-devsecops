<template>
  <div class="flex flex-col w-[320px] h-[380px]">
    <apexchart
      :key="JSON.stringify(series)"
      type="bar"
      :options="chartOptions"
      :series="[{ data: series }]"
      width="100%"
      height="100%"
    />
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  series: {
    type: Array,
    required: true,
    default: () => [0, 0, 0, 0]
  },
  labels: {
    type: Array,
    required: true,
    default: () => ['D', 'I', 'S', 'C']
  },
  colors: {
    type: Array,
    default: () => ['#EB5035', '#FFD83B', '#45CA24', '#476EF6']
  }
})

const chartOptions = computed(() => ({
  chart: {
    type: 'bar',
    toolbar: {
      show: false
    }
  },
  plotOptions: {
    bar: {
      horizontal: false,
      distributed: true
    }
  },
  colors: props.colors,
  legend: {
    show: false
  },
  xaxis: {
    categories: props.labels,
    axisTicks: {
      show: false
    },
    labels: {
      style: {
        fontSize: '16px',
        fontWeight: 500,
        fontFamily: 'Roboto, sans-serif',
        lineHeight: '1.4',
        letterSpacing: '0px'
      }
    }
  },
  yaxis: {
    min: 0,
    max: 100,
    tickAmount: 4,
    labels: {
      formatter: (val) => `${val}%`,
      style: {
        fontSize: '12px',
        fontWeight: 400,
        lineHeight: '1.313rem',
        fontFamily: 'Roboto, sans-serif'
      }
    },
    axisBorder: {
      show: true
    }
  },
  dataLabels: {
    enabled: true,
    formatter: (val) => `${val}%`,
    distributed: true,
    style: {
      fontSize: '12px',
      fontWeight: 400,
      lineHeight: '1.125rem',
      fontFamily: 'Roboto, sans-serif',
      colors: ['#AA271D', '#AF8434', '#146E4E', '#252958']
    }
  },
  tooltip: {
    enabled: false
  },
  states: {
    hover: {
      filter: {
        type: 'none'
      }
    }
  }
}))
</script>