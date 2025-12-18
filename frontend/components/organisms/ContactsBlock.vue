<template>
  <div class="flex flex-col items-start px-[24px] py-[20px] gap-[16px] w-full bg-white rounded-lg shadow-sm">
    <!-- Header -->
    <div class="flex justify-between items-center w-full">
      <h5 class="text-h5 text-primary-500">{{ title }}</h5>
      <LucideContact2 size="24" stroke-width="1" class="text-Orange-500" />
    </div>

    <!-- Contacts List -->
    <div class="flex flex-col items-start w-full gap-2">
      <div 
        v-for="(contact, index) in contacts" 
        :key="index"
        class="flex flex-col justify-center items-start w-full gap-[5px]"
      >
        <!-- Nom du contact -->
        <span class="font-roboto font-semibold text-base leading-[140%] text-primary-500">
          {{ contact.name }}
        </span>
        
        <!-- Email -->
        <span class="font-roboto font-normal text-base leading-[140%] text-primary-900">
          {{ contact.email }}
        </span>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Contact2 as LucideContact2 } from 'lucide-vue-next'

defineProps({
  title: {
    type: String,
    default: 'Contact de référence'
  },
  contacts: {
    type: Array,
    required: true
  }
})
</script>
