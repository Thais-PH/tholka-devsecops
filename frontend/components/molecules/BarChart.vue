<template>
  <div class="flex flex-col w-full h-full">
    <apexchart
      :key="JSON.stringify(series)"
      type="bar"
      :options="chartOptions"
      :series="[{ data: series }]"
      :width="width"
      :height="height"
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
  },
  // Dimensions
  width: {
    type: [String, Number],
    default: '100%'
  },
  height: {
    type: [String, Number],
    default: '100%'
  },
  // Tailles de police
  xAxisFontSize: {
    type: String,
    default: '26px'
  },
  yAxisFontSize: {
    type: String,
    default: '24px'
  },
  dataLabelsFontSize: {
    type: String,
    default: '20px'
  },
  // Largeur des barres
  columnWidth: {
    type: String,
    default: '50px'
  },
  // Écart au-dessus des labels X (D, I, S, C)
  xAxisLabelOffset: {
    type: Number,
    default: 17
  }
})

const chartOptions = computed(() => ({
  chart: {
    type: 'bar',
    offsetX: -18,
    toolbar: {
      show: false
    }
  },
  plotOptions: {
    bar: {
      horizontal: false,
      distributed: true,
      columnWidth: props.columnWidth
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
      offsetY: props.xAxisLabelOffset,
      style: {
        fontSize: props.xAxisFontSize,
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
        fontSize: props.yAxisFontSize,
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
      fontSize: props.dataLabelsFontSize,
      fontWeight: 400,
      lineHeight: '1.125rem',
      fontFamily: 'Roboto, sans-serif',
      colors: ['#AA271D', '#AF8434', '#146E4E', '#252958']
    }
  },
  tooltip: {
    enabled: true,
    custom: function({ series, seriesIndex, dataPointIndex, w }) {
      const value = series[seriesIndex][dataPointIndex]
      let message = ''

      if (value >= 0 && value < 30) {
        message = '0% à 30% :<br>La dimension est très difficilement mobilisable.'
      } else if (value >= 30 && value < 50) {
        message = '30% à 50% :<br>La dimension n\'est pas spontanée et demande un effort.'
      } else if (value >= 50 && value < 70) {
        message = '50% à 70% :<br>La dimension est mobilisable très facilement.'
      } else {
        message = '70% à 100% :<br>La dimension est naturelle et sans effort.'
      }

      return `
        <div class="disc-tooltip-wrapper">
          <div class="disc-tooltip-content">
            <span class="disc-tooltip-text">${message}</span>
          </div>
          <div class="disc-tooltip-arrow"></div>
        </div>
      `
    }
  },
  states: {
    hover: {
      filter: {
        type: 'none'
      }
    }
  },
  fill: {
    opacity: 1
  }
}))
</script>

<style>
/* Override ApexCharts tooltip container */
.apexcharts-tooltip {
  background: transparent !important;
  border: none !important;
  box-shadow: none !important;
  overflow: visible !important;
  transform: translateX(45%);
}

/* Tooltip DISC */
.disc-tooltip-wrapper {
  display: flex;
  flex-direction: column;
  align-items: center;
  position: relative;
  padding-bottom: 8px;
}

.disc-tooltip-content {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  padding: 8px 10px;
  gap: 4px;
  background: #0E0E0E;
  border-radius: 4px;
}

.disc-tooltip-text {
  width: 100%;
  font-family: 'Roboto', sans-serif !important;
  font-style: normal;
  font-weight: 400;
  font-size: 16px;
  line-height: 140%;
  text-align: center;
  color: #FFFFFF;
}

.disc-tooltip-arrow {
  position: absolute;
  bottom: 0;
  left: 50%;
  transform: translateX(-50%);
  width: 0;
  height: 0;
  border-left: 8px solid transparent;
  border-right: 8px solid transparent;
  border-top: 8px solid #0E0E0E;
}
</style>