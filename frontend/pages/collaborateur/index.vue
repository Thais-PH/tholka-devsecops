<template>
  <div class="flex flex-col w-full min-h-screen bg-secondary-300">
    <!-- Header -->
    <OrganismsNavbar />

    <!-- Content avec Sidebar -->
    <div class="flex w-full" style="margin-top: 82.73px;">
      <!-- Sidebar -->
      <OrganismsSidebarCollaborateur active-item="accueil" />

      <!-- Main Content - Conteneur avec max-width basé sur Figma -->
      <div class="flex flex-col items-start py-8 px-[3%] gap-5 flex-1 ml-[300px] w-full max-w-[1428px]">
        <!-- Menu secondaire -->
        <div class="flex flex-col items-start p-0 gap-4 w-full">
          <MoleculesSecondaryMenu
            :items="secondaryMenuItems"
            :default-active-index="activeTabIndex"
            @change="handleMenuChange"
          />
        </div>

        <!-- Onglet Onboarding -->
        <div v-if="activeTab === 'onboarding'" class="flex flex-col flex-wrap items-start gap-5 w-full">
          <!-- Première ligne - Flex row wrap -->
          <div class="flex flex-row flex-wrap items-start gap-5 w-full">
            <!-- Bloc Push Onboarding - 61% de largeur (873/1428) -->
            <div class="flex-shrink-0" style="width: calc(61.1% - 10px);">
              <div class="flex flex-row items-stretch w-full h-[441px] bg-white rounded-lg overflow-hidden">
                <!-- Left bloc - Checklist - 453px fixe -->
                <div class="flex flex-col justify-between items-end py-5 px-6 gap-9 w-[453px] flex-shrink-0">
                  <div class="flex flex-col items-start gap-4 w-full">
                    <!-- Titre -->
                    <div class="flex flex-row justify-between items-center px-6 gap-4 w-full h-[29px]">
                      <h5 class="font-nunito font-bold text-2xl leading-[120%] text-primary-500">Onboarding</h5>
                      <LucideRocket :size="24" :stroke-width="1" class="text-Orange-500" />
                    </div>

                    <!-- Checklist - 240px de hauteur -->
                    <div class="flex flex-col justify-end items-start w-full h-[240px]">
                      <!-- Item 1 - Checked -->
                      <div class="flex flex-col items-start py-1 pl-6 gap-2.5 w-full h-[48px] border-b border-primary-500/30">
                        <div class="flex flex-row items-center w-full h-[40px]">
                          <AtomsCheckbox
                            v-model="onboardingChecklist.item1"
                            label="Visite des bureaux"
                            :done="true"
                          />
                        </div>
                      </div>

                      <!-- Item 2 - Checked -->
                      <div class="flex flex-col items-start py-1 pl-6 gap-2.5 w-full h-[48px] border-b border-primary-500/30">
                        <div class="flex flex-row items-center w-full h-[40px]">
                          <AtomsCheckbox
                            v-model="onboardingChecklist.item2"
                            label="Déjeuner d'équipe"
                            :done="true"
                          />
                        </div>
                      </div>

                      <!-- Item 3 - Unchecked -->
                      <div class="flex flex-col items-start py-1 pl-6 gap-2.5 w-full h-[48px] border-b border-primary-500/30">
                        <div class="flex flex-row items-center w-full h-[40px]">
                          <AtomsCheckbox
                            v-model="onboardingChecklist.item3"
                            label="Participer à la réunion d'équipe mensuelle"
                          />
                        </div>
                      </div>

                      <!-- Item 4 - Unchecked -->
                      <div class="flex flex-col items-start py-1 pl-6 gap-2.5 w-full h-[48px] border-b border-primary-500/30">
                        <div class="flex flex-row items-center w-full h-[40px]">
                          <AtomsCheckbox
                            v-model="onboardingChecklist.item4"
                            label="Faire le point avec son manager"
                          />
                        </div>
                      </div>

                      <!-- Item 5 - Unchecked -->
                      <div class="flex flex-col items-start py-1 pl-6 gap-2.5 w-full h-[48px] border-b border-primary-500/30">
                        <div class="flex flex-row items-center w-full h-[40px]">
                          <AtomsCheckbox
                            v-model="onboardingChecklist.item5"
                            label="Mettre à jour le passeport de compétences"
                          />
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Button -->
                  <AtomsButton variant="tertiary" size="md" justify="start" class="w-auto">
                    Poursuivre mon parcours
                    <template #icon-right>
                      <LucideChevronRight :size="20" :stroke-width="1" />
                    </template>
                  </AtomsButton>
                </div>

                <!-- Right bloc - Image - Reste de l'espace -->
                <div class="relative w-full h-[441px] overflow-hidden flex-1">
                  <img 
                    src="~/assets/img/onboarding_collab.jpg" 
                    alt="Onboarding" 
                    class="w-full h-full object-cover"
                  />
                </div>
              </div>
            </div>

            <!-- Colonne droite - 30% (428/1428) -->
            <div class="flex flex-col gap-5 flex-1 min-w-[426px] h-[441px]">
              <!-- Chart Progression -->
              <div class="flex flex-col items-end py-5 px-5 w-full flex-1 bg-white rounded-lg">
                <!-- Title -->
                <div class="flex flex-col items-start gap-1 w-full">
                  <div class="flex flex-row justify-between items-center w-full h-[29px]">
                    <h5 class="font-nunito font-bold text-2xl leading-[120%] text-primary-500">Progression</h5>
                    <LucideTrendingUp :size="24" :stroke-width="1" class="text-Orange-500" />
                  </div>
                </div>

                <!-- Chart -->
                <div class="flex flex-row justify-center items-center w-full flex-1">
                  <ClientOnly>
                    <MoleculesProgressRingChart
                      :percentage="68"
                      center-value="68%"
                      center-label=""
                      :stroke-width="22"
                    />
                  </ClientOnly>
                </div>
              </div>

              <!-- Contact de référence -->
              <div class="w-full flex-shrink-0">
                <OrganismsContactsBlock
                  title="Contact de référence"
                  :contacts="contacts"
                />
              </div>
            </div>
          </div>

          <!-- Bloc Opportunités internes - 100% largeur -->
          <div class="flex flex-col items-start py-5 px-6 gap-10 w-full bg-white rounded-lg">
            <!-- Header -->
            <div class="flex flex-col items-start gap-2 w-full">
              <div class="flex flex-row justify-between items-center w-full h-[29px]">
                <h5 class="font-nunito font-bold text-2xl leading-[120%] text-primary-500">Ressources pour débuter dans les meilleures conditions</h5>
              </div>

              <!-- Tag IA -->
              <div class="w-full h-[36px]">
                <AtomsTag variant="soft" color="purple" size="md" class="!h-[36px] !px-2">
                  <template #icon-left>
                    <LucideSparkles :size="20" :stroke-width="1" />
                  </template>
                  <span class="text-sm leading-[130%]">61% des nouveaux collaborateurs qui ont consulté le Guide de l'entreprise se sentent pleinement opérationnels dès la première semaine</span>
                </AtomsTag>
              </div>
            </div>

            <!-- Cards -->
            <div class="flex flex-row items-start gap-6 w-full overflow-x-auto hide-scrollbar">
              <div
                v-for="(annonce, index) in annoncesInternes"
                :key="index"
                class="flex-shrink-0"
              >
                <MoleculesCard
                  type="annonce"
                  :title="annonce.title"
                  :contract-type="annonce.contractType"
                  :image-url="annonce.imageUrl"
                  :description="annonce.description"
                  :has-video="annonce.hasVideo"
                  :has-article="annonce.hasArticle"
                  :has-list="annonce.hasList"
                  :has-sound="annonce.hasSound"
                />
              </div>
            </div>
          </div>
        </div>

        <!-- Onglet Général -->
        <div v-if="activeTab === 'general'" class="grid grid-cols-12 gap-5 w-full">
          <!-- Colonne gauche - 8 colonnes sur 12 -->
          <div class="col-span-8 flex flex-col gap-[20px]">
            <!-- Accès rapides -->
            <OrganismsQuickAccessBlock
              title="Accès rapides"
              :quick-access="quickAccessItems"
            />

            <!-- Documents & Contacts - Grid interne -->
            <div class="grid grid-cols-2 gap-[20px]">
              <OrganismsDocumentsBlock
                title="Derniers documents"
                :documents="documents"
              />
              <OrganismsContactsBlock
                title="Contact de référence"
                :contacts="contacts"
              />
            </div>

            <!-- Activité & Objectifs du mois -->
            <div class="flex flex-col justify-between items-start py-[20px] px-[23px] gap-[20px] w-full flex-1 bg-white rounded-lg">
              <div class="flex flex-col items-start p-0 gap-[8px] w-full">
                <div class="flex flex-row justify-between items-center p-0 gap-[10px] w-full">
                  <h5 class="font-nunito font-bold text-2xl leading-[120%] text-primary-500">Activité & Objectifs du mois</h5>
                  <LucideBarChart4 :size="24" :stroke-width="1" class="text-Orange-500" />
                </div>
                
                <AtomsTag variant="soft" color="purple" size="md" class="!w-auto !max-w-full">
                  Vous progressez sur 2 compétences clés ce mois-ci
                </AtomsTag>
              </div>

              <div class="flex items-center justify-center w-full flex-1">
                <MoleculesMultipleBarChart
                  :series="[
                    { name: 'Income', data: [62, 80, 50, 55] },
                    { name: 'Outcome', data: [78, 90, 75, 70] }
                  ]"
                  :labels="['Gestion de projet', 'SEO/SEA', 'Gestion des réseaux sociaux', 'CRM & Emailing']"
                  :colors="['#3A3B99', '#3A3B9933']"
                />
              </div>
            </div>
          </div>

          <!-- Colonne droite - 4 colonnes sur 12 -->
          <div class="col-span-4 flex flex-col gap-[20px]">
            <div class="w-full flex-shrink-0">
              <OrganismsCalendarBlock />
            </div>

            <div class="flex flex-col items-start py-[20px] px-[24px] gap-[19px] w-full flex-1 bg-white rounded-lg overflow-hidden">
              <div class="flex flex-row justify-between items-center w-full">
                <h5 class="font-nunito font-bold text-2xl leading-[120%] text-primary-500">Dernières arrivées</h5>
                <LucideUsers :size="24" :stroke-width="1" class="text-Orange-500 flex-shrink-0" />
              </div>

              <div class="flex flex-row items-start gap-[16px] w-full overflow-x-auto pb-2 hide-scrollbar -mx-[24px] px-[24px]">
                <div
                  v-for="profile in newProfiles"
                  :key="profile.id"
                  class="flex-shrink-0"
                >
                  <MoleculesCard
                    type="profile"
                    :title="profile.name"
                    :contract-type="profile.contractType"
                    :image-url="profile.imageUrl"
                    :image-position="profile.imagePosition"
                    :description="profile.description"
                  />
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Onglet Congés -->
        <div v-if="activeTab === 'conges'" class="flex flex-col gap-5 w-full">
          <!-- Première ligne -->
          <div class="flex flex-row gap-5 w-full">
            <!-- Colonne gauche - Demandes de congés -->
            <div class="flex flex-col gap-0 flex-1" style="max-width: calc(50% - 10px);">
              <div class="flex flex-col justify-between items-end py-5 px-0 gap-4 w-full bg-white rounded-lg">
                <!-- Header -->
                <div class="flex flex-col items-start px-6 gap-2 w-full">
                  <div class="flex flex-row justify-between items-center w-full h-[29px]">
                    <h5 class="font-nunito font-bold text-2xl leading-[120%] text-primary-500">Demandes de congés</h5>
                    <LucidePalmtree :size="24" :stroke-width="1" class="text-Orange-500" />
                  </div>

                  <AtomsTag variant="soft" color="purple" size="md" class="!w-auto">
                    <template #icon-left>
                      <LucideSparkles :size="20" :stroke-width="1" />
                    </template>
                    Moins de 10 jours restant pour poser vos congés de fin d'année
                  </AtomsTag>
                </div>

                <!-- Liste des demandes -->
                <div class="flex flex-col items-start w-full">
                  <div v-for="(demande, index) in demandesConges" :key="index" class="flex flex-row items-center px-6 py-2 gap-[15px] w-full border-b border-secondary-300">
                    <span class="font-roboto text-base text-primary-900 w-[43px] flex-shrink-0">{{ demande.type }}</span>
                    <div class="flex-shrink-0">
                      <AtomsTag :variant="'soft'" :color="demande.statusColor" size="md">
                        {{ demande.status }}
                      </AtomsTag>
                    </div>
                    <span class="font-roboto text-base text-primary-900 ml-auto">{{ demande.date }}</span>
                  </div>
                </div>

                <!-- Bouton -->
                <div class="flex flex-col items-start px-4 w-auto">
                  <AtomsButton variant="tertiary" size="md" justify="start">
                    Voir toutes les demandes
                    <template #icon-right>
                      <LucideChevronRight :size="20" :stroke-width="1" />
                    </template>
                  </AtomsButton>
                </div>
              </div>
            </div>

            <!-- Colonne droite -->
            <div class="flex flex-col gap-5 flex-1" style="max-width: calc(50% - 10px);">
              <!-- Chiffres clés -->
              <div class="flex flex-row items-start gap-5 w-full">
                <div class="flex flex-col justify-center items-center py-5 px-5 flex-1 bg-white rounded-lg">
                  <h2 class="text-h2 font-sans text-primary-500 leading-none">9</h2>
                  <p class="text-base font-roboto text-center text-primary-500">Jours restants</p>
                </div>
                <div class="flex flex-col justify-center items-center py-5 px-5 flex-1 bg-white rounded-lg">
                  <h2 class="text-h2 font-sans text-primary-500 leading-none">12</h2>
                  <p class="text-base font-roboto text-center text-primary-500">Jours acquis</p>
                </div>
                <div class="flex flex-col justify-center items-center py-5 px-5 flex-1 bg-white rounded-lg">
                  <h2 class="text-h2 font-sans text-primary-500 leading-none">3</h2>
                  <p class="text-base font-roboto text-center text-primary-500">Jours pris</p>
                </div>
              </div>

              <!-- Action rapide intelligente -->
              <div class="flex flex-col items-start py-5 px-6 gap-4 w-full flex-1 bg-white rounded-lg">
                <div class="flex flex-col items-start gap-2 w-full">
                  <div class="flex flex-row justify-between items-start w-full">
                    <h5 class="font-nunito font-bold text-2xl leading-[120%] text-primary-500">Action rapide intelligente</h5>
                    <LucideRocket :size="24" :stroke-width="1" class="text-Orange-500" />
                  </div>

                  <AtomsTag variant="soft" color="purple" size="md" class="!w-auto">
                    <template #icon-left>
                      <LucideSparkles :size="20" :stroke-width="1" />
                    </template>
                    Votre équipe est déjà fortement absente la semaine du 22 au 26 décembre
                  </AtomsTag>
                </div>

                <div class="flex flex-col items-start gap-2 w-auto">
                  <AtomsButton variant="tertiary" size="md" justify="start">
                    Poser des congés pendant les vacances scolaires
                    <template #icon-right>
                      <LucideChevronRight :size="20" :stroke-width="1" />
                    </template>
                  </AtomsButton>
                  <AtomsButton variant="tertiary" size="md" justify="start">
                    Optimiser mes congés avec les jours fériés
                    <template #icon-right>
                      <LucideChevronRight :size="20" :stroke-width="1" />
                    </template>
                  </AtomsButton>
                  <AtomsButton variant="tertiary" size="md" justify="start">
                    Prendre RDV avec mon référent RH
                    <template #icon-right>
                      <LucideChevronRight :size="20" :stroke-width="1" />
                    </template>
                  </AtomsButton>
                </div>
              </div>
            </div>
          </div>

          <!-- Bloc Documents utiles -->
          <div class="flex flex-col items-start py-5 px-6 gap-4 w-full bg-white rounded-lg">
            <div class="flex flex-col items-start gap-2 w-full">
              <h5 class="font-nunito font-bold text-2xl leading-[120%] text-primary-500">Documents utiles</h5>
            </div>

            <div class="flex flex-row items-start gap-6 w-full overflow-x-auto hide-scrollbar">
              <div
                v-for="(document, index) in documentsUtiles"
                :key="index"
                class="flex-shrink-0"
              >
                <MoleculesCard
                  type="annonce"
                  :title="document.title"
                  :image-url="document.imageUrl"
                  :description="document.description"
                  :has-video="document.hasVideo"
                  :has-article="document.hasArticle"
                  :has-list="document.hasList"
                  :has-sound="document.hasSound"
                />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { 
  BarChart4 as LucideBarChart4, 
  FileQuestion, 
  Users, 
  Rocket as LucideRocket,
  ChevronRight as LucideChevronRight,
  TrendingUp as LucideTrendingUp,
  Sparkles as LucideSparkles,
  Palmtree as LucidePalmtree
} from 'lucide-vue-next'

useHead({
  title: 'Accueil - Tholka',
})

// État actif du menu
const activeTab = ref('general')
const activeTabIndex = ref(0)

const secondaryMenuItems = [
  { id: 'general', label: 'Général' },
  { id: 'onboarding', label: 'Onboarding' },
  { id: 'conges', label: 'Congés' },
  { id: 'opportunites', label: 'Opportunités internes' }
]

// Données Général
const quickAccessItems = [
  { label: 'Outil de ticketing', icon: FileQuestion, color: 'primary' },
  { label: 'Organigramme', icon: Users, color: 'primary' }
]

const documents = [
  { label: 'Procédure de pose de congés', url: '#' },
  { label: 'Organigramme Direction Communica...', url: '#' }
]

const contacts = [
  { name: 'Manager', email: 'manager@enterprise.com' }
]

const newProfiles = [
  {
    id: 1,
    name: 'Camille Dupont',
    contractType: 'CDI',
    imageUrl: '/profiles/first_profile.jpg',
    imagePosition: '15% 0%',
    description: 'Chargée de communication digitale'
  },
  {
    id: 2,
    name: 'Thomas Dubois',
    contractType: 'Alternance',
    imageUrl: '/profiles/second_profile.jpg',
    imagePosition: '25% 0%',
    description: 'Designer UX/UI créatif'
  }
]

// Données Onboarding
const onboardingChecklist = ref({
  item1: true,
  item2: true,
  item3: false,
  item4: false,
  item5: false
})

const annoncesInternes = [
  {
    title: ' Guide de l’entreprise',
    imageUrl: '/annonces/annonce-1.jpg',
    description: 'Les valeurs, les habitudes, les codes internes… tout ce qu’il faut savoir pour s’intégrer rapidement.',
    hasVideo: false,
    hasArticle: true,
    hasList: false,
    hasSound: false
  },
  {
    title: 'Histoire de l’entreprise',
    imageUrl: '/annonces/annonce-2.jpg',
    description: 'Découvrir l’histoire de l’entreprise, son évolution et sa vision pour l’avenir.',
    hasVideo: true,
    hasArticle: false,
    hasList: false,
    hasSound: false
  },
  {
    title: 'Découverte de l’équipe',
    imageUrl: '/annonces/annonce-3.jpg',
    description: 'Trois personnes essentielles de l’équipe à découvrir pour faciliter tes interactions.',
    hasVideo: false,
    hasArticle: false,
    hasList: true,
    hasSound: false
  },
  {
    title: 'Les rituels de l’équipe',
    imageUrl: '/annonces/annonce-4.jpg',
    description: 'Plongée dans la journée type de l’équipe : pauses, réunions et habitudes qui rythment le travail.',
    hasVideo: false,
    hasArticle: false,
    hasList: false,
    hasSound: true
  }
]

// Données Congés
const demandesConges = [
  { type: 'RTT', status: 'Accepté', statusColor: 'green', date: '19/11/2025' },
  { type: 'CP', status: 'En attente', statusColor: 'yellow', date: '19/11/2025' },
  { type: 'RTT', status: 'Refusé', statusColor: 'orange', date: '19/11/2025' },
  { type: 'CP', status: 'Accepté', statusColor: 'green', date: '19/11/2025' },
  { type: 'CP', status: 'Accepté', statusColor: 'green', date: '19/11/2025' }
]

const documentsUtiles = [
  {
    title: 'Procédure de pose de congés',
    imageUrl: '/documents/document-1.jpg',
    description: 'Découvrez comment demander et valider vos congés facilement.',
    hasVideo: false,
    hasArticle: true,
    hasList: false,
    hasSound: false
  },
  {
    title: 'Liste des RTT imposés',
    imageUrl: '/documents/document-2.jpg',
    description: 'Consultez les jours de RTT fixés par l’entreprise cette année.',
    hasVideo: false,
    hasArticle: false,
    hasList: true,
    hasSound: false
  },
  {
    title: 'Congés exceptionnels',
    imageUrl: '/documents/document-3.jpg',
    description: 'Informez-vous sur les cas particuliers et les congés exceptionnels auxquels vous avez droit.',
    hasVideo: false,
    hasArticle: false,
    hasList: true,
    hasSound: false
  },
  {
    title: 'Comprendre les jours de fractionnement',
    imageUrl: '/documents/document-4.jpg',
    description: 'Apprenez à bénéficier de jours supplémentaires grâce au fractionnement',
    hasVideo: true,
    hasArticle: false,
    hasList: false,
    hasSound: false
  }
]

const handleMenuChange = (data) => {
  activeTab.value = secondaryMenuItems[data.index].id
  activeTabIndex.value = data.index
}
</script>

<style scoped>
.hide-scrollbar::-webkit-scrollbar {
  display: none;
}

.hide-scrollbar {
  -ms-overflow-style: none;
  scrollbar-width: none;
}
</style>