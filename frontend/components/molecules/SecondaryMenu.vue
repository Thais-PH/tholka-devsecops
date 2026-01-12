<template>
  <div class="w-full overflow-x-auto hide-scrollbar">
    <nav
      class="flex flex-row items-center p-1 relative bg-white rounded-[1000px]"
      :style="{ width: 'fit-content', height: '46px' }"
      aria-label="Secondary Menu"
      role="tablist"
      aria-orientation="horizontal"
    >
      <AtomsTabItem
        v-for="(item, index) in items"
        :key="item.id"
        :label="item.label"
        :variant="activeIndex === index ? 'active' : 'default'"
        @click="setActive(index)"
      />
    </nav>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const props = defineProps({
  items: {
    type: Array,
    required: true,
    validator: (items) => items.every(item => item.id && item.label)
  },
  defaultActiveIndex: {
    type: Number,
    default: 0
  }
})

const emit = defineEmits(['change'])

const activeIndex = ref(props.defaultActiveIndex)

const setActive = (index) => {
  activeIndex.value = index
  emit('change', {
    index,
    item: props.items[index]
  })
}
</script>