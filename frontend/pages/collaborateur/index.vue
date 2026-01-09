<template>
  <div class="flex flex-col w-full h-screen bg-secondary-300 overflow-hidden">
    <!-- Header fixe -->
    <OrganismsNavbar 
      :is-sidebar-open="isSidebarOpen" 
      @toggle-sidebar="isSidebarOpen = !isSidebarOpen" 
    />

    <!-- Content avec Sidebar -->
    <div class="flex w-full flex-1 overflow-hidden" style="margin-top: 82.73px;">
      <!-- Sidebar fixe -->
      <OrganismsSidebarCollaborateur 
        active-item="accueil" 
        :is-open="isSidebarOpen"
        @close="isSidebarOpen = false"
      />

      <!-- Main Content - Scrollable -->
      <div class="flex-1 ml-0 lg:ml-[300px] overflow-y-auto">
        <div class="flex flex-col items-start py-8 px-[3%] gap-5 w-full">
          <!-- Menu secondaire -->
          <div class="flex flex-col md:flex-row md:justify-between md:items-center p-0 gap-4 w-full">
            <MoleculesSecondaryMenu
              :items="secondaryMenuItems"
              :default-active-index="activeTabIndex"
              @change="handleMenuChange"
            />
            
            <!-- Bouton action visible uniquement sur l'onglet Congés -->
            <AtomsButton v-if="activeTab === 'conges'" variant="primary" size="md" class="flex-shrink-0">
              Faire une demande de congé
              <template #icon-right>
                <LucidePlus :size="20" :stroke-width="1.5" />
              </template>
            </AtomsButton>
          </div>

          <!-- ============================================ -->
          <!-- ONGLET GÉNÉRAL - Grille Bento optimisée -->
          <!-- ============================================ -->
          <!-- ONGLET GÉNÉRAL - Layout Bento en 2 colonnes flex -->
          <!-- ============================================ -->
          <div v-if="activeTab === 'general'" class="w-full">
            <div class="flex flex-col lg:flex-row gap-5 w-full lg:items-stretch">

              <!-- COLONNE GAUCHE (~66%) -->
              <div class="flex flex-col gap-5 w-full lg:w-2/3">
                <!-- Accès rapides -->
                <OrganismsQuickAccessBlock
                  title="Accès rapides"
                  :quick-access="quickAccessItems"
                />

                <!-- Documents + Contacts côte à côte -->
                <div class="flex flex-col md:flex-row gap-5">
                  <div class="w-full md:w-1/2">
                    <OrganismsDocumentsBlock
                      title="Derniers documents"
                      :documents="documents"
                    />
                  </div>
                  <div class="w-full md:w-1/2">
                    <OrganismsContactsBlock
                      title="Contact de référence"
                      :contacts="contacts"
                    />
                  </div>
                </div>

                <!-- Activité & Objectifs du mois -->
                <div class="flex flex-col justify-between items-start py-5 px-6 gap-5 w-full bg-white rounded-lg flex-1">
                  <div class="flex flex-col items-start gap-2 w-full">
                    <div class="flex flex-row justify-between items-center gap-2 w-full">
                      <h5 class="font-nunito font-bold text-2xl leading-[120%] text-primary-500">Activité & Objectifs du mois</h5>
                      <LucideBarChart4 :size="24" :stroke-width="1" class="text-Orange-500 flex-shrink-0" />
                    </div>
                    
                    <AtomsTag variant="soft" color="purple" size="md" class="!w-auto">
                      Vous progressez sur 2 compétences clés ce mois-ci
                    </AtomsTag>
                  </div>

                  <div class="flex items-center justify-center w-full">
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

              <!-- COLONNE DROITE (~33%) -->
              <div class="flex flex-col gap-5 w-full lg:w-1/3">
                <!-- Calendrier -->
                <OrganismsCalendarBlock />

                <!-- Dernières arrivées -->
                <div class="flex flex-col items-start py-5 px-6 gap-4 w-full bg-white rounded-lg">
                  <div class="flex flex-row justify-between items-center w-full">
                    <h5 class="font-nunito font-bold text-2xl leading-[120%] text-primary-500">Dernières arrivées</h5>
                    <LucideUsers :size="24" :stroke-width="1" class="text-Orange-500 flex-shrink-0" />
                  </div>

                  <div class="flex flex-row items-start gap-4 w-full overflow-x-auto hide-scrollbar -mx-6 px-6">
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

          <!-- ============================================ -->
          <!-- ONGLET ONBOARDING - Layout Bento flex optimisé -->
          <!-- ============================================ -->
          <div v-if="activeTab === 'onboarding'" class="w-full">
            <div class="flex flex-col gap-5 w-full">

              <!-- LIGNE 1 : 2 colonnes flex -->
              <div class="flex flex-col lg:flex-row gap-5 w-full lg:items-stretch">

                <!-- COLONNE GAUCHE (~66%) : Bloc Onboarding -->
                <div class="w-full lg:w-2/3">
                  <div class="flex flex-col md:flex-row items-stretch w-full h-full bg-white rounded-lg overflow-hidden">
                    <!-- Checklist -->
                    <div class="flex flex-col justify-between items-end py-5 px-6 gap-9 w-full md:w-[453px] flex-shrink-0">
                      <div class="flex flex-col items-start gap-4 w-full">
                        <div class="flex flex-row justify-between items-center px-6 gap-4 w-full h-[29px]">
                          <h5 class="font-nunito font-bold text-2xl leading-[120%] text-primary-500">Onboarding</h5>
                          <LucideRocket :size="24" :stroke-width="1" class="text-Orange-500" />
                        </div>

                        <div class="flex flex-col justify-end items-start w-full h-[240px]">
                          <div class="flex flex-col items-start py-1 pl-6 gap-2.5 w-full h-[48px] border-b border-primary-500/30">
                            <div class="flex flex-row items-center w-full h-[40px]">
                              <AtomsCheckbox v-model="onboardingChecklist.item1" label="Visite des bureaux" :done="true" />
                            </div>
                          </div>
                          <div class="flex flex-col items-start py-1 pl-6 gap-2.5 w-full h-[48px] border-b border-primary-500/30">
                            <div class="flex flex-row items-center w-full h-[40px]">
                              <AtomsCheckbox v-model="onboardingChecklist.item2" label="Déjeuner d'équipe" :done="true" />
                            </div>
                          </div>
                          <div class="flex flex-col items-start py-1 pl-6 gap-2.5 w-full h-[48px] border-b border-primary-500/30">
                            <div class="flex flex-row items-center w-full h-[40px]">
                              <AtomsCheckbox v-model="onboardingChecklist.item3" label="Participer à la réunion d'équipe mensuelle" />
                            </div>
                          </div>
                          <div class="flex flex-col items-start py-1 pl-6 gap-2.5 w-full h-[48px] border-b border-primary-500/30">
                            <div class="flex flex-row items-center w-full h-[40px]">
                              <AtomsCheckbox v-model="onboardingChecklist.item4" label="Faire le point avec son manager" />
                            </div>
                          </div>
                          <div class="flex flex-col items-start py-1 pl-6 gap-2.5 w-full h-[48px] border-b border-primary-500/30">
                            <div class="flex flex-row items-center w-full h-[40px]">
                              <AtomsCheckbox v-model="onboardingChecklist.item5" label="Mettre à jour le passeport de compétences" />
                            </div>
                          </div>
                        </div>
                      </div>

                      <AtomsButton variant="tertiary" size="md" justify="start" class="w-auto">
                        Poursuivre mon parcours
                        <template #icon-right>
                          <LucideChevronRight :size="20" :stroke-width="1" />
                        </template>
                      </AtomsButton>
                    </div>

                    <!-- Image -->
                    <div class="relative w-full h-[300px] md:h-auto overflow-hidden flex-1">
                      <img src="~/assets/img/onboarding_collab.jpg" alt="Onboarding" class="w-full h-full object-cover" />
                    </div>
                  </div>
                </div>

                <!-- COLONNE DROITE (~33%) : Progression + Contact empilés -->
                <div class="flex flex-col gap-5 w-full lg:w-1/3">
                  <!-- Progression -->
                  <div class="flex flex-col items-end py-5 px-5 w-full bg-white rounded-lg">
                    <div class="flex flex-col items-start gap-1 w-full">
                      <div class="flex flex-row justify-between items-center w-full">
                        <h5 class="font-nunito font-bold text-2xl leading-[120%] text-primary-500">Progression</h5>
                        <LucideTrendingUp :size="24" :stroke-width="1" class="text-Orange-500" />
                      </div>
                    </div>

                    <div class="flex flex-row justify-center items-center w-full py-4">
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

                  <!-- Contact de référence - flex-1 pour remplir l'espace restant -->
                  <OrganismsContactsBlock
                    title="Contact de référence"
                    :contacts="contacts"
                    class="flex-1"
                  />
                </div>

              </div>

              <!-- LIGNE 2 : Ressources - Pleine largeur -->
              <div class="flex flex-col items-start py-5 px-6 gap-10 w-full bg-white rounded-lg overflow-hidden">
                <div class="flex flex-col items-start gap-3 w-full">
                  <div class="flex flex-row justify-between items-start w-full">
                    <h5 class="font-nunito font-bold text-xl md:text-2xl leading-[120%] text-primary-500">Ressources pour débuter dans les meilleures conditions</h5>
                  </div>

                  <div class="w-full">
                    <AtomsTag variant="soft" color="purple" size="md" class="!px-2 !w-auto !h-auto !py-2">
                      <template #icon-left>
                        <LucideSparkles :size="20" :stroke-width="1" class="flex-shrink-0" />
                      </template>
                      <span class="text-sm leading-[130%]">61% des nouveaux collaborateurs qui ont consulté le Guide de l'entreprise se sentent pleinement opérationnels dès la première semaine</span>
                    </AtomsTag>
                  </div>
                </div>

                <div class="flex flex-row items-start gap-6 w-full overflow-x-auto hide-scrollbar -mx-6 px-6">
                  <div v-for="(annonce, index) in annoncesInternes" :key="index" class="flex-shrink-0">
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
          </div>

          <!-- ============================================ -->
          <!-- ONGLET CONGÉS - Layout Bento flex optimisé -->
          <!-- ============================================ -->
          <div v-if="activeTab === 'conges'" class="w-full">
            <div class="flex flex-col gap-5 w-full">

              <!-- LIGNE 1 : 2 colonnes flex -->
              <div class="flex flex-col lg:flex-row gap-5 w-full lg:items-stretch">

                <!-- COLONNE GAUCHE (~50%) : Demandes de congés -->
                <div class="w-full lg:w-1/2">
                  <div class="flex flex-col justify-between items-end py-5 px-0 gap-4 w-full h-full bg-white rounded-lg">
                    <div class="flex flex-col items-start px-6 gap-2 w-full">
                      <div class="flex flex-row justify-between items-center w-full">
                        <h5 class="font-nunito font-bold text-xl md:text-2xl leading-[120%] text-primary-500">Demandes de congés</h5>
                        <LucidePalmtree :size="24" :stroke-width="1" class="text-Orange-500 flex-shrink-0" />
                      </div>

                      <AtomsTag variant="soft" color="purple" size="md" class="!w-auto !px-2 !h-auto !py-2">
                        <template #icon-left>
                          <LucideSparkles :size="20" :stroke-width="1" class="flex-shrink-0" />
                        </template>
                        <span class="text-sm">Moins de 10 jours restant pour poser vos congés de fin d'année</span>
                      </AtomsTag>
                    </div>

                    <div class="flex flex-col items-start w-full flex-1 overflow-y-auto">
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

                <!-- COLONNE DROITE (~50%) : Stats + Action rapide empilés -->
                <div class="flex flex-col gap-5 w-full lg:w-1/2">
                  <!-- Chiffres clés - 3 stats en ligne -->
                  <div class="grid grid-cols-3 gap-5 w-full">
                    <div class="flex flex-col justify-center items-center py-5 px-3 md:px-5 bg-white rounded-lg">
                      <h2 class="text-h3 md:text-h2 font-sans text-primary-500 leading-none">9</h2>
                      <p class="text-sm md:text-base font-roboto text-center text-primary-500">Jours restants</p>
                    </div>
                    <div class="flex flex-col justify-center items-center py-5 px-3 md:px-5 bg-white rounded-lg">
                      <h2 class="text-h3 md:text-h2 font-sans text-primary-500 leading-none">12</h2>
                      <p class="text-sm md:text-base font-roboto text-center text-primary-500">Jours acquis</p>
                    </div>
                    <div class="flex flex-col justify-center items-center py-5 px-3 md:px-5 bg-white rounded-lg">
                      <h2 class="text-h3 md:text-h2 font-sans text-primary-500 leading-none">3</h2>
                      <p class="text-sm md:text-base font-roboto text-center text-primary-500">Jours pris</p>
                    </div>
                  </div>

                  <!-- Action rapide intelligente - flex-1 pour remplir l'espace -->
                  <div class="flex flex-col items-start py-5 px-6 gap-4 w-full flex-1 bg-white rounded-lg">
                    <div class="flex flex-col items-start gap-2 w-full">
                      <div class="flex flex-row justify-between items-start w-full gap-2">
                        <h5 class="font-nunito font-bold text-xl md:text-2xl leading-[120%] text-primary-500">Action rapide intelligente</h5>
                        <LucideRocket :size="24" :stroke-width="1" class="text-Orange-500 flex-shrink-0" />
                      </div>

                      <AtomsTag variant="soft" color="purple" size="md" class="!w-auto !px-2 !h-auto !py-2">
                        <template #icon-left>
                          <LucideSparkles :size="20" :stroke-width="1" class="flex-shrink-0" />
                        </template>
                        <span class="text-sm">Votre équipe est déjà fortement absente la semaine du 22 au 26 décembre</span>
                      </AtomsTag>
                    </div>

                    <div class="flex flex-col items-start gap-2 w-full">
                      <AtomsButton variant="tertiary" size="md" justify="start" class="w-full md:w-auto">
                        Poser des congés pendant les vacances scolaires
                        <template #icon-right>
                          <LucideChevronRight :size="20" :stroke-width="1" />
                        </template>
                      </AtomsButton>
                      <AtomsButton variant="tertiary" size="md" justify="start" class="w-full md:w-auto">
                        Optimiser mes congés avec les jours fériés
                        <template #icon-right>
                          <LucideChevronRight :size="20" :stroke-width="1" />
                        </template>
                      </AtomsButton>
                      <AtomsButton variant="tertiary" size="md" justify="start" class="w-full md:w-auto">
                        Prendre RDV avec mon référent RH
                        <template #icon-right>
                          <LucideChevronRight :size="20" :stroke-width="1" />
                        </template>
                      </AtomsButton>
                    </div>
                  </div>
                </div>

              </div>

              <!-- LIGNE 2 : Documents utiles - Pleine largeur -->
              <div class="flex flex-col items-start py-5 px-6 gap-4 w-full bg-white rounded-lg overflow-hidden">
                <div class="flex flex-col items-start gap-2 w-full">
                  <h5 class="font-nunito font-bold text-xl md:text-2xl leading-[120%] text-primary-500">Documents utiles</h5>
                </div>

                <div class="flex flex-row items-start gap-6 w-full overflow-x-auto hide-scrollbar -mx-6 px-6">
                  <div v-for="(document, index) in documentsUtiles" :key="index" class="flex-shrink-0">
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

          <!-- ============================================ -->
          <!-- ONGLET OPPORTUNITÉS - Layout Bento flex optimisé -->
          <!-- ============================================ -->
          <div v-if="activeTab === 'opportunites'" class="w-full">
            <!-- Structure principale : 2 colonnes -->
            <div class="flex flex-col lg:flex-row gap-5 w-full lg:items-stretch">

              <!-- ========================================== -->
              <!-- COLONNE GAUCHE (~66%) -->
              <!-- ========================================== -->
              <div class="flex flex-col gap-5 w-full lg:w-2/3">
                
                <!-- Bloc 1 : Opportunités internes -->
                <div class="flex flex-col justify-center items-start py-5 px-6 gap-6 w-full bg-white rounded-lg">
                  <div class="flex flex-col items-start gap-2 w-full">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2 w-full">
                      <h5 class="font-nunito font-bold text-xl md:text-2xl leading-[120%] text-primary-500">Opportunités internes</h5>
                      <AtomsButton variant="tertiary" size="md" justify="start" class="flex-shrink-0">
                        Voir toutes les opportunités
                        <template #icon-right>
                          <LucideChevronRight :size="20" :stroke-width="1" />
                        </template>
                      </AtomsButton>
                    </div>

                    <AtomsTag variant="soft" color="purple" size="sm" class="!w-auto !px-2 !h-auto !py-1.5">
                      <template #icon-left>
                        <LucideSparkles :size="16" :stroke-width="1" class="flex-shrink-0" />
                      </template>
                      <span class="text-sm">Suggestions d'évolution basées sur ton expérience en marketing</span>
                    </AtomsTag>
                  </div>

                  <div class="flex flex-row items-start gap-6 w-full overflow-x-auto hide-scrollbar -mx-6 px-6">
                    <div v-for="(opportunite, index) in opportunitesInternes" :key="index" class="flex-shrink-0">
                      <MoleculesCard
                        type="opportunite"
                        :title="opportunite.title"
                        :contract-type="opportunite.contractType"
                        :image-url="opportunite.imageUrl"
                        :description="opportunite.description"
                      />
                    </div>
                  </div>
                </div>

                <!-- Bloc 2 : Contact + Cooptation côte à côte -->
                <div class="flex flex-col md:flex-row gap-5 w-full">
                  <!-- Contact de référence -->
                  <div class="w-full md:w-1/2">
                    <OrganismsContactsBlock
                      title="Contact de référence"
                      :contacts="contactsRecrutement"
                      class="h-full"
                    />
                  </div>

                  <!-- Cooptation -->
                  <div class="w-full md:w-1/2">
                    <div class="flex flex-col items-start py-5 px-5 gap-4 bg-white rounded-lg h-full">
                      <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2 w-full">
                        <h5 class="font-nunito font-bold text-xl md:text-2xl leading-[120%] text-primary-500">Cooptation</h5>
                        
                        <div class="flex flex-row items-center gap-2 flex-shrink-0">
                          <div class="flex flex-row items-center gap-0">
                            <div class="w-[22px] h-[22px] relative">
                              <div class="absolute inset-0 bg-cover bg-center rounded-full border border-secondary-300" style="background-image: url('/profiles/avatar-1.jpg');"></div>
                            </div>
                            <div class="w-[22px] h-[22px] relative -ml-[6px]">
                              <div class="absolute inset-0 bg-cover bg-center rounded-full border border-secondary-300" style="background-image: url('/profiles/avatar-2.jpg');"></div>
                            </div>
                            <div class="w-[22px] h-[22px] relative -ml-[6px]">
                              <div class="absolute inset-0 bg-cover bg-center rounded-full border border-secondary-300" style="background-image: url('/profiles/avatar-3.jpg');"></div>
                            </div>
                          </div>
                          <span class="text-xs font-roboto text-primary-900 whitespace-nowrap">+ 50 collaborateurs en 2025</span>
                        </div>
                      </div>
                      
                      <p class="text-base font-roboto text-primary-900 w-full">Vous connaissez quelqu'un qui pourrait briller chez nous ? Recommandez-le !</p>
                    </div>
                  </div>
                </div>

                <!-- Bloc 3 : Compétences valorisées - flex-1 pour aligner avec la colonne droite -->
                <div class="flex flex-col md:flex-row items-center py-5 px-5 gap-6 w-full bg-white rounded-lg overflow-hidden flex-1">
                  <!-- Illustration -->
                  <div class="w-full md:w-[200px] flex-shrink-0 flex items-center justify-center">
                    <img src="~/assets/img/competences_illustration.svg" alt="Compétences" class="w-[180px] md:w-full object-contain" />
                  </div>

                  <!-- Contenu -->
                  <div class="flex flex-col justify-center items-start py-0 px-0 md:px-3 gap-6 flex-1 w-full">
                    <div class="flex flex-col items-start gap-1 w-full">
                      <div class="flex flex-row justify-between items-center w-full gap-2">
                        <h5 class="font-nunito font-bold text-xl md:text-2xl leading-[120%] text-primary-500">Compétences valorisées</h5>
                        <LucideStar :size="24" :stroke-width="1" class="text-Orange-500 flex-shrink-0" />
                      </div>
                      <p class="text-sm md:text-base font-roboto text-primary-900 w-full">Ce que l'entreprise remarque et apprécie</p>
                    </div>

                    <div class="flex flex-col items-start gap-3 w-full">
                      <div v-for="(competence, index) in competencesValorisees" :key="index" class="flex flex-row justify-between items-center w-full gap-2">
                        <h6 class="font-nunito font-bold text-base md:text-[18px] leading-[120%] text-primary-900 flex-shrink-0">{{ competence.name }}</h6>
                        <div class="flex flex-row items-center gap-0 flex-shrink-0">
                          <LucideStar 
                            v-for="star in 5"
                            :key="star"
                            :size="20"
                            :stroke-width="1"
                            :class="star <= competence.stars ? 'text-primary-500' : 'text-primary-500/30'"
                          />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>

              <!-- ========================================== -->
              <!-- COLONNE DROITE (~33%) -->
              <!-- ========================================== -->
              <div class="flex flex-col gap-5 w-full lg:w-1/3">
                
                <!-- Bloc 1 : Potentiel de mobilité -->
                <div class="flex flex-col items-end py-5 px-5 gap-4 w-full bg-white rounded-lg">
                  <div class="flex flex-col items-start gap-1 w-full">
                    <div class="flex flex-row justify-between items-center w-full gap-2">
                      <h5 class="font-nunito font-bold text-xl md:text-2xl leading-[120%] text-primary-500">Potentiel de mobilité</h5>
                      <LucideUserPlus2 :size="24" :stroke-width="1" class="text-Orange-500 flex-shrink-0" />
                    </div>
                  </div>

                  <div class="flex flex-row flex-wrap items-center py-1 gap-2 w-full">
                    <AtomsTag variant="soft" color="purple" size="sm" class="!w-auto !px-2 !h-auto !py-1.5">
                      <template #icon-left>
                        <LucideSparkles :size="16" :stroke-width="1" class="flex-shrink-0" />
                      </template>
                      <span class="text-sm">3 postes compatibles</span>
                    </AtomsTag>
                    <AtomsTag variant="soft" color="purple" size="sm" class="!w-auto !px-2 !h-auto !py-1.5">
                      <template #icon-left>
                        <LucideSparkles :size="16" :stroke-width="1" class="flex-shrink-0" />
                      </template>
                      <span class="text-sm">1 service intéressé</span>
                    </AtomsTag>
                  </div>

                  <div class="flex flex-row justify-center items-center w-full py-2">
                    <ClientOnly>
                      <MoleculesProgressRingChart
                        :percentage="72"
                        center-value="72%"
                        center-label="De compatibilité"
                        :stroke-width="22"
                      />
                    </ClientOnly>
                  </div>
                </div>

                <!-- Bloc 2 : À ne pas manquer (image calendrier + événements) -->
                <div class="flex flex-col items-start w-full bg-white rounded-lg overflow-hidden flex-1">
                  <!-- Image calendrier -->
                  <div class="w-full h-[138px] bg-cover bg-center flex-shrink-0" style="background-image: url('/opportunites/banner.jpg');"></div>
                  
                  <!-- Événements -->
                  <OrganismsEventsBlock
                    title="À ne pas manquer"
                    :events="eventsOpportunites"
                    class="flex-1 w-full"
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
import { ref } from 'vue'
import { 
  BarChart4 as LucideBarChart4, 
  FileQuestion, 
  Users, 
  Rocket as LucideRocket,
  ChevronRight as LucideChevronRight,
  TrendingUp as LucideTrendingUp,
  Sparkles as LucideSparkles,
  Palmtree as LucidePalmtree,
  Star as LucideStar,
  UserPlus2 as LucideUserPlus2,
  CalendarHeart as LucideCalendarHeart,
  Plus as LucidePlus
} from 'lucide-vue-next'

useHead({
  title: 'Accueil - Tholka',
})

// État de la sidebar mobile
const isSidebarOpen = ref(false)

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

// Données Opportunités internes
const opportunitesInternes = [
  {
    title: 'Chef de projet Marketing',
    contractType: 'CDI',
    imageUrl: '/opportunites/opportunite-1.jpg',
    description: 'Pour évoluer vers la gestion, la stratégie et la coordination multi-équipes.'
  },
  {
    title: 'Content Manager',
    contractType: 'CDI',
    imageUrl: '/opportunites/opportunite-2.jpg',
    description: 'Pour développer ton expertise éditoriale et la stratégie de contenu.'
  },
  {
    title: 'Growth Marketer',
    contractType: 'CDI',
    imageUrl: '/opportunites/opportunite-3.jpg',
    description: 'Pour monter en compétence sur l’analyse, l’optimisation et les leviers d’acquisition.'
  }
]

const contactsRecrutement = [
  { name: 'Chargé de recrutement', email: 'recrutement@enterprise.com' }
]

const competencesValorisees = [
  { name: 'UI / UX', stars: 3 },
  { name: 'Data marketing', stars: 4 },
  { name: 'Rédaction', stars: 4 }
]

const eventsOpportunites = [
  {
    day: '2',
    monthYear: 'déc. 2025',
    year: 2025,
    tagLabel: 'Rencontre métier',
    title: 'Équipe Brand & Communication'
  },
  {
    day: '2',
    monthYear: 'déc. 2025',
    year: 2025,
    tagLabel: 'Atelier',
    title: 'Découvrir les métiers du numérique'
  },
  {
    day: '2',
    monthYear: 'déc. 2025',
    year: 2025,
    tagLabel: 'Webinar',
    title: 'Webinar : Les tendances marketing 2025'
  },
  // {
  //   day: '2',
  //   monthYear: 'déc. 2025',
  //   year: 2025,
  //   tagLabel: 'Workshop',
  //   title: 'Workshop “Data & Analytics : lire ses KPI marketing'
  // },
  // {
  //   day: '2',
  //   monthYear: 'déc. 2025',
  //   year: 2025,
  //   tagLabel: 'Workshop',
  //   title: 'Workshop “Data & Analytics : lire ses KPI marketing'
  // }
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