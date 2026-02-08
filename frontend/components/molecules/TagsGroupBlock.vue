<template>
  <div class="flex flex-col items-start p-4 lg:px-5 lg:py-4 gap-4 bg-white rounded-lg w-full">
    <!-- Title -->
    <div class="flex flex-row justify-between items-center w-full">
      <h5 class="text-h5 font-sans font-bold text-primary-500">{{ title }}</h5>
    </div>

    <!-- Tags Container -->
    <div class="flex flex-col items-start gap-2 w-full">
      <div class="flex flex-row flex-wrap items-center gap-2 w-full">
        <!-- Visible Tags -->
        <AtomsTag
          v-for="(tag, index) in visibleTags"
          :key="tag"
          :variant="tagVariant"
          :color="tagColor"
          size="lg"
        >
          {{ tag }}
        </AtomsTag>

        <!-- Expanded Tags with Transition -->
        <TransitionGroup
          name="tag-expand"
          tag="span"
          class="contents"
        >
          <AtomsTag
            v-for="(tag, index) in expandedTags"
            v-show="isExpanded"
            :key="'expanded-' + tag"
            :variant="tagVariant"
            :color="tagColor"
            size="lg"
          >
            {{ tag }}
          </AtomsTag>
        </TransitionGroup>

        <!-- Toggle Button (+N / Voir moins) -->
        <Transition name="tag-toggle" mode="out-in">
          <AtomsTag
            v-if="hasHiddenTags && !isExpanded"
            key="expand-btn"
            variant="stroke"
            color="primary"
            size="lg"
            class="cursor-pointer hover:bg-primary-300 transition-colors"
            @click="toggleExpand"
          >
            +{{ hiddenCount }}
          </AtomsTag>
          <AtomsTag
            v-else-if="hasHiddenTags && isExpanded"
            key="collapse-btn"
            variant="stroke"
            color="primary"
            size="lg"
            class="cursor-pointer hover:bg-primary-300 transition-colors"
            @click="toggleExpand"
          >
            Voir moins
          </AtomsTag>
        </Transition>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const props = defineProps({
  title: {
    type: String,
    required: true
  },
  tags: {
    type: Array,
    required: true,
    default: () => []
  },
  maxVisible: {
    type: Number,
    default: 3
  },
  tagVariant: {
    type: String,
    default: 'soft'
  },
  tagColor: {
    type: String,
    default: 'green'
  }
})

const isExpanded = ref(false)

// Tags toujours visibles
const visibleTags = computed(() => {
  return props.tags.slice(0, props.maxVisible)
})

// Tags cachés (affichés quand expanded)
const expandedTags = computed(() => {
  return props.tags.slice(props.maxVisible)
})

// Nombre de tags cachés
const hiddenCount = computed(() => {
  return expandedTags.value.length
})

// A-t-on des tags cachés ?
const hasHiddenTags = computed(() => {
  return hiddenCount.value > 0
})

const toggleExpand = () => {
  isExpanded.value = !isExpanded.value
}
</script>

<style scoped>
/* Transition pour les tags qui apparaissent/disparaissent */
.tag-expand-enter-active {
  transition: all 0.3s ease-out;
}

.tag-expand-leave-active {
  transition: all 0.2s ease-in;
}

.tag-expand-enter-from {
  opacity: 0;
  transform: scale(0.8) translateY(-4px);
}

.tag-expand-leave-to {
  opacity: 0;
  transform: scale(0.8) translateY(-4px);
}

/* Transition pour le bouton toggle */
.tag-toggle-enter-active,
.tag-toggle-leave-active {
  transition: all 0.2s ease;
}

.tag-toggle-enter-from,
.tag-toggle-leave-to {
  opacity: 0;
  transform: scale(0.9);
}
</style>
