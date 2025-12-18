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
            :items="[
              { id: 'general', label: 'Général' },
              { id: 'onboarding', label: 'Onboarding' },
              { id: 'conges', label: 'Congés' },
              { id: 'opportunites', label: 'Opportunités internes' }
            ]"
            @change="handleMenuChange"
          />
        </div>

        <!-- Blocs - Grid pour assurer l'alignement -->
        <div class="grid grid-cols-12 gap-[20px] w-full max-w-[1324px]">
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

            <!-- Activité & Objectifs du mois - hauteur auto -->
            <div class="flex flex-col justify-between items-start py-[20px] px-[23px] gap-[20px] w-full min-h-[595px] bg-white rounded-lg">
              <!-- Header -->
              <div class="flex flex-col items-start p-0 gap-[8px] w-full">
                <!-- Title -->
                <div class="flex flex-row justify-between items-center p-0 gap-[10px] w-full">
                  <h5 class="font-nunito font-bold text-2xl leading-[120%] text-primary-500">Activité & Objectifs du mois</h5>
                  <LucideBarChart4 :size="24" :stroke-width="1" class="text-Orange-500" />
                </div>
                
                <!-- Tag IA -->
                <AtomsTag variant="soft" color="purple" size="md" class="!w-auto !max-w-full">
                  Vous progressez sur 2 compétences clés ce mois-ci
                </AtomsTag>
              </div>

              <!-- Bar Chart - flex-1 pour prendre l'espace restant -->
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
            <!-- Calendar - hauteur auto -->
            <div class="w-full">
              <OrganismsCalendarBlock />
            </div>

            <!-- Dernières arrivées - flex-1 pour remplir l'espace restant -->
            <div class="flex flex-col items-start py-[20px] pl-[24px] pr-0 gap-[19px] w-full flex-1 bg-white rounded-lg overflow-hidden">
              <!-- Titre -->
              <div class="flex flex-row justify-between items-center w-full pr-[24px]">
                <h5 class="font-nunito font-bold text-2xl leading-[120%] text-primary-500">Dernières arrivées</h5>
                <LucideUsers :size="24" :stroke-width="1" class="text-Orange-500 flex-shrink-0" />
              </div>

              <!-- Cards carousel horizontal -->
              <div class="flex flex-row items-start gap-[16px] w-full overflow-x-auto pb-2 hide-scrollbar pr-[24px]">
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
      </div>
    </div>
  </div>
</template>

<script setup>
import { BarChart4 as LucideBarChart4, FileQuestion, Users } from 'lucide-vue-next'

useHead({
  title: 'Accueil - Tholka',
})

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
  },
]

const handleMenuChange = (menuId) => {
  console.log('Menu changé:', menuId)
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