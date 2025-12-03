<template>
  <div class="step" :class="{ 'step-active': isActive, 'step-completed': isCompleted }">
    <!-- Inline container -->
    <div class="step-inline" :class="inlineJustifyClass">
      <!-- Left Divider -->
      <div v-if="!isFirst" class="step-divider" :class="dividerClass" />

      <!-- Button Icon -->
      <div class="step-icon-wrapper">
        <div class="step-icon" :class="iconClass">
          <!-- Step Number (default and active states) -->
          <span
            v-if="!isCompleted"
            class="step-number"
          >
            {{ stepNumber }}
          </span>

          <!-- Check Icon (completed state) -->
          <div v-if="isCompleted" class="step-check-container">
            <span class="step-number">{{ stepNumber }}</span>
          </div>
        </div>

        <!-- Check Badge (for completed state) -->
        <div v-if="isCompleted" class="step-check-badge">
          <LucideCheck :size="8" :stroke-width="3" class="text-white" />
        </div>
      </div>

      <!-- Right Divider -->
      <div v-if="!isLast" class="step-divider" :class="dividerClass" />
    </div>

    <!-- Vertical Title -->
    <div class="step-title">
      <span>{{ label }}</span>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

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
  isFirst: {
    type: Boolean,
    default: false
  },
  isLast: {
    type: Boolean,
    default: false
  }
})

const dividerClass = computed(() => {
  if (props.isCompleted) return 'step-divider-completed'
  if (props.isActive) return 'step-divider-active'
  return ''
})

const iconClass = computed(() => {
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

.step-inline {
  display: flex;
  flex-direction: row;
  align-items: center;
  padding: 0;
  gap: 8px;
  width: 206px;
  height: 28px;
}

.step-divider {
  width: 81px;
  height: 1px;
  background: rgba(58, 59, 153, 0.1);
  transition: background 0.2s ease;
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

.step-icon-active {
  background: #3A3B99;
}

.step-icon-completed {
  background: #3A3B99;
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

.step-title {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  align-items: center;
  padding: 0;
}

.step-title span {
  margin: 0 auto;
  @apply text-sm text-center font-roboto;
  color: rgba(58, 59, 153, 0.3);
  transition: color 0.2s ease;
  white-space: nowrap;
}

.step-active .step-title span {
  @apply text-primary-900 font-roboto;
}

.step-completed .step-title span {
  @apply text-primary-900 font-roboto;
}
</style>