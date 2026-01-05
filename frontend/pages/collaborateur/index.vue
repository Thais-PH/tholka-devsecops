<template>
  <div class="flex flex-col w-full min-h-screen bg-secondary-300">
    <!-- Header -->
    <OrganismsNavbar />

    <!-- Content avec Sidebar -->
    <div class="flex w-full" style="margin-top: 82.73px;">
      <!-- Sidebar -->
      <OrganismsSidebarCollaborateur active-item="accueil" />

      <!-- Main Content -->
      <div class="flex flex-col items-start p-[32px] gap-[20px] flex-1" style="margin-left: 300px;">
        <!-- Menu secondaire -->
        <div class="flex flex-col items-start p-0 gap-[16px] w-full max-w-[1324px]">
          <MoleculesSecondaryMenu
            :items="secondaryMenuItems"
            :default-active-index="activeTabIndex"
            @change="handleMenuChange"
          />
        </div>

        <!-- Onglet Général -->
        <div v-if="activeTab === 'general'" class="grid grid-cols-12 gap-[20px] w-full max-w-[1324px]">
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
            <div class="flex flex-col justify-between items-start py-[20px] px-[23px] gap-[20px] w-full min-h-[595px] bg-white rounded-lg">
              <div class="flex flex-col items-start p-0 gap-[8px] w-full">
                <div class="flex flex-row justify-between items-center p-0 gap-[10px] w-full">
                  <h5 class="font-nunito font-bold text-2xl leading-[120%] text-primary-500">Activité & Objectifs du mois</h5>
                  <LucideBarChart4 :size="24" :stroke-width="1" class="text-Orange-500" />
                </div>
                
                <AtomsTag variant="soft" color="purple" size="md" class="!w-auto !max-w-full">
                  Vous progressez sur 2 compétences clés ce mois-ci
                </AtomsTag>
              </div>

              <div class="flex items-center justify-center w-full flex-1 min-h-[455px]">
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
            <div class="w-full">
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

        <!-- Onglet Onboarding -->
        <div v-if="activeTab === 'onboarding'" class="flex flex-col gap-[20px] w-full max-w-[1324px]">
          <!-- Première ligne -->
          <div class="grid grid-cols-12 gap-[20px]">
            <!-- Bloc Push Onboarding - 8 colonnes -->
            <div class="col-span-8">
              <div class="flex flex-row items-start w-full bg-white rounded-lg overflow-hidden">
                <!-- Left bloc - Checklist -->
                <div class="flex flex-col justify-between items-end py-[20px] px-[24px] gap-[37px] w-[453px]">
                  <div class="flex flex-col items-start gap-[16px] w-full">
                    <!-- Titre -->
                    <div class="flex flex-row justify-between items-center px-[24px] gap-[16px] w-full">
                      <div class="flex flex-row items-center gap-[10px]">
                        <h5 class="font-nunito font-bold text-2xl leading-[120%] text-primary-500">Onboarding</h5>
                        <LucideRocket :size="24" :stroke-width="1" class="text-Orange-500" />
                      </div>
                    </div>

                    <!-- Checklist -->
                    <div class="flex flex-col justify-end items-start w-full">
                      <!-- Item 1 - Checked -->
                      <div class="flex flex-col items-start py-[4px] pl-[24px] gap-[10px] w-full border-b border-primary-500/30">
                        <div class="flex flex-row items-center w-full h-[40px]">
                          <AtomsCheckbox
                            v-model="onboardingChecklist.item1"
                            label="Visite des bureaux"
                            :disabled="true"
                          />
                        </div>
                      </div>

                      <!-- Item 2 - Checked -->
                      <div class="flex flex-col items-start py-[4px] pl-[24px] gap-[10px] w-full border-b border-primary-500/30">
                        <div class="flex flex-row items-center w-full h-[40px]">
                          <AtomsCheckbox
                            v-model="onboardingChecklist.item2"
                            label="Déjeuner d'équipe"
                            :disabled="true"
                          />
                        </div>
                      </div>

                      <!-- Item 3 - Unchecked -->
                      <div class="flex flex-col items-start py-[4px] pl-[24px] gap-[10px] w-full border-b border-primary-500/30">
                        <div class="flex flex-row items-center w-full h-[40px]">
                          <AtomsCheckbox
                            v-model="onboardingChecklist.item3"
                            label="Participer à la réunion d’équipe mensuelle"
                          />
                        </div>
                      </div>

                      <!-- Item 4 - Unchecked -->
                      <div class="flex flex-col items-start py-[4px] pl-[24px] gap-[10px] w-full border-b border-primary-500/30">
                        <div class="flex flex-row items-center w-full h-[40px]">
                          <AtomsCheckbox
                            v-model="onboardingChecklist.item4"
                            label="Faire le point avec son manager"
                          />
                        </div>
                      </div>

                      <!-- Item 5 - Unchecked -->
                      <div class="flex flex-col items-start py-[4px] pl-[24px] gap-[10px] w-full border-b border-primary-500/30">
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
                  <AtomsButton variant="tertiary" size="md" justify="start">
                    Poursuivre mon parcours
                    <template #icon-right>
                      <LucideChevronRight :size="20" :stroke-width="1" />
                    </template>
                  </AtomsButton>
                </div>

                <!-- Right bloc - Image -->
                <div class="relative w-[420px] h-[441px] flex-1 overflow-hidden">
                  <img 
                    src="~/assets/img/onboarding_collab.jpg" 
                    alt="Onboarding" 
                    class="w-full h-full object-cover"
                  />
                </div>
              </div>
            </div>

            <!-- Colonne droite - 4 colonnes -->
            <div class="col-span-4 flex flex-col gap-[20px]">
              <!-- Chart Collaborateurs -->
              <div class="flex flex-col items-end py-[20px] px-[20px] w-full bg-white rounded-lg">
                <!-- Title -->
                <div class="flex flex-col items-start gap-[4px] w-full mb-[20px]">
                  <div class="flex flex-row justify-between items-center w-full">
                    <h5 class="font-nunito font-bold text-2xl leading-[120%] text-center text-primary-500">Progression</h5>
                    <LucideTrendingUp :size="24" :stroke-width="1" class="text-Orange-500" />
                  </div>
                </div>

                <!-- Chart -->
                <div class="flex flex-row justify-center items-center w-full">
                  <ClientOnly>
                    <MoleculesProgressRingChart
                      :percentage="50"
                      center-value="50"
                      center-label=""
                      :stroke-width="22"
                    />
                  </ClientOnly>
                </div>
              </div>

              <!-- Contact de référence -->
              <OrganismsContactsBlock
                title="Contact de référence"
                :contacts="contacts"
              />
            </div>
          </div>

          <!-- Bloc Opportunités internes -->
          <div class="flex flex-col items-start py-[20px] px-[24px] gap-[40px] w-full bg-white rounded-lg">
            <!-- Header -->
            <div class="flex flex-col items-start gap-[8px] w-full">
              <div class="flex flex-row justify-between items-center w-full">
                <h5 class="font-nunito font-bold text-2xl leading-[120%] text-primary-500">Ressources pour débuter dans les meilleures conditions</h5>
              </div>

              <!-- Tag IA -->
              <AtomsTag variant="soft" color="purple" size="md" class="!w-auto !max-w-full">
                <template #icon-left>
                  <LucideSparkles :size="20" :stroke-width="1" />
                </template>
                61% des nouveaux collaborateurs qui ont consulté le Guide de l’entreprise se sentent pleinement opérationnels dès la première semaine
              </AtomsTag>
            </div>

            <!-- Cards -->
            <div class="flex flex-row items-center gap-[24px] w-full overflow-x-auto hide-scrollbar">
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
  Sparkles as LucideSparkles
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
    contractType: 'CDI',
    imageUrl: '/annonces/annonce-1.jpg',
    description: 'Les valeurs, les habitudes, les codes internes… tout ce qu’il faut savoir pour s’intégrer rapidement.',
    hasVideo: true
  },
  {
    title: 'Histoire de l’entreprise',
    contractType: 'CDI',
    imageUrl: '/annonces/annonce-2.jpg',
    description: 'Découvrir l’histoire de l’entreprise, son évolution et sa vision pour l’avenir.',
    hasVideo: true
  },
  {
    title: 'Découverte de l’équipe',
    contractType: 'Stage',
    imageUrl: '/annonces/annonce-3.jpg',
    description: 'Trois personnes essentielles de l’équipe à découvrir pour faciliter tes interactions.',
    hasVideo: true
  },
  {
    title: 'Les rituels de l’équipe',
    contractType: 'CDI',
    imageUrl: '/annonces/annonce-4.jpg',
    description: 'Plongée dans la journée type de l’équipe : pauses, réunions et habitudes qui rythment le travail.',
    hasVideo: true
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