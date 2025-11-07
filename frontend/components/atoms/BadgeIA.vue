<template>
  <span class="ia-badge" aria-hidden="true">
    <img :src="badgeSrc" alt="" :width="badgeSize" :height="badgeSize" />
  </span>
</template>

<script setup>
import badgeSmall from '~/assets/icons/badge-ia-sm.svg'
import badgeMedium from '~/assets/icons/badge-ia-md.svg'
import badgeLarge from '~/assets/icons/badge-ia-lg.svg'

const props = defineProps({
  size: {
    type: String,
    default: 'md',
    validator: (value) => ['sm', 'md', 'lg'].includes(value)
  }
})

const badgeSrc = computed(() => {
  const sizeMap = {
    sm: badgeSmall,
    md: badgeMedium,
    lg: badgeLarge
  }
  return sizeMap[props.size]
})

const badgeSize = computed(() => {
  const sizeMap = {
    sm: 16,
    md: 18,
    lg: 20
  }
  return sizeMap[props.size]
})
</script>

<style scoped>
.ia-badge {
  display: inline-flex;
  align-items: center;
  justify-content: center;
}

.ia-badge img {
  display: block;
}
</style>