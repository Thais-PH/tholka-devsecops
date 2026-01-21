<template>
  <!-- Event line Card - Structure Preline -->
  <div v-if="type === 'event'" class="flex items-center py-1 gap-4 w-full max-w-[292px] min-h-[59px] bg-white rounded-none">
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
    <div class="flex flex-col justify-center items-start gap-2 w-[203px] min-h-[51px]">
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
  <div v-else-if="type === 'annonce'" class="flex flex-col items-start p-0 min-w-[258px] max-w-[300px]">
    <!-- Image section -->
    <div class="flex flex-row justify-end items-start p-[5px] gap-[10px] w-full h-[135px] bg-cover bg-center rounded-lg flex-none order-0 flex-shrink-0"
     :style="{ backgroundImage: `url(${imageUrl})` }">
      <!-- Icon badge -->
      <div v-if="activeIcon" class="flex flex-row justify-center items-center p-[3px] w-[24px] h-[24px] bg-Orange-500 rounded-full">
        <LucidePlayCircle v-if="activeIcon === 'video'" :size="17" :stroke-width="1.5" class="text-white" />
        <LucideAudioLines v-else-if="activeIcon === 'sound'" :size="17" :stroke-width="1.5" class="text-white" />
        <LucideNewspaper v-else-if="activeIcon === 'article'" :size="17" :stroke-width="1.5" class="text-white" />
        <LucideList v-else-if="activeIcon === 'list'" :size="17" :stroke-width="1.5" class="text-white" />
      </div>
    </div>

    <!-- Content -->
    <div class="flex flex-col items-start px-[16px] pt-[16px] pb-0 gap-[8px] w-full">
      <!-- Frame avec titre et tag -->
      <div class="flex flex-row justify-between items-center p-0 gap-[8px] w-full h-[19px]">
        <!-- Titre -->
        <h6 class="font-nunito font-bold text-[16px] leading-[120%] text-primary-500 flex-1 overflow-hidden text-ellipsis whitespace-nowrap">
          {{ title }}
        </h6>

        <!-- Type de contrat tag -->
        <div v-if="contractType" class="flex-shrink-0">
          <AtomsTag
            variant="soft"
            color="primary"
            size="md"
            class="!px-1 !py-1 !text-[11px] !whitespace-nowrap"
          >
            {{ contractType }}
          </AtomsTag>
        </div>
      </div>

      <!-- Description -->
      <p v-if="description" class="w-full font-roboto font-normal text-[14px] leading-[16px] text-primary-500 flex-none order-2 overflow-hidden line-clamp-3">
        {{ description }}
      </p>
    </div>
  </div>

  <!-- Opportunité Card -->
  <div v-else-if="type === 'opportunite'" class="flex flex-col items-start p-0 w-[311px] bg-white overflow-hidden">
    <!-- Image section -->
    <div class="w-[311px] h-[160px] bg-cover bg-center flex-shrink-0 rounded-lg" 
         :style="{ backgroundImage: `url(${imageUrl})` }">
    </div>

    <!-- Content -->
    <div class="flex flex-col items-start p-[16px] gap-[8px] w-full">
      <!-- Tag et titre -->
      <div class="flex flex-col items-start gap-[8px] w-full">
        <!-- Tag -->
        <AtomsTag
          variant="soft"
          color="primary"
          size="md"
          class="!w-auto !h-[25px] !font-roboto !text-xs"
        >
          {{ contractType }}
        </AtomsTag>

        <!-- Title -->
        <h6 class="w-full font-nunito font-bold text-[16px] leading-[120%] text-primary-500">
          {{ title }}
        </h6>
      </div>

      <!-- Description -->
      <p class="w-full font-roboto font-normal text-[14px] leading-[16px] text-primary-500 overflow-hidden line-clamp-3">
        {{ description }}
      </p>
    </div>
  </div>

  <!-- Job Card - Structure Preline (Formation) -->
  <div v-else-if="type === 'job'" class="relative" :class="{ 'ml-20': orderNumber }">
    <!-- Numéro d'ordre - Calque arrière-plan, position fixe -->
    <div v-if="orderNumber" class="absolute font-nunito font-bold pointer-events-none" style="width: 90px; height: 165px; left: -71px; top: -4px; font-size: 150px; line-height: 110%; color: #F07F47; z-index: 0;">
      {{ orderNumber }}
    </div>

    <!-- Carte elle-même - Layout vertical -->
    <div class="relative flex flex-col items-center p-0 w-[311px] h-[259px] bg-white rounded-lg" style="isolation: isolate; z-index: 1;">
      <!-- Image section -->
      <div class="flex flex-row justify-end items-start p-[5px] gap-[10px] w-[311px] h-[135px] bg-cover bg-center rounded-t-lg flex-none order-1 self-stretch" 
           :style="{ backgroundImage: `url(${imageUrl})`, zIndex: 1 }">
        <!-- Icon badge -->
        <div v-if="activeIcon" class="flex flex-row justify-center items-center p-[3px] w-[24px] h-[24px] bg-Orange-500 rounded-full">
          <LucideYoutube v-if="activeIcon === 'video'" :size="17" :stroke-width="1.5" class="text-white" />
          <LucideVolume2 v-else-if="activeIcon === 'sound'" :size="17" :stroke-width="1.5" class="text-white" />
          <LucideFileText v-else-if="activeIcon === 'article'" :size="17" :stroke-width="1.5" class="text-white" />
          <LucideList v-else-if="activeIcon === 'list'" :size="17" :stroke-width="1.5" class="text-white" />
        </div>
      </div>

      <!-- Barre de progression (optionnelle, masquée par défaut) -->
      <div v-if="false" class="w-[307px] h-[9px] flex-none order-2" style="z-index: 2;">
        <!-- Fond de la barre -->
        <div class="absolute w-[307px] h-[9px] bg-secondary-300 rounded-full" style="left: 2px; top: 135px;"></div>
        <!-- Progression -->
        <div class="absolute h-[9px] bg-Orange-500 rounded-full" style="width: 116.76px; left: 2px; top: 135px;"></div>
      </div>

      <!-- Content -->
      <div class="flex flex-col items-start p-[16px] gap-[8px] w-[311px] h-[124px] flex-none order-3 self-stretch" style="z-index: 3;">
        <!-- First bloc -->
        <div class="flex flex-col items-start p-0 gap-[8px] w-[279px] h-[52px] flex-none order-0 self-stretch">
          <!-- Tag list -->
          <div class="flex flex-row items-start p-0 gap-[8px] w-[40px] h-[25px] flex-none order-0">
            <AtomsTag
              variant="soft"
              color="primary"
              size="md"
              class="!w-[40px] !h-[25px] !font-roboto !text-xs"
            >
              {{ contractType }}
            </AtomsTag>
          </div>

          <!-- Title -->
          <h6 class="w-[279px] h-[19px] font-nunito font-bold text-[16px] leading-[120%] text-primary-500 flex-none order-1 self-stretch">
            {{ title }}
          </h6>
        </div>

        <!-- Content/Description -->
        <p class="w-[279px] h-[32px] font-roboto font-normal text-[14px] leading-[16px] text-primary-500 flex-none order-2 self-stretch overflow-hidden">
          {{ description }}
        </p>
      </div>
    </div>
  </div>

  <!-- Profile Card - Structure horizontale -->
  <div v-else-if="type === 'profile'" class="flex flex-row justify-center items-start p-0 w-[302.75px] h-[203px] bg-white border border-primary-300 rounded-lg overflow-hidden">
    <!-- Image section à gauche -->
    <div 
      class="flex flex-row justify-end items-start p-[5px] gap-[10px] w-[151.38px] h-[203px] rounded-tl-lg flex-none order-0 self-stretch flex-grow relative"
      :style="{ 
        backgroundImage: `url(${imageUrl})`,
        backgroundSize: 'cover',
        backgroundPosition: imagePosition || 'center',
        backgroundRepeat: 'no-repeat'
      }"
    >
      <!-- DISC Icon overlay -->
      <img 
        v-if="discIcon"
        :src="getDiscIconPath"
        :alt="discIcon"
        class="w-[28px] h-[28px] absolute bottom-[8px] right-[8px]"
      />
    </div>

    <!-- Content à droite -->
    <div class="flex flex-col justify-between items-start p-[16px] gap-[8px] w-[151.38px] h-[203px] flex-none order-2 flex-grow">
      <!-- Frame principal -->
      <div class="flex flex-col items-start p-0 gap-[8px] w-full h-[105px] flex-none order-1 self-stretch">
        <!-- First bloc -->
        <div class="flex flex-col items-start p-0 gap-[8px] w-full h-[49px] flex-none order-0 self-stretch">
          <!-- Tag list -->
          <div class="flex flex-row items-start p-0 gap-[8px] h-[25px] flex-none order-0">
            <AtomsTag 
              variant="soft" 
              color="primary" 
              size="md"
              class="!h-[25px] !font-roboto !text-xs !px-2 !w-auto"
            >
              {{ contractType }}
            </AtomsTag>
          </div>

          <!-- Title -->
          <h6 class="w-full h-[16px] font-nunito font-bold text-[13.24px] leading-[120%] text-primary-500 flex-none order-1 self-stretch truncate">
            {{ title }}
          </h6>
        </div>

        <!-- Content/Description -->
        <p class="w-full h-[48px] font-roboto font-normal text-[14px] leading-[16px] text-primary-500 flex-none order-1 self-stretch overflow-hidden line-clamp-3">
          {{ description }}
        </p>
      </div>

      <!-- Button "Voir le profil" -->
      <div v-if="showProfileLink" class="flex flex-row items-center gap-[4px] flex-none order-2 w-full">
        <AtomsButton variant="tertiary" size="sm" justify="start" class="!text-sm !p-0 !h-auto whitespace-nowrap">
          Voir le profil
          <template #icon-right>
            <LucideChevronRight :size="17" :stroke-width="1" />
          </template>
        </AtomsButton>
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
import iconDiscRed from '~/assets/icons/icon-disc-red.svg'
import iconDiscYellow from '~/assets/icons/icon-disc-yellow.svg'
import iconDiscGreen from '~/assets/icons/icon-disc-green.svg'
import iconDiscBlue from '~/assets/icons/icon-disc-blue.svg'

const props = defineProps({
  type: {
    type: String,
    required: true,
    validator: (v) => ['event', 'annonce', 'job', 'profile', 'stats', 'opportunite'].includes(v)
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
    required: false
  },
  imageUrl: {
    type: String,
    required: false
  },
  hasVideo: {
    type: Boolean,
    default: false
  },
  hasSound: {
    type: Boolean,
    default: false
  },
  hasArticle: {
    type: Boolean,
    default: false
  },
  hasList: {
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
  },
  // Props pour positionner l'image
  imagePosition: {
    type: String,
    required: false,
    default: 'center'
  },
  // Props pour l'icône DISC
  discIcon: {
    type: String,
    required: false,
    validator: (v) => !v || ['D', 'I', 'S', 'C'].includes(v)
  },
  // Props pour afficher/masquer le lien "Voir le profil"
  showProfileLink: {
    type: Boolean,
    required: false,
    default: true
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

// Computed pour déterminer quel icône afficher
const activeIcon = computed(() => {
  if (props.hasVideo) return 'video'
  if (props.hasSound) return 'sound'
  if (props.hasArticle) return 'article'
  if (props.hasList) return 'list'
  return null
})

// Computed pour mapper le profil DISC à la couleur de l'icône
const discIconColor = computed(() => {
  const colorMap = {
    'D': 'red',
    'I': 'yellow',
    'S': 'green',
    'C': 'blue'
  }
  return colorMap[props.discIcon] || 'blue'
})

// Map des icônes DISC
const discIcons = {
  'red': iconDiscRed,
  'yellow': iconDiscYellow,
  'green': iconDiscGreen,
  'blue': iconDiscBlue
}

// Computed pour récupérer le chemin de l'icône DISC
const getDiscIconPath = computed(() => {
  if (!props.discIcon) return ''
  const colorName = discIconColor.value
  return discIcons[colorName] || discIcons['blue']
})
</script>

<style scoped>
.font-nunito {
  font-family: 'Nunito', sans-serif;
}
</style>
