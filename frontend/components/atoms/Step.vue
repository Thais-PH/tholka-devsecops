<template>
  <div class="step" :class="stepClass">
    <!-- Inline container -->
    <div class="step-inline" :class="[inlineJustifyClass, { 'step-inline-mini': mini }]">
      <!-- Left Divider -->
      <div v-if="!isFirst" class="step-divider" :class="[dividerClass, { 'step-divider-mini': mini }]" />

      <!-- Button Icon -->
      <div class="step-icon-wrapper" :class="{ 'step-icon-wrapper-mini': mini }">
        <div class="step-icon" :class="[iconClass, { 'step-icon-mini': mini }]">
          <!-- Check Icon (completed state) -->
          <LucideCheck v-if="isCompleted" :size="mini ? 10 : 14" :stroke-width="1" class="text-white" />

          <!-- X Icon (rejected state) -->
          <LucideX v-else-if="isRejected" :size="mini ? 10 : 14" :stroke-width="1" class="text-white" />

          <!-- Step Number (default and active states - only if showNumber) -->
          <span
            v-else-if="showNumber"
            class="step-number"
            :class="{ 'step-number-mini': mini }"
          >
            {{ stepNumber }}
          </span>
        </div>

        <!-- Check Badge (for completed state - only if not mini) -->
        <div v-if="isCompleted && !mini" class="step-check-badge">
          <LucideCheck :size="8" :stroke-width="3" class="text-white" />
        </div>
      </div>

      <!-- Right Divider -->
      <div v-if="!isLast" class="step-divider" :class="[dividerClass, { 'step-divider-mini': mini }]" />
    </div>

    <!-- Vertical Title -->
    <div class="step-title" :class="{ 'step-title-mini': mini }">
      <span>{{ label }}</span>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { Check as LucideCheck, X as LucideX } from 'lucide-vue-next'

const props = defineProps({
  stepNumber: {
    type: [Number, String],
    required: true
  },
  label: {
    type: String,
    default: 'Step'
  },
  isActive: {
    type: Boolean,
    default: false
  },
  isCompleted: {
    type: Boolean,
    default: false
  },
  isRejected: {
    type: Boolean,
    default: false
  },
  isFirst: {
    type: Boolean,
    default: false
  },
  isLast: {
    type: Boolean,
    default: false
  },
  showNumber: {
    type: Boolean,
    default: true
  },
  mini: {
    type: Boolean,
    default: false
  }
})

const stepClass = computed(() => {
  return {
    'step-active': props.isActive,
    'step-completed': props.isCompleted,
    'step-rejected': props.isRejected,
    'step-mini': props.mini
  }
})

const dividerClass = computed(() => {
  if (props.isCompleted) return 'step-divider-completed'
  if (props.isActive) return 'step-divider-active'
  if (props.isRejected) return 'step-divider-completed'
  return ''
})

const iconClass = computed(() => {
  if (props.isRejected) return 'step-icon-rejected'
  if (props.isCompleted) return 'step-icon-completed'
  if (props.isActive) return 'step-icon-active'
  return ''
})

const inlineJustifyClass = computed(() => {
  if (props.isFirst) return 'justify-end'
  if (props.isLast) return 'justify-start'
  return 'justify-center'
})
</script>

<style scoped>
.step {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  padding: 0;
  gap: 8px;
  height: 60px;
}

.step-mini {
  height: 31px;
  gap: 4px;
}

.step-inline {
  display: flex;
  flex-direction: row;
  align-items: center;
  padding: 0;
  gap: 8px;
  width: 206px;
  height: 28px;
}

.step-inline-mini {
  width: 103px;
  height: 14.47px;
  gap: 4px;
}

.step-divider {
  width: 81px;
  height: 1px;
  background: rgba(58, 59, 153, 0.1);
  transition: background 0.2s ease;
}

.step-divider-mini {
  width: 42px;
  height: 0.5px;
}

.step-divider-active {
  background: rgba(58, 59, 153, 0.3);
}

.step-divider-completed {
  background: rgba(58, 59, 153, 0.3);
}

.step-icon-wrapper {
  position: relative;
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 0;
  gap: 5px;
  width: 28px;
  height: 28px;
}

.step-icon-wrapper-mini {
  width: 14.47px;
  height: 14.47px;
  gap: 2.5px;
}

.step-icon {
  display: flex;
  flex-direction: row;
  justify-content: center;
  align-items: center;
  padding: 0;
  width: 28px;
  height: 28px;
  background: rgba(58, 59, 153, 0.3);
  box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.05);
  border-radius: 999px;
  transition: background 0.2s ease;
}

.step-icon-mini {
  width: 14.47px;
  height: 14.47px;
  box-shadow: 0px 0.5px 0.5px rgba(0, 0, 0, 0.05);
}

.step-icon-active {
  background: #3A3B99;
}

.step-icon-completed {
  background: #3A3B99;
}

.step-icon-rejected {
  background: #AEACAC;
}

.step-check-badge {
  position: absolute;
  top: 16px;
  right: -5px;
  display: flex;
  flex-direction: row;
  align-items: center;
  justify-content: center;
  width: 16px;
  height: 16px;
  background: #1CAB78;
  border-radius: 50%;
  z-index: 10;
}

.step-number {
  width: 8px;
  height: 18px;
  @apply text-sm text-center text-Light font-roboto;
}

.step-number-mini {
  width: 5px;
  height: 9px;
  font-size: 7.23px;
  line-height: 130%;
}

.step-title {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  align-items: center;
  padding: 0;
}

.step-title-mini {
  height: 12px;
}

.step-title span {
  margin: 0 auto;
  @apply text-sm text-center font-roboto;
  color: rgba(58, 59, 153, 0.3);
  transition: color 0.2s ease;
  white-space: nowrap;
}

.step-mini .step-title span {
  font-size: 7.23px;
  line-height: 130%;
}

.step-active .step-title span {
  @apply text-primary-900 font-roboto;
}

.step-completed .step-title span {
  @apply text-primary-900 font-roboto;
}

.step-rejected .step-title span {
  color: #252958;
}
</style>