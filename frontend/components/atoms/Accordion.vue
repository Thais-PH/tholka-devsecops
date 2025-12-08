<template>
  <div
    class="hs-accordion bg-white border border-primary-300 rounded-xl overflow-hidden"
    :class="{ 'active': isOpen }"
  >
    <!-- Header -->
    <button
      type="button"
      class="hs-accordion-toggle w-full flex items-center justify-between px-[20px] py-[16px] text-left transition-colors duration-200 hover:bg-Grey-300/30"
      :class="{ 'border-b border-primary-300': isOpen }"
      @click="toggleAccordion"
    >
      <!-- Title -->
      <span class="text-base font-roboto font-normal text-primary-900">
        {{ title }}
      </span>

      <!-- Chevron Icon -->
      <LucideChevronDown
        v-if="!isOpen"
        :size="16"
        :stroke-width="1"
        class="text-primary-900 flex-shrink-0"
      />
      <LucideChevronUp
        v-else
        :size="16"
        :stroke-width="1"
        class="text-primary-900 flex-shrink-0"
      />
    </button>

    <!-- Content -->
    <div
      v-show="isOpen"
      class="hs-accordion-content w-full overflow-hidden transition-all duration-300"
    >
      <div class="px-[20px] py-[16px]">
        <!-- Boutons dans le contenu -->
        <div class="flex flex-wrap gap-[10px]">
          <slot>
            <!-- Contenu par défaut si aucun slot fourni -->
            <AtomsButton
              v-for="n in 6"
              :key="n"
              variant="forms"
              size="md"
              class="accordion-button"
            >
              {{ `08.0${n}` }}
            </AtomsButton>
          </slot>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const props = defineProps({
  title: {
    type: String,
    required: true
  },
  open: {
    type: Boolean,
    default: false
  }
})

const emit = defineEmits(['toggle'])

const isOpen = ref(props.open)

const toggleAccordion = () => {
  isOpen.value = !isOpen.value
  emit('toggle', isOpen.value)
}
</script>

<style scoped>
.hs-accordion {
  width: 475px;
  min-height: 54px;
}

/* Force les boutons dans le contenu de l'accordéon à avoir les dimensions exactes */
.hs-accordion-content :deep(button) {
  width: 72px !important;
  min-width: 72px !important;
  max-width: 72px !important;
  height: 38px !important;
  min-height: 38px !important;
  max-height: 38px !important;
  padding: 8px 16px !important;
  flex-shrink: 0 !important;
  flex-grow: 0 !important;
  background-color: #EBEBF5 !important;
}

/* S'assurer que le texte ne déborde pas */
.hs-accordion-content :deep(button span) {
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}
</style>