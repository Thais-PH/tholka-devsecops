<template>
  <div class="flex flex-col w-full min-h-screen bg-secondary-300">
    <!-- Navbar -->
    <OrganismsNavbar
      user-type="rh"
      :is-sidebar-open="isSidebarOpen"
      :wide-breakpoint="true"
      @toggle-sidebar="isSidebarOpen = !isSidebarOpen"
    />

    <!-- Main Layout -->
    <div class="flex flex-1 pt-[82.73px]">
      <!-- Sidebar RH -->
      <OrganismsSidebarRH
        active-item="equipe"
        :is-open="isSidebarOpen"
        :wide-breakpoint="true"
        @close="isSidebarOpen = false"
      />

      <!-- Content Area -->
      <div class="flex-1 ml-0 3xl:ml-[300px] overflow-y-auto">
        <div class="flex flex-col items-start p-6 3xl:px-[52px] 3xl:py-[32px] gap-5 w-full">
          
          <!-- Header avec Alerte IA + Boutons d'action -->
          <div class="flex flex-col lg:flex-row justify-end items-center gap-5 w-full">
            <!-- Alerte IA Soft -->
            <Transition name="alert-fade">
              <AtomsAlert
                v-if="!alertDismissed"
                variant="ia-soft"
                message="Risque de burn-out"
                class="flex-1"
                @dismiss="alertDismissed = true"
              >
                <template #action>
                  <button class="ia-dismiss-btn" @click="alertDismissed = true">
                    En savoir plus
                  </button>
                </template>
              </AtomsAlert>
            </Transition>

            <!-- Boutons d'action -->
            <div class="flex flex-row items-center gap-2">
              <AtomsButton
                variant="primary"
                size="lg"
                icon-only
              >
                <template #icon-left>
                  <LucidePencil :size="24" :stroke-width="1" />
                </template>
              </AtomsButton>
              <AtomsButton
                variant="primary"
                size="lg"
                icon-only
              >
                <template #icon-left>
                  <LucideSend :size="24" :stroke-width="1" />
                </template>
              </AtomsButton>
            </div>
          </div>

          <!-- Bento Grid -->
          <div class="flex flex-col gap-5 w-full">
            
            <!-- PREMIÈRE LIGNE : Info Collaborateur + Documents (même hauteur) -->
            <div class="flex flex-col lg:flex-row gap-5 w-full lg:items-stretch">
              
              <!-- Bloc Information Collaborateur -->
              <div class="flex flex-col lg:flex-row items-center p-5 gap-5 lg:gap-8 bg-white rounded-lg w-full lg:w-[66%]">
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
                      <h5 class="text-h5 font-sans font-bold text-primary-500">{{ collaborateur.name }}</h5>
                      <p class="text-[18px] leading-[1.875rem] font-sans font-bold text-primary-900">{{ collaborateur.position }}</p>
                    </div>
                    <AtomsTag variant="soft" color="primary" size="md">
                      {{ collaborateur.department }}
                    </AtomsTag>
                  </div>
                  
                  <!-- Info secondaire -->
                  <div class="flex flex-col justify-center items-start gap-[6px]">
                    <div class="flex items-center gap-2.5">
                      <LucideMapPin :size="20" :stroke-width="1" class="text-primary-500" />
                      <span class="text-base font-roboto text-primary-900">{{ collaborateur.location }}</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                      <LucideCalendarRange :size="20" :stroke-width="1" class="text-primary-500" />
                      <span class="text-base font-roboto text-primary-900">En poste depuis le {{ collaborateur.startDate }}</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                      <LucideEuro :size="20" :stroke-width="1" class="text-primary-500" />
                      <span class="text-base font-roboto text-primary-900">Salaire annuel : {{ collaborateur.salary }}</span>
                    </div>
                    <!-- Badge IA -->
                    <AtomsTag variant="soft" color="purple" size="md">
                      +2% par rapport au marché
                    </AtomsTag>
                  </div>
                </div>
              </div>

              <!-- Documents -->
              <div class="w-full lg:w-[34%]">
                <OrganismsDocumentsBlock
                  title="Derniers documents"
                  :documents="documents"
                  flex-gap
                  class="h-full documents-block"
                />
              </div>
            </div>

            <!-- RESTE DU CONTENU : 2 colonnes -->
            <div class="flex flex-col lg:flex-row gap-5 w-full lg:items-stretch">
              
              <!-- COLONNE GAUCHE (~66%) -->
              <div class="flex flex-col gap-5 w-full lg:w-[66%]">

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
              <div class="flex flex-col items-start p-4 lg:px-5 lg:py-4 bg-white rounded-lg w-full">
                <!-- Header -->
                <div class="flex justify-between items-center w-full">
                  <h5 class="text-h5 font-sans font-bold text-primary-500">Poste souhaité : {{ ambition.targetPosition }}</h5>
                </div>

                <!-- Parcours de montée en compétences -->
                <div class="flex flex-col items-start w-full">
                  <h6 class="text-[18px] font-sans font-bold text-primary-900 mt-6">Parcours de montée en compétences</h6>
                  
                  <!-- Stepper avec marges 16px top/bottom -->
                  <div class="w-full overflow-x-auto my-4">
                    <MoleculesStepper
                      :steps="careerSteps"
                      :current-step="currentCareerStep"
                      class="min-w-[600px]"
                    />
                  </div>

                  <!-- Recommandation IA avec marges 16px top/bottom, 8px left/right -->
                  <div class="flex flex-col items-start py-4 px-2 w-full rounded-lg">
                    <AtomsTag variant="soft" color="purple" size="lg">
                      {{ ambition.iaRecommendation.badge }}
                    </AtomsTag>
                    <p class="text-base font-roboto text-primary-900 mt-2">
                      {{ ambition.iaRecommendation.text }}
                    </p>
                  </div>
                </div>
              </div>

              <!-- 4 Blocs Statistiques -->
              <div class="flex flex-col lg:flex-row gap-5 w-full">
                <!-- Congés non pris -->
                <div class="flex-1 flex flex-col justify-center items-center p-4 bg-white rounded-lg min-h-[255px]">
                  <div class="flex flex-col items-center">
                    <span class="text-h2 font-sans font-bold text-primary-500">{{ stats.congesNonPris }}</span>
                    <p class="text-base font-roboto text-primary-500 text-center">Jours de congés<br>non pris</p>
                  </div>
                </div>

                <!-- Heures supplémentaires -->
                <div class="flex-1 flex flex-col justify-center items-center p-4 bg-white rounded-lg min-h-[255px]">
                  <div class="flex flex-col items-center">
                    <span class="text-h2 font-sans font-bold text-primary-500">{{ stats.heuresSupp }}</span>
                    <p class="text-base font-roboto text-primary-500 text-center">Supplémentaires<br>par semaine</p>
                  </div>
                </div>

                <!-- Absentéisme -->
                <div class="flex-1 flex flex-col justify-center items-center p-4 bg-white rounded-lg min-h-[255px]">
                  <div class="flex flex-col items-center">
                    <span class="text-h2 font-sans font-bold text-primary-500">{{ stats.absenteisme }}</span>
                    <p class="text-base font-roboto text-primary-500 text-center">Jours<br>d'absentéisme</p>
                  </div>
                </div>

                <!-- Bien-être -->
                <div class="flex-1 flex flex-col justify-center items-center p-4 gap-4 bg-white rounded-lg min-h-[255px]">
                  <div class="flex flex-col items-center gap-4">
                    <!-- Stars rating -->
                    <div class="flex flex-row items-center">
                      <LucideStar
                        v-for="i in 5"
                        :key="i"
                        :size="24"
                        :stroke-width="1.5"
                        :color="i <= stats.bienEtre ? '#3A3B99' : 'rgba(58, 59, 153, 0.3)'"
                        fill="none"
                      />
                    </div>
                    <p class="text-base font-roboto text-primary-500 text-center">Résultats des 3<br>dernières enquêtes<br>bien-être</p>
                  </div>
                </div>
              </div>
            </div>

            <!-- COLONNE DROITE (~34%) -->
            <div class="flex flex-col gap-5 w-full lg:w-[34%]">
              
              <!-- Bloc Profil DISC -->
              <div class="flex flex-col justify-between items-center py-[20px] px-[23px] gap-5 bg-white rounded-lg w-full flex-1">
                <!-- Header -->
                <div class="flex justify-between items-center w-full">
                  <div class="flex items-center gap-2">
                    <h5 class="text-h5 font-sans font-bold text-primary-500">Profil DISC</h5>
                    <LucideInfo :size="24" :stroke-width="1" class="text-primary-500 cursor-pointer" />
                  </div>
                  <LucideBarChart4 :size="24" :stroke-width="1" class="text-Orange-500" />
                </div>

                <!-- Graph DISC -->
                <div class="flex flex-col items-center gap-2">
                  <div class="w-full h-[350px] mb-[52px]">
                    <MoleculesBarChart
                      :series="discData.series"
                      :labels="discData.labels"
                      height="384"
                      width="334"
                      column-width="40px"
                      y-axis-font-size="19px"
                      x-axis-font-size="22px"
                      data-labels-font-size="17px"
                      :x-axis-label-offset="10"
                    />
                  </div>
                  <p class="text-[17px] font-roboto italic text-primary-700 text-center">
                    Date du test : {{ discData.testDate }}
                  </p>
                </div>

                <!-- Boutons -->
                <div class="flex flex-col items-start gap-2 w-full">
                  <AtomsButton
                    variant="primary"
                    size="md"
                    class="w-full"
                  >
                    Inviter à repasser le test
                  </AtomsButton>
                  <AtomsButton
                    variant="secondary"
                    size="md"
                    class="w-full"
                    @click="showDiscModal = true"
                  >
                    Consulter les clés de lecture
                  </AtomsButton>
                </div>
              </div>
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
import { useRoute } from 'vue-router'
import {
  MapPin as LucideMapPin,
  CalendarRange as LucideCalendarRange,
  Euro as LucideEuro,
  BarChart4 as LucideBarChart4,
  Pencil as LucidePencil,
  Send as LucideSend,
  Star as LucideStar,
  Info as LucideInfo
} from 'lucide-vue-next'

const route = useRoute()
const collaborateurId = route.params.id

useHead({
  title: 'Passeport de compétences - Thomas Lemoine - Tholka RH',
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

// Données du collaborateur (à remplacer par fetch API)
const collaborateur = {
  id: collaborateurId,
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
  iaRecommendation: {
    badge: 'Sources : Passeport Compétences ; Référentiel Métier ; Historique Mobilité',
    text: 'Thomas valide 92% des prérequis techniques. Pour sécuriser son passage au poste de Responsable, Lia préconise de prioriser le développement du leadership et de la gestion budgétaire via le plan d\'action ci-dessus.'
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

// Statistiques RH
const stats = {
  congesNonPris: 12,
  heuresSupp: '8h',
  absenteisme: 0,
  bienEtre: 2  // Nombre d'étoiles pleines sur 5
}

// Documents
const documents = [
  { label: 'Résumé du dernier entretien individuel', url: '#' },
  { label: 'Objectifs annuels', url: '#' }
]

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

/* Override padding vertical et taille texte des boutons dans DocumentsBlock */
:deep(.documents-block button) {
  padding-top: 8px !important;
  padding-bottom: 8px !important;
  font-size: 16px !important;
}

/* Override gap entre le titre et la liste des documents */
:deep(.documents-block) {
  gap: 16px !important;
}

/* Bouton custom pour alerte IA */
.ia-dismiss-btn {
  box-sizing: border-box;
  display: flex;
  flex-direction: row;
  justify-content: center;
  align-items: center;
  padding: 4px 8px;
  gap: 4px;
  min-width: 103px;
  height: 26px;
  border: 1px solid #6420BE;
  border-radius: 8px;
  background: transparent;
  font-family: 'Roboto', sans-serif;
  font-style: normal;
  font-weight: 400;
  font-size: 14px;
  line-height: 130%;
  text-align: center;
  color: #6420BE;
  cursor: pointer;
  transition: all 0.2s ease;
}

.ia-dismiss-btn:hover {
  background: #FFFFFF;
  color: #6420BE;
  border-color: #FFFFFF;
}
</style>
