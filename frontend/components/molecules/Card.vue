<template>
  <!-- Event line Card - Structure Preline -->
  <div v-if="type === 'event'" class="flex items-center p-4 bg-Light rounded-lg w-[292px] h-[59px]">
    <!-- Section Date -->
    <div class="flex flex-col justify-center items-center mr-4">
      <!-- Jour -->
      <h4 class="text-2xl font-bold text-primary-500">
        {{ day }}
      </h4>
      <!-- Mois et Année -->
      <p class="text-xs text-Grey-500">
        {{ formatDate }}
      </p>
    </div>

    <!-- Ligne verticale -->
    <div class="h-12 border-l border-Grey-300 mr-4"></div>

    <!-- Section Contenu -->
    <div class="flex-1">
      <!-- Tag -->
      <div class="mb-1">
        <AtomsTag 
          :variant="tag.variant || 'stroke'" 
          :color="tag.color || 'primary'" 
          :size="tag.size || 'md'"
        >
          {{ tag.text }}
        </AtomsTag>
      </div>
      
      <!-- Texte en dessous -->
      <p style="font-family: 'Roboto', sans-serif; font-weight: 400; font-size: 14px; color: #050D2E;">
        {{ contentText }}
      </p>
    </div>
  </div>

  <!-- Annonce Card - Structure Preline -->
  <div v-else-if="type === 'annonce'" class="rounded-lg w-[258px] min-h-[139px]">
    <!-- Image section -->
    <div class="h-[106px] bg-cover bg-center rounded-lg m-1" 
         :style="{ backgroundImage: `url(${imageUrl})` }">
    </div>
    
    <!-- Card body -->
    <div class="p-3">
      <div class="flex justify-between items-start gap-2">
        <!-- Titre -->
        <h6 class="flex-1 line-clamp-2" style="font-family: 'Nunito', sans-serif; font-weight: 700; font-size: 16px; color: #3A3B99; line-height: 1.2;">
          {{ title }}
        </h6>
        
        <!-- Type de contrat tag -->
        <div class="flex-shrink-0">
          <AtomsTag 
            variant="soft" 
            color="primary" 
            size="md"
          >
            {{ contractType }}
          </AtomsTag>
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

  <!-- Stats Card - Carte simple avec statistiques -->
  <div v-else-if="type === 'stats'" class="bg-Light rounded-lg p-4 w-[280px]">
    <!-- Tag statut avec indicateur -->
    <div class="mb-3">
      <AtomsTag 
        variant="soft" 
        color="primary" 
        size="md"
        status-color="green"
      >
        Publiée
      </AtomsTag>
    </div>
    
    <!-- Titre -->
    <h6 class="mb-4" style="font-family: 'Nunito', sans-serif; font-weight: 700; font-size: 16px; color: #3A3B99; line-height: 1.2;">
      {{ title }}
    </h6>
    
    <!-- Tags statistiques et total -->
    <div class="flex items-center justify-between">
      <div class="flex flex-wrap gap-2">
        <!-- Candidats traités -->
        <AtomsTag 
          variant="soft" 
          color="green" 
          size="md"
        >
          {{ candidatesProcessed }}
        </AtomsTag>
        
        <!-- Candidats en attente -->
        <AtomsTag 
          variant="soft" 
          color="secondary" 
          size="md"
        >
          {{ candidatesPending }}
        </AtomsTag>
        
        <!-- Candidats refusés -->
        <AtomsTag 
          variant="soft" 
          color="orange" 
          size="md"
        >
          {{ candidatesRejected }}
        </AtomsTag>
      </div>
      
      <!-- Total candidatures à droite -->
      <p class="ml-4" style="font-family: 'Roboto', sans-serif; font-weight: 400; font-size: 14px; color: #050D2E;">
        {{ candidatesTotal }} candidatures
      </p>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

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
      text: 'Tag',
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
    'Janv.', 'Févr.', 'Mars', 'Avr.', 'Mai', 'Juin',
    'Juil.', 'Août', 'Sept.', 'Oct.', 'Nov.', 'Déc.'
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
