<template>
  <div class="flex flex-col w-full h-[447px]">
    <apexchart
      :key="JSON.stringify(series)"
      type="bar"
      :options="chartOptions"
      :series="series"
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
    default: () => [
      { name: 'Series 1', data: [0, 0, 0, 0] },
      { name: 'Series 2', data: [0, 0, 0, 0] }
    ]
  },
  labels: {
    type: Array,
    required: true,
    default: () => ['D', 'I', 'S', 'C']
  },
  colors: {
    type: Array,
    default: () => ['#EB5035', '#FFD83B']
  }
})

const chartOptions = computed(() => ({
  chart: {
    type: 'bar',
    toolbar: {
      show: false
    },
    margin: {
      top: 0,
      right: 0,
      bottom: 0,
      left: 0
    }
  },
  plotOptions: {
    bar: {
      horizontal: false,
      columnWidth: '30px',
      distributed: false
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
    axisBorder: {
      show: false
    },
    labels: {      rotate: 0,      style: {
        fontSize: '12px',
        fontWeight: 400,
        lineHeight: '1.125rem',
        fontFamily: 'Roboto, sans-serif',
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
      show: false
    }
  },
  dataLabels: {
    enabled: false
  },
  grid: {
    show: false,
    padding: {
      top: 0,
      right: 0,
      bottom: 0,
      left: 0
    },
    xaxis: {
      lines: {
        show: false
      }
    },
    yaxis: {
      lines: {
        show: false
      }
    }
  },
  tooltip: {
    enabled: false
  },
  states: {
    active: {
      filter: {
        type: 'none'
      }
    },
    hover: {
      filter: {
        type: 'none'
      }
    }
  }
}))
</script>
