<template>
  <div class="flex flex-col w-full min-h-screen bg-secondary-300">
    <!-- Navbar -->
    <OrganismsNavbar
      user-type="collab"
      :is-sidebar-open="isSidebarOpen"
      :wide-breakpoint="true"
      @toggle-sidebar="isSidebarOpen = !isSidebarOpen"
    />

    <!-- Main Layout -->
    <div class="flex flex-1 pt-[82.73px]">
      <!-- Sidebar Collaborateur -->
      <OrganismsSidebarCollaborateur
        active-item="passeport"
        :is-open="isSidebarOpen"
        :wide-breakpoint="true"
        @close="isSidebarOpen = false"
      />

      <!-- Content Area -->
      <div class="flex-1 ml-0 3xl:ml-[300px] overflow-y-auto">
        <div class="flex flex-col items-start p-6 3xl:px-[52px] 3xl:py-[32px] gap-5 w-full">
          
          <!-- Alerte IA Soft (dismissible) -->
          <Transition name="alert-fade">
            <AtomsAlert
              v-if="!alertDismissed"
              variant="ia-soft"
              message="Il vous reste moins de 10 jours pour poser vos congés avant la clôture officielle de la période"
              @dismiss="alertDismissed = true"
            />
          </Transition>

          <!-- Bento Grid -->
          <div class="flex flex-col lg:flex-row gap-5 w-full lg:items-stretch">
            
            <!-- COLONNE GAUCHE (~66%) -->
            <div class="flex flex-col gap-5 w-full lg:w-[66%]">
              
              <!-- Bloc Information -->
              <div class="flex flex-col lg:flex-row items-center p-5 gap-5 lg:gap-8 bg-white rounded-lg w-full">
                <!-- Photo -->
                <div class="flex-shrink-0 w-[116px] h-[94px] rounded-lg overflow-hidden bg-primary-300">
                  <img 
                    src="~/assets/img/collab.png" 
                    alt="Photo de profil"
                    class="w-full h-full object-cover"
                  />
                </div>
                
                <!-- Détails -->
                <div class="flex flex-col lg:flex-row items-center gap-4 flex-1 max-w-[615px]">
                  <!-- Info principale -->
                  <div class="flex flex-col justify-center items-center lg:items-start gap-1 flex-1">
                    <div class="text-center lg:text-left">
                      <h5 class="text-h5 font-sans font-bold text-primary-500">{{ profileInfo.name }}</h5>
                      <p class="text-[18px] leading-[1.875rem] font-sans font-bold text-primary-900">{{ profileInfo.position }}</p>
                    </div>
                    <AtomsTag variant="soft" color="primary" size="md">
                      {{ profileInfo.department }}
                    </AtomsTag>
                  </div>
                  
                  <!-- Info secondaire -->
                  <div class="flex flex-col justify-center items-start gap-[6px]">
                    <div class="flex items-center gap-2.5">
                      <LucideMapPin :size="20" :stroke-width="1" class="text-primary-500" />
                      <span class="text-base font-roboto text-primary-900">{{ profileInfo.location }}</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                      <LucideCalendarRange :size="20" :stroke-width="1" class="text-primary-500" />
                      <span class="text-base font-roboto text-primary-900">En poste depuis le {{ profileInfo.startDate }}</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                      <LucideEuro :size="20" :stroke-width="1" class="text-primary-500" />
                      <span class="text-base font-roboto text-primary-900">Salaire annuel : {{ profileInfo.salary }}</span>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Compétences (2 blocs côte à côte) -->
              <div class="flex flex-col lg:flex-row gap-5 w-full">
                <MoleculesTagsGroupBlock
                  class="flex-1"
                  title="Compétences comportementales"
                  :tags="competencesComportementales"
                  :max-visible="3"
                  tag-variant="soft"
                  tag-color="green"
                />
                <MoleculesTagsGroupBlock
                  class="flex-1"
                  title="Compétences techniques"
                  :tags="competencesTechniques"
                  :max-visible="3"
                  tag-variant="soft"
                  tag-color="green"
                />
              </div>

              <!-- Bloc Ambition & Carrière -->
              <div class="flex flex-col items-center p-4 lg:px-5 lg:py-4 gap-4 bg-white rounded-lg w-full">
                <!-- Header -->
                <div class="flex justify-between items-center w-full">
                  <h5 class="text-h5 font-sans font-bold text-primary-500">Ambition & carrière</h5>
                  <LucideRocket :size="24" :stroke-width="1" class="text-Orange-500" />
                </div>

                <!-- Poste souhaité -->
                <div class="flex flex-col items-start gap-6 w-full">
                  <div class="flex flex-row items-center gap-1">
                    <span class="text-[18px] font-sans font-bold text-primary-900">Poste souhaité :</span>
                    <span class="text-base font-roboto text-primary-900">{{ ambition.targetPosition }}</span>
                  </div>

                  <!-- Compétences à renforcer -->
                  <div class="flex flex-col items-start gap-4 w-full">
                    <h6 class="text-[18px] font-sans font-bold text-primary-500">Compétences à renforcer</h6>
                    <div class="flex flex-col gap-2 w-full">
                      <div class="flex flex-row flex-wrap items-center gap-2">
                        <AtomsTag
                          v-for="skill in ambition.skillsToImprove"
                          :key="skill"
                          variant="stroke"
                          color="primary"
                          size="md"
                        >
                          {{ skill }}
                        </AtomsTag>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Recommandation IA -->
                <div class="flex flex-col items-start py-4 gap-2 w-full rounded-lg mb-[58px]">
                  <AtomsTag variant="soft" color="purple" size="md">
                    {{ ambition.iaRecommendation.badge }}
                  </AtomsTag>
                  <p class="text-sm font-roboto text-primary-900">
                    {{ ambition.iaRecommendation.text }}
                  </p>
                </div>
              </div>

              <!-- Bloc Prochaines étapes -->
              <div class="flex flex-col items-start p-4 lg:px-5 lg:py-4 gap-4 bg-white rounded-lg w-full">
                <!-- Header -->
                <div class="flex justify-between items-center w-full">
                  <h5 class="text-h5 font-sans font-bold text-primary-500">Prochaines étapes de carrière</h5>
                  <LucideTrendingUp :size="24" :stroke-width="1" class="text-Orange-500" />
                </div>

                <!-- Description -->
                <p class="text-base font-roboto text-primary-900">
                  Pour atteindre le poste de {{ ambition.targetPosition }}, voici les {{ careerSteps.length }} prochaines étapes :
                </p>

                <!-- Stepper -->
                <div class="w-full overflow-x-auto py-[17px] mx-auto">
                  <MoleculesStepper
                    :steps="careerSteps"
                    :current-step="currentCareerStep"
                    class="min-w-[600px]"
                  />
                </div>
              </div>
            </div>

            <!-- COLONNE DROITE (~34%) -->
            <div class="flex flex-col gap-5 w-full lg:w-[34%]">
              
              <!-- Documents -->
              <OrganismsDocumentsBlock
                title="Derniers documents"
                :documents="documents"
                flex-gap
              />

              <!-- Bloc Profil Protecteur -->
              <div class="flex flex-col items-start p-5 gap-4 bg-Green-500 rounded-lg w-full">
                <h5 class="text-h5 font-sans font-bold text-Light">{{ discProfile.title }}</h5>
                <p class="text-sm font-roboto text-Light mb-[15px]">
                  {{ discProfile.description }}
                </p>
              </div>

              <!-- Bloc Profil DISC -->
              <div class="flex flex-col justify-between items-center py-[20px] px-[24px] gap-6 bg-white rounded-lg w-full flex-1">
                <!-- Header -->
                <div class="flex justify-between items-center w-full">
                  <h5 class="text-h5 font-sans font-bold text-primary-500">Profil DISC</h5>
                  <LucideBarChart4 :size="24" :stroke-width="1" class="text-Orange-500" />
                </div>

                <!-- Graph DISC -->
                <div class="flex flex-col items-center gap-4">
                  <div class="w-full h-[300px] lg:h-[350px] mb-[52px]">
                    <MoleculesBarChart
                      :series="discData.series"
                      :labels="discData.labels"
                      height="365"
                      width="295"
                      column-width="36px"
                      y-axis-font-size="16px"
                      x-axis-font-size="20px"
                      data-labels-font-size="14px"
                      :x-axis-label-offset="10"
                    />

                  </div>
                  <p class="text-[17px] font-roboto italic text-primary-700 text-center">
                    Date du test : {{ discData.testDate }}
                  </p>
                </div>

                <!-- Button -->
                <AtomsButton
                  variant="primary"
                  size="md"
                  class="w-full"
                  @click="showDiscModal = true"
                >
                  Consulter les clés de lecture
                  <template #icon-right>
                    <LucideChevronRight :size="20" :stroke-width="1" />
                  </template>
                </AtomsButton>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Profil DISC -->
    <MoleculesModalProfil
      :is-open="showDiscModal"
      variant="large"
      :profile-type="getDominantProfile()"
      @close="showDiscModal = false"
    />
  </div>
</template>

<script setup>
import { ref } from 'vue'
import {
  MapPin as LucideMapPin,
  CalendarRange as LucideCalendarRange,
  Euro as LucideEuro,
  Rocket as LucideRocket,
  TrendingUp as LucideTrendingUp,
  BarChart4 as LucideBarChart4,
  ChevronRight as LucideChevronRight
} from 'lucide-vue-next'

useHead({
  title: 'Passeport de compétences - Tholka',
})

// État de la sidebar mobile
const isSidebarOpen = ref(false)

// État de l'alerte IA
const alertDismissed = ref(false)

// État de la modal DISC
const showDiscModal = ref(false)

// Calcul du profil DISC dominant
const getDominantProfile = () => {
  const scores = discData.series
  const maxIndex = scores.indexOf(Math.max(...scores))
  const profiles = ['D', 'I', 'S', 'C']
  return profiles[maxIndex]
}

// Données du profil
const profileInfo = {
  name: 'Thomas Lemoine',
  position: 'Chargé de missions marketing',
  department: 'CDI',
  location: 'Agence de Nantes',
  startDate: '10/09/2022',
  salary: '35 000€'
}

// Compétences comportementales
const competencesComportementales = [
  'Écoute active',
  'Patience',
  'Méthodique',
  'Empathie',
  'Organisation',
  'Créativité',
  'Rigueur',
  'Travail en équipe',
  'Capacité à rassurer',
  'Fiabilité'
]

// Compétences techniques
const competencesTechniques = [
  'Gestion de projet',
  'Suivi et reporting',
  'Outils CRM',
  'SEO/SEA',
  'Gestion des RS',
  'Email marketing',
  'Maîtrise de la suite Adobe'
]

// Données Ambition
const ambition = {
  targetPosition: 'Responsable marketing',
  skillsToImprove: [
    'Gestion de projet',
    'Suivi et reporting',
    'Communication',
    'SEO/SEA',
    'Gestion des RS',
    'Outils CRM',
    'Email marketing',
    'Maîtrise de la suite Adobe'
  ],
  iaRecommendation: {
    badge: 'Sources : Passeport Compétences ; Référentiel Métier ; Historique Mobilité',
    text: 'Vous validez 92% des prérequis techniques. Pour sécuriser son passage au poste de Responsable, Lia préconise de prioriser le développement du leadership et de la gestion budgétaire via le plan d\'action ci-dessous.'
  }
}

// Étapes de carrière
const careerSteps = [
  { label: 'Expertise Data & KPI' },
  { label: 'Leadership et management' },
  { label: 'Stratégie budgétaire' },
  { label: 'Validation mobilité' }
]
const currentCareerStep = 0

// Documents
const documents = [
  { label: 'Résumé du dernier entretien individuel', url: '#' },
  { label: 'Objectifs annuels', url: '#' }
]

// Profil DISC
const discProfile = {
  title: 'Profil Protecteur',
  description: 'Le Protecteur est un pilier fiable et persévérant, engagé à défendre ses valeurs tout en assurant stabilité et équilibre au sein de son équipe.'
}

// Données du graphique DISC
const discData = {
  series: [8, 25, 78, 65],
  labels: ['D', 'I', 'S', 'C'],
  testDate: '07/10/2024'
}
</script>

<style scoped>
/* Transition pour l'alerte */
.alert-fade-enter-active,
.alert-fade-leave-active {
  transition: all 0.3s ease;
}

.alert-fade-enter-from,
.alert-fade-leave-to {
  opacity: 0;
  transform: translateY(-10px);
}

/* Override couleur texte des tags compétences */
:deep(.tag-text-green) {
  color: theme('colors.Green-700') !important;
}
</style>
