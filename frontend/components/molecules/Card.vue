<template>
  <!-- Event line Card - Structure Preline -->
  <div v-if="type === 'event'" class="flex items-center py-1 gap-4 w-full max-w-[292px] h-[59px] bg-white rounded-none">
    <!-- Section Date -->
    <div class="flex flex-col items-center w-[57px]">
      <!-- Jour -->
      <span class="font-nunito font-bold text-[28px] leading-[120%] text-primary-500">
        {{ day }}
      </span>
      <!-- Mois et Année -->
      <span class="font-roboto font-normal text-xs leading-[140%] text-primary-900">
        {{ formatDate }}
      </span>
    </div>

    <!-- Ligne verticale -->
    <div class="h-[51px] w-px bg-[#EBEBF5]"></div>

    <!-- Section Contenu -->
    <div class="flex flex-col justify-center items-start gap-2 w-[203px] h-[51px]">
      <!-- Tag -->
      <AtomsTag
        v-if="tag.text"
        :variant="tag.variant || 'stroke'"
        :color="tag.color || 'primary'"
        :size="tag.size || 'md'"
      >
        {{ tag.text }}
      </AtomsTag>
      
      <!-- Texte en dessous -->
      <span class="font-roboto font-normal text-sm leading-[130%] text-primary-900">
        {{ contentText }}
      </span>
    </div>
  </div>

  <!-- Annonce Card -->
  <div v-else-if="type === 'annonce'" class="flex flex-col items-start p-0 w-[258px] h-[139px]">
    <!-- Image section -->
    <div class="flex flex-row justify-end items-start p-[5px] gap-[10px] w-[258px] h-[106px] bg-cover bg-center rounded-lg flex-none order-0 self-stretch"
         :style="{ backgroundImage: `url(${imageUrl})` }">
      <!-- Video icon badge -->
      <div v-if="hasVideo" class="flex flex-row justify-center items-center p-[3px] w-[24px] h-[24px] bg-Orange-500 rounded-full">
        <LucideYoutube :size="17" :stroke-width="1.5" class="text-white" />
      </div>
    </div>
    
    <!-- Content -->
    <div class="flex flex-col items-start px-[4px] pt-[8px] pb-0 gap-[16px] w-[258px] h-[33px] flex-none order-1 self-stretch">
      <div class="flex flex-col items-start p-0 gap-[8px] w-[250px] h-[25px] flex-none order-0 self-stretch">
        <!-- Frame avec titre et tag -->
        <div class="flex flex-row justify-between items-center p-0 w-[250px] h-[25px] flex-none order-0 self-stretch">
          <!-- Titre -->
          <h6 class="font-nunito font-bold text-[16px] leading-[120%] text-primary-500 flex-none order-0 overflow-hidden text-ellipsis whitespace-nowrap" style="max-width: 206px;">
            {{ title }}
          </h6>

          <!-- Type de contrat tag - Container avec largeur fixe -->
          <div class="flex-shrink-0 flex items-center justify-center order-1" style="width: 40px; height: 25px; overflow: hidden;">
            <AtomsTag
              variant="soft"
              color="primary"
              size="md"
              class="!px-1 !py-1 !text-[11px]"
            >
              {{ contractType }}
            </AtomsTag>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Job Card - Structure Preline -->
  <div v-else-if="type === 'job'" class="relative" :class="{ 'ml-20': orderNumber }">
    <!-- Numéro d'ordre - Calque arrière-plan, position fixe -->
    <div v-if="orderNumber" class="absolute font-bold pointer-events-none" style="top: 0; left: -80px; font-family: 'Nunito', sans-serif; font-size: 150px; color: #F07F47; line-height: 1; z-index: 0; font-weight: 700;">
      {{ orderNumber }}
    </div>
    
    <!-- Carte elle-même - Calque dessus, décalée vers la gauche pour mordre -->
    <div class="relative flex flex-col bg-Light rounded-lg overflow-hidden w-[311px] min-h-[259px]" :class="{ '-ml-1': orderNumber }" style="z-index: 1;">
      <!-- Image section -->
      <div class="h-[135px] bg-cover bg-center rounded-t-lg" 
           :style="{ backgroundImage: `url(${imageUrl})` }">
      </div>
    
      <!-- Card body -->
      <div class="flex-1 p-4 relative z-30">
        <!-- Tag type de contrat -->
        <div class="mb-3">
          <AtomsTag
            variant="soft"
            color="primary"
            size="md"
          >
            {{ contractType }}
          </AtomsTag>
        </div>

        <!-- Titre du poste -->
        <h6 class="mb-2" style="font-family: 'Nunito', sans-serif; font-weight: 700; font-size: 16px; color: #3A3B99; line-height: 1.2;">
          {{ title }}
        </h6>

        <!-- Description tronquée -->
        <p class="line-clamp-3" style="font-family: 'Roboto', sans-serif; font-weight: 400; font-size: 14px; color: #050D2E;">
          {{ description }}
        </p>
      </div>
    </div>
  </div>

  <!-- Profile Card - Structure horizontale -->
  <div v-else-if="type === 'profile'" class="relative">
    <!-- Carte elle-même - Layout horizontal -->
    <div class="relative flex bg-Light rounded-lg overflow-hidden w-[400px] h-[200px]" style="z-index: 1;">
      <!-- Image section à gauche -->
      <div class="w-[150px] h-full bg-cover bg-center flex-shrink-0 rounded-l-lg" 
           :style="{ backgroundImage: `url(${imageUrl})` }">
      </div>
      
      <!-- Contenu à droite -->
      <div class="flex-1 p-4 flex flex-col justify-between">
        <div>
          <!-- Tag type de contrat -->
          <div class="mb-3">
            <AtomsTag 
              variant="soft" 
              color="primary" 
              size="md"
            >
              {{ contractType }}
            </AtomsTag>
          </div>
          
          <!-- Titre du profil -->
          <h6 class="mb-2" style="font-family: 'Nunito', sans-serif; font-weight: 700; font-size: 16px; color: #3A3B99; line-height: 1.2;">
            {{ title }}
          </h6>
          
          <!-- Description -->
          <p class="line-clamp-3 mb-4" style="font-family: 'Roboto', sans-serif; font-weight: 400; font-size: 14px; color: #050D2E;">
            {{ description }}
          </p>
        </div>
        
        <!-- Lien voir le profil -->
        <div>
          <a href="#" class="inline-flex items-center gap-x-1 hover:text-primary-700 font-medium" style="font-family: 'Roboto', sans-serif; font-weight: 400; font-size: 14px; color: #050D2E;">
            Voir le profil
            <svg class="flex-shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="m9 18 6-6-6-6"/>
            </svg>
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Stats Card - Corrigée selon maquette -->
  <div v-else-if="type === 'stats'" class="flex flex-col items-start p-[24px] w-[240px] h-[149px] bg-white rounded-lg">
    <!-- Content -->
    <div class="flex flex-col justify-center items-end px-[4px] py-0 gap-[24px] w-[174px] h-[101px] rounded-lg flex-none order-0">
      <!-- Frame principal -->
      <div class="flex flex-col items-start p-0 gap-[24px] w-[166px] h-[101px] flex-none order-0">
        <!-- Frame avec tag et titre -->
        <div class="flex flex-col items-start p-0 gap-[8px] w-[133px] h-[52px] flex-none order-0">
          <!-- Bloc tag -->
          <div class="flex flex-row items-center p-0 gap-[8px] w-[65px] h-[25px] flex-none order-0">
            <AtomsTag
              variant="soft"
              color="primary"
              size="md"
              status-color="primary"
              class="!w-[65px] !h-[25px] !font-roboto"
            >
              Publiée
            </AtomsTag>
          </div>

          <!-- Titre -->
          <h6 class="w-[133px] h-[19px] font-nunito font-bold text-[16px] leading-[120%] text-primary-500 flex-none order-1">
            {{ title }}
          </h6>
        </div>

        <!-- Frame statistiques -->
        <div class="flex flex-col items-start p-0 gap-[16px] w-[166px] h-[25px] flex-none order-1">
          <!-- Row avec tags et total -->
          <div class="flex flex-row items-center p-0 gap-[12px] w-[166px] h-[25px] flex-none order-0">
            <!-- Tags groupe -->
            <div class="flex flex-row items-start p-0 gap-[4px] w-[84px] h-[25px] flex-none order-0">
              <!-- Tag vert -->
              <AtomsTag
                variant="soft"
                color="green"
                size="md"
                class="!w-[30px] !h-[25px] !text-xs !font-normal !px-0 !justify-center !font-roboto"
              >
                {{ candidatesProcessed }}
              </AtomsTag>

              <!-- Tag bleu -->
              <AtomsTag
                variant="soft"
                color="secondary"
                size="md"
                class="!w-[23px] !h-[25px] !text-xs !font-normal !px-0 !justify-center !font-roboto"
              >
                {{ candidatesPending }}
              </AtomsTag>

              <!-- Tag orange -->
              <AtomsTag
                variant="soft"
                color="orange"
                size="md"
                class="!w-[23px] !h-[25px] !text-xs !font-normal !px-0 !justify-center !font-roboto"
              >
                {{ candidatesRejected }}
              </AtomsTag>
            </div>

            <!-- Total candidatures -->
            <span class="w-[70px] h-[17px] font-roboto font-normal text-xs leading-[140%] text-primary-900 flex-none order-1">
              {{ candidatesTotal }} candidats
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { Youtube as LucideYoutube } from 'lucide-vue-next'

const props = defineProps({
  type: {
    type: String,
    required: true,
    validator: (v) => ['event', 'annonce', 'job', 'profile', 'stats'].includes(v)
  },
  // Props pour Event line
  date: {
    type: [Date, String],
    required: false
  },
  tag: {
    type: Object,
    required: false,
    default: () => ({
      text: '',
      variant: 'stroke',
      color: 'primary',
      size: 'md',
      statusColor: null
    })
  },
  contentText: {
    type: String,
    required: false
  },
  // Props pour Annonce et Job
  title: {
    type: String,
    required: false
  },
  contractType: {
    type: String,
    required: false,
    validator: (v) => !v || ['CDD', 'CDI', 'Stage', 'Alternance', 'Intérim'].includes(v)
  },
  imageUrl: {
    type: String,
    required: false
  },
  hasVideo: {
    type: Boolean,
    default: false
  },
  // Props pour Job
  description: {
    type: String,
    required: false
  },
  // Props pour numéro d'ordre (formation)
  orderNumber: {
    type: [Number, String],
    required: false
  },
  // Props pour statistiques (stats card)
  candidatesProcessed: {
    type: Number,
    default: 0
  },
  candidatesPending: {
    type: Number,
    default: 0
  },
  candidatesRejected: {
    type: Number,
    default: 0
  },
  // Total des candidatures
  candidatesTotal: {
    type: Number,
    default: 0
  }
})

const day = computed(() => {
  if (props.type !== 'event' || !props.date) return ''
  const dateObj = typeof props.date === 'string' ? new Date(props.date) : props.date
  return dateObj.getDate().toString()
})

const formatDate = computed(() => {
  if (props.type !== 'event' || !props.date) return ''
  const dateObj = typeof props.date === 'string' ? new Date(props.date) : props.date
  const monthNames = [
    'janv.', 'févr.', 'mars', 'avr.', 'mai', 'juin',
    'juil.', 'août', 'sept.', 'oct.', 'nov.', 'déc.'
  ]
  
  const month = monthNames[dateObj.getMonth()]
  const year = dateObj.getFullYear()
  
  return `${month} ${year}`
})
</script>

<style scoped>
.font-nunito {
  font-family: 'Nunito', sans-serif;
}
</style>
