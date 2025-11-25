<template>
  <div class="flex flex-col items-start gap-[10px] w-[245px]">
    <!-- Chart Content -->
    <div class="flex flex-row items-start gap-[10px] w-full h-[248px]">
      <!-- Y-Axes Labels -->
      <div class="flex flex-col justify-between items-end w-[31px] h-[239px] text-sm font-roboto text-primary-900">
        <span>100%</span>
        <span>75%</span>
        <span>50%</span>
        <span>25%</span>
        <span>0%</span>
      </div>

      <!-- Chart -->
      <div class="flex-1 h-[248px] border-l border-b border-primary-500/30">
        <apexchart
          type="bar"
          :options="chartOptions"
          :series="[{ data: series }]"
          height="247"
        />
      </div>
    </div>

    <!-- X-Axes Labels -->
    <div class="flex flex-row justify-end items-end w-full h-4 gap-4 pl-[31px]">
      <span
        v-for="(label, index) in labels"
        :key="index"
        class="w-[30px] h-4 text-base font-roboto font-medium text-center text-primary-900"
      >
        {{ label }}
      </span>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  series: {
    type: Array,
    required: true,
    default: () => [8, 25, 78, 65]
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
    height: 247,
    fontFamily: 'Roboto, sans-serif',
    toolbar: {
      show: false
    },
    animations: {
      enabled: true,
      speed: 800,
      animateGradually: {
        enabled: true,
        delay: 150
      }
    }
  },
  plotOptions: {
    bar: {
      horizontal: false,
      columnWidth: '30px',
      borderRadius: 8,
      borderRadiusApplication: 'end',
      distributed: true,
      dataLabels: {
        position: 'center'
      }
    }
  },
  colors: props.colors,
  dataLabels: {
    enabled: true,
    formatter: (val) => `${val}%`,
    style: {
      fontSize: '12px',
      fontFamily: 'Roboto, sans-serif',
      fontWeight: 400,
      colors: ['#AA271D', '#AF8434', '#146E4E', '#252958']
    },
    offsetY: 0
  },
  legend: {
    show: false
  },
  xaxis: {
    categories: props.labels,
    labels: {
      show: false
    },
    axisBorder: {
      show: false
    },
    axisTicks: {
      show: false
    }
  },
  yaxis: {
    show: false,
    min: 0,
    max: 100
  },
  grid: {
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
  },
  states: {
    hover: {
      filter: {
        type: 'darken',
        value: 0.1
      }
    }
  }
}))
</script>