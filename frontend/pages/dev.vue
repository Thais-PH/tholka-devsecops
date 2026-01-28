<template>
  <div class="min-h-screen bg-Grey-100 p-8">
    <div class="max-w-7xl mx-auto">
      <!-- Header -->
      <div class="mb-12">
        <h1 class="text-4xl font-bold text-primary-900 mb-2">Design System</h1>

        <div class="mt-8 overflow-x-auto">
          <MoleculesSecondaryMenu
            :items="navigationItems"
            :active-item="activeSection"
            @change="(e) => activeSection = e.item.id"
            class="flex-wrap"
          />
        </div>
      </div>

      <!-- Colors & Typography Section -->
      <section v-show="activeSection === 'fondation'" class="mb-16">
        <h2 class="text-3xl font-bold text-primary-900 mb-8">Couleurs</h2>

        <!-- Main Usage -->
        <div class="bg-white rounded-lg p-8 shadow-sm mb-8">
          <div class="flex flex-wrap gap-6">
            <div class="flex items-center gap-3">
              <div class="w-12 h-12 rounded-lg bg-secondary-300 border border-Grey-300"></div>
              <div>
                <p class="text-sm font-medium text-Black">Background</p>
                <p class="text-xs text-Grey-500">#ECF8FD</p>
              </div>
            </div>
            <div class="flex items-center gap-3">
              <div class="w-12 h-12 rounded-lg bg-primary-500 border border-Grey-300"></div>
              <div>
                <p class="text-sm font-medium text-Black">Title</p>
                <p class="text-xs text-Grey-500">#3A3B99</p>
              </div>
            </div>
            <div class="flex items-center gap-3">
              <div class="w-12 h-12 rounded-lg bg-primary-900 border border-Grey-300"></div>
              <div>
                <p class="text-sm font-medium text-Black">Text</p>
                <p class="text-xs text-Grey-500">#050D2E</p>
              </div>
            </div>
            <div class="flex items-center gap-3">
              <div class="w-12 h-12 rounded-lg bg-Light border-2 border-Black"></div>
              <div>
                <p class="text-sm font-medium text-Black">Background alt</p>
                <p class="text-xs text-Grey-500">#FFFFFF</p>
              </div>
            </div>
            <div class="flex items-center gap-3">
              <div class="w-12 h-12 rounded-lg bg-primary-500 border border-Grey-300"></div>
              <div>
                <p class="text-sm font-medium text-Black">Interaction</p>
                <p class="text-xs text-Grey-500">#3A3B99</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Brand -->
        <div class="bg-white rounded-lg p-8 shadow-sm mb-8">
          <h3 class="text-2xl font-semibold text-primary-700 mb-6">Brand</h3>
          <div class="flex gap-6">
            <div class="flex items-center gap-3">
              <div class="w-12 h-12 rounded-lg bg-primary-500 border border-Grey-300"></div>
              <div>
                <p class="text-sm font-medium text-Black">Primary 500</p>
                <p class="text-xs text-Grey-500">#3A3B99</p>
              </div>
            </div>
            <div class="flex items-center gap-3">
              <div class="w-12 h-12 rounded-lg bg-secondary-500 border border-Grey-300"></div>
              <div>
                <p class="text-sm font-medium text-Black">Secondary 500</p>
                <p class="text-xs text-Grey-500">#55C3E9</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Brand Variants -->
        <div class="bg-white rounded-lg p-8 shadow-sm mb-8">
          <h3 class="text-2xl font-semibold text-primary-700 mb-6">Brand Variants</h3>
          <div class="flex flex-wrap gap-6">
            <div class="flex items-center gap-3">
              <div class="w-12 h-12 rounded-lg bg-primary-700 border border-Grey-300"></div>
              <div>
                <p class="text-sm font-medium text-Black">Primary 700</p>
                <p class="text-xs text-Grey-500">#252958</p>
              </div>
            </div>
            <div class="flex items-center gap-3">
              <div class="w-12 h-12 rounded-lg bg-primary-300 border border-Grey-300"></div>
              <div>
                <p class="text-sm font-medium text-Black">Primary 300</p>
                <p class="text-xs text-Grey-500">#EBEBF5</p>
              </div>
            </div>
            <div class="flex items-center gap-3">
              <div class="w-12 h-12 rounded-lg bg-secondary-700 border border-Grey-300"></div>
              <div>
                <p class="text-sm font-medium text-Black">Secondary 700</p>
                <p class="text-xs text-Grey-500">#137192</p>
              </div>
            </div>
            <div class="flex items-center gap-3">
              <div class="w-12 h-12 rounded-lg bg-secondary-300 border border-Grey-300"></div>
              <div>
                <p class="text-sm font-medium text-Black">Secondary 300</p>
                <p class="text-xs text-Grey-500">#ECF8FD</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Neutral -->
        <div class="bg-white rounded-lg p-8 shadow-sm mb-8">
          <h3 class="text-2xl font-semibold text-primary-700 mb-6">Neutral</h3>
          <div class="flex flex-wrap gap-6">
            <div class="flex items-center gap-3">
              <div class="w-12 h-12 rounded-lg bg-Black border border-Grey-300"></div>
              <div>
                <p class="text-sm font-medium text-Black">Black</p>
                <p class="text-xs text-Grey-500">#0B0B0B</p>
              </div>
            </div>
            <div class="flex items-center gap-3">
              <div class="w-12 h-12 rounded-lg bg-primary-900 border border-Grey-300"></div>
              <div>
                <p class="text-sm font-medium text-Black">Primary 900</p>
                <p class="text-xs text-Grey-500">#050D2E</p>
              </div>
            </div>
            <div class="flex items-center gap-3">
              <div class="w-12 h-12 rounded-lg bg-Grey-500 border border-Grey-300"></div>
              <div>
                <p class="text-sm font-medium text-Black">Grey 500</p>
                <p class="text-xs text-Grey-500">#AEACAC</p>
              </div>
            </div>
            <div class="flex items-center gap-3">
              <div class="w-12 h-12 rounded-lg bg-Grey-300 border border-Grey-300"></div>
              <div>
                <p class="text-sm font-medium text-Black">Grey 300</p>
                <p class="text-xs text-Grey-500">#EFEEEE</p>
              </div>
            </div>
            <div class="flex items-center gap-3">
              <div class="w-12 h-12 rounded-lg bg-Light border-2 border-Black"></div>
              <div>
                <p class="text-sm font-medium text-Black">Light</p>
                <p class="text-xs text-Grey-500">#FFFFFF</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Other Colors -->
        <div class="bg-white rounded-lg p-8 shadow-sm mb-8">
          <h3 class="text-2xl font-semibold text-primary-700 mb-6">Other Colors</h3>

          <!-- Green -->
          <div class="mb-6">
            <h4 class="text-sm font-medium text-Grey-600 mb-3 uppercase">Green</h4>
            <div class="flex flex-wrap gap-6">
              <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-lg bg-Green-700 border border-Grey-300"></div>
                <div>
                  <p class="text-sm font-medium text-Black">Green 700</p>
                  <p class="text-xs text-Grey-500">#146E4E</p>
                </div>
              </div>
              <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-lg bg-Green-500 border border-Grey-300"></div>
                <div>
                  <p class="text-sm font-medium text-Black">Green 500</p>
                  <p class="text-xs text-Grey-500">#1CAB78</p>
                </div>
              </div>
              <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-lg bg-Green-300 border border-Grey-300"></div>
                <div>
                  <p class="text-sm font-medium text-Black">Green 300</p>
                  <p class="text-xs text-Grey-500">#E8F7F1</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Orange -->
          <div class="mb-6">
            <h4 class="text-sm font-medium text-Grey-600 mb-3 uppercase">Orange</h4>
            <div class="flex flex-wrap gap-6">
              <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-lg bg-Orange-700 border border-Grey-300"></div>
                <div>
                  <p class="text-sm font-medium text-Black">Orange 700</p>
                  <p class="text-xs text-Grey-500">#B55322</p>
                </div>
              </div>
              <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-lg bg-Orange-500 border border-Grey-300"></div>
                <div>
                  <p class="text-sm font-medium text-Black">Orange 500</p>
                  <p class="text-xs text-Grey-500">#F07F47</p>
                </div>
              </div>
              <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-lg bg-Orange-300 border border-Grey-300"></div>
                <div>
                  <p class="text-sm font-medium text-Black">Orange 300</p>
                  <p class="text-xs text-Grey-500">#FDF2ED</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Yellow -->
          <div>
            <h4 class="text-sm font-medium text-Grey-600 mb-3 uppercase">Yellow</h4>
            <div class="flex flex-wrap gap-6">
              <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-lg bg-Yellow-700 border border-Grey-300"></div>
                <div>
                  <p class="text-sm font-medium text-Black">Yellow 700</p>
                  <p class="text-xs text-Grey-500">#AF8434</p>
                </div>
              </div>
              <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-lg bg-Yellow-500 border border-Grey-300"></div>
                <div>
                  <p class="text-sm font-medium text-Black">Yellow 500</p>
                  <p class="text-xs text-Grey-500">#FCC253</p>
                </div>
              </div>
              <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-lg bg-Yellow-300 border border-Grey-300"></div>
                <div>
                  <p class="text-sm font-medium text-Black">Yellow 300</p>
                  <p class="text-xs text-Grey-500">#FFF6E5</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Alert -->
        <div class="bg-white rounded-lg p-8 shadow-sm mb-8">
          <h3 class="text-2xl font-semibold text-primary-700 mb-6">Alert</h3>
          <div class="flex gap-6">
            <div class="flex items-center gap-3">
              <div class="w-12 h-12 rounded-lg bg-Red-700 border border-Grey-300"></div>
              <div>
                <p class="text-sm font-medium text-Black">Red 700</p>
                <p class="text-xs text-Grey-500">#AA271D</p>
              </div>
            </div>
            <div class="flex items-center gap-3">
              <div class="w-12 h-12 rounded-lg bg-Red-500 border border-Grey-300"></div>
              <div>
                <p class="text-sm font-medium text-Black">Red 500</p>
                <p class="text-xs text-Grey-500">#EB5035</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Disc -->
        <div class="bg-white rounded-lg p-8 shadow-sm">
          <h3 class="text-2xl font-semibold text-primary-700 mb-6">Disc</h3>
          <div class="flex flex-wrap gap-6">
            <div class="flex items-center gap-3">
              <div class="w-12 h-12 rounded-lg bg-Green-disc border border-Grey-300"></div>
              <div>
                <p class="text-sm font-medium text-Black">Green Disc</p>
                <p class="text-xs text-Grey-500">#45CA24</p>
              </div>
            </div>
            <div class="flex items-center gap-3">
              <div class="w-12 h-12 rounded-lg bg-Blue-disc border border-Grey-300"></div>
              <div>
                <p class="text-sm font-medium text-Black">Blue Disc</p>
                <p class="text-xs text-Grey-500">#476EF6</p>
              </div>
            </div>
            <div class="flex items-center gap-3">
              <div class="w-12 h-12 rounded-lg bg-Yellow-disc border border-Grey-300"></div>
              <div>
                <p class="text-sm font-medium text-Black">Yellow Disc</p>
                <p class="text-xs text-Grey-500">#FFD83B</p>
              </div>
            </div>
            <div class="flex items-center gap-3">
              <div class="w-12 h-12 rounded-lg bg-Red-disc border border-Grey-300"></div>
              <div>
                <p class="text-sm font-medium text-Black">Red Disc</p>
                <p class="text-xs text-Grey-500">#EB4335</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Typographies -->
        <h2 class="text-3xl font-bold text-primary-900 mb-8 mt-8">Typographies</h2>

        <!-- Titles - Nunito -->
        <div class="bg-white rounded-lg p-8 shadow-sm mb-8">
          <h3 class="text-2xl font-semibold text-primary-700 mb-6">Titles - Nunito</h3>
          <div class="space-y-6">
            <div class="flex items-center gap-8">
              <div class="w-20">
                <p class="text-xs text-Grey-500 font-medium uppercase">H1</p>
              </div>
              <div class="flex-1">
                <h1 class="text-h1 font-sans text-primary-900">Titre principal H1</h1>
                <p class="text-xs text-Grey-500 mt-1">48px / 4.5rem • 700 Bold • Line height: 72px</p>
              </div>
            </div>

            <div class="flex items-center gap-8">
              <div class="w-20">
                <p class="text-xs text-Grey-500 font-medium uppercase">H2</p>
              </div>
              <div class="flex-1">
                <h2 class="text-h2 font-sans text-primary-900">Titre secondaire H2</h2>
                <p class="text-xs text-Grey-500 mt-1">40px / 3.75rem • 700 Bold • Line height: 60px</p>
              </div>
            </div>

            <div class="flex items-center gap-8">
              <div class="w-20">
                <p class="text-xs text-Grey-500 font-medium uppercase">H3</p>
              </div>
              <div class="flex-1">
                <h3 class="text-h3 font-sans text-primary-900">Titre tertiaire H3</h3>
                <p class="text-xs text-Grey-500 mt-1">32px / 3rem • 700 Bold • Line height: 48px</p>
              </div>
            </div>

            <div class="flex items-center gap-8">
              <div class="w-20">
                <p class="text-xs text-Grey-500 font-medium uppercase">H4</p>
              </div>
              <div class="flex-1">
                <h4 class="text-h4 font-sans text-primary-900">Titre quaternaire H4</h4>
                <p class="text-xs text-Grey-500 mt-1">28px / 2.625rem • 700 Bold • Line height: 42px</p>
              </div>
            </div>

            <div class="flex items-center gap-8">
              <div class="w-20">
                <p class="text-xs text-Grey-500 font-medium uppercase">H5</p>
              </div>
              <div class="flex-1">
                <h5 class="text-h5 font-sans text-primary-900">Titre quinaire H5</h5>
                <p class="text-xs text-Grey-500 mt-1">24px / 2.25rem • 700 Bold • Line height: 36px</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Body Text - Roboto -->
        <div class="bg-white rounded-lg p-8 shadow-sm">
          <h3 class="text-2xl font-semibold text-primary-700 mb-6">Body Text - Roboto</h3>
          <div class="space-y-6">
            <div class="flex items-center gap-8">
              <div class="w-20">
                <p class="text-xs text-Grey-500 font-medium uppercase">Large</p>
              </div>
              <div class="flex-1">
                <p class="text-lg font-roboto text-primary-900">Texte large pour les éléments importants et les sous-titres</p>
                <p class="text-xs text-Grey-500 mt-1">20px / 1.875rem • 500 Medium • Line height: 30px</p>
              </div>
            </div>

            <div class="flex items-center gap-8">
              <div class="w-20">
                <p class="text-xs text-Grey-500 font-medium uppercase">Base</p>
              </div>
              <div class="flex-1">
                <p class="text-base font-roboto text-primary-900">Texte de base pour le contenu principal, les paragraphes et la lecture standard</p>
                <p class="text-xs text-Grey-500 mt-1">16px / 1.5rem • 400 Regular • Line height: 24px</p>
              </div>
            </div>

            <div class="flex items-center gap-8">
              <div class="w-20">
                <p class="text-xs text-Grey-500 font-medium uppercase">Small</p>
              </div>
              <div class="flex-1">
                <p class="text-sm font-roboto text-primary-900">Texte petit pour les détails, les métadonnées et les informations secondaires</p>
                <p class="text-xs text-Grey-500 mt-1">14px / 1.313rem • 400 Regular • Line height: 21px</p>
              </div>
            </div>

            <div class="flex items-center gap-8">
              <div class="w-20">
                <p class="text-xs text-Grey-500 font-medium uppercase">XS</p>
              </div>
              <div class="flex-1">
                <p class="text-xs font-roboto text-primary-900">Texte très petit pour les légendes, les notes et les informations complémentaires</p>
                <p class="text-xs text-Grey-500 mt-1">12px / 1.125rem • 400 Regular • Line height: 18px</p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Alertes Section -->
      <section v-show="activeSection === 'alertes'" class="mt-8 mb-16">
        <h2 class="text-3xl font-bold text-primary-900 mb-8">Alertes</h2>

        <div class="bg-white rounded-lg p-8 shadow-sm">
          <div class="bg-Grey-300 rounded-lg p-8">
            <div class="space-y-4">
              <!-- Warning Soft -->
              <div>
                <p class="text-xs text-Grey-500 mb-2">Warning - Soft</p>
                <AtomsAlert
                  variant="warning-soft"
                  message="Des signaux faibles de mal-être ont été détectés. Un risque de burn-out est en cours."
                />
              </div>

              <!-- Warning Solid -->
              <div>
                <p class="text-xs text-Grey-500 mb-2">Warning - Solid</p>
                <AtomsAlert
                  variant="warning-solid"
                  message="Des signaux faibles de mal-être ont été détectés. Un risque de burn-out est en cours."
                />
              </div>

              <!-- Info -->
              <div>
                <p class="text-xs text-Grey-500 mb-2">Info</p>
                <AtomsAlert
                  variant="info"
                  message="Des signaux faibles de mal-être ont été détectés. Un risque de burn-out est en cours."
                />
              </div>

              <!-- Success Soft -->
              <div>
                <p class="text-xs text-Grey-500 mb-2">Success - Soft</p>
                <AtomsAlert
                  variant="success-soft"
                  message="Des signaux faibles de mal-être ont été détectés. Un risque de burn-out est en cours."
                />
              </div>

              <!-- Success Solid -->
              <div>
                <p class="text-xs text-Grey-500 mb-2">Success - Solid</p>
                <AtomsAlert
                  variant="success-solid"
                  message="Des signaux faibles de mal-être ont été détectés. Un risque de burn-out est en cours."
                />
              </div>

              <!-- IA Soft -->
              <div>
                <p class="text-xs text-Grey-500 mb-2">IA - Soft</p>
                <AtomsAlert
                  variant="ia-soft"
                  message="Des signaux faibles de mal-être ont été détectés. Un risque de burn-out est en cours."
                />
              </div>

              <!-- IA Solid -->
              <div>
                <p class="text-xs text-Grey-500 mb-2">IA - Solid</p>
                <AtomsAlert
                  variant="ia-solid"
                  message="Des signaux faibles de mal-être ont été détectés. Un risque de burn-out est en cours."
                />
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Blocks Section -->
      <section v-show="activeSection === 'blocks'" class="mt-8 mb-16">
        <h2 class="text-3xl font-bold text-primary-900 mb-8">Blocks</h2>

        <div class="bg-white rounded-lg p-8 shadow-sm">
          <div class="bg-Grey-300 rounded-lg p-8">
            <div class="space-y-8">
              <!-- Calendar Block -->
              <div>
                <h3 class="text-2xl font-semibold text-primary-700 mb-6">Calendar Block</h3>
                <div class="flex justify-center">
                  <OrganismsCalendarBlock />
                </div>
              </div>

              <!-- Annonce Block -->
              <div>
                <h3 class="text-2xl font-semibold text-primary-700 mb-6">Annonce Block</h3>
                <div class="flex justify-center">
                  <OrganismsAnnonceBlock
                    title="Opportunités internes"
                    :annonces="mockAnnonces"
                  />
                </div>
              </div>

              <!-- Events Block -->
              <div>
                <h3 class="text-2xl font-semibold text-primary-700 mb-6">Events Block</h3>
                <div class="flex justify-center">
                  <OrganismsEventsBlock
                    title="Événements"
                    :events="mockEvents"
                  />
                </div>
              </div>

              <!-- Chart Block -->
              <div>
                <h3 class="text-2xl font-semibold text-primary-700 mb-6">Chart Block</h3>
                <div class="flex justify-center">
                  <OrganismsChartBlock />
                </div>
              </div>

              <!-- Documents Block -->
              <div>
                <h3 class="text-2xl font-semibold text-primary-700 mb-6">Documents Block</h3>
                <div class="flex justify-center">
                  <OrganismsDocumentsBlock
                    title="Derniers documents"
                    :documents="mockDocuments"
                    @document-click="handleDocumentClick"
                  />
                </div>
              </div>

              <!-- Vacations Block -->
              <div>
                <h3 class="text-2xl font-semibold text-primary-700 mb-6">Vacations Block</h3>
                <div class="flex justify-center">
                  <OrganismsVacationsBlock
                    title="Mes congés"
                    :vacations="mockVacations"
                  />
                </div>
              </div>

              <!-- Contacts Block -->
              <div>
                <h3 class="text-2xl font-semibold text-primary-700 mb-6">Contacts Block</h3>
                <div class="flex justify-center">
                  <OrganismsContactsBlock
                    title="Mes contacts de référence"
                    :contacts="mockContacts"
                  />
                </div>
              </div>

              <!-- Quick Access Block -->
              <div>
                <h3 class="text-2xl font-semibold text-primary-700 mb-6">Quick Access Block</h3>
                <div class="flex justify-center">
                  <OrganismsQuickAccessBlock
                    title="Mes accès rapides"
                    :quick-access="mockQuickAccess"
                  />
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Boutons Section -->
      <section v-show="activeSection === 'boutons'" class="mt-8 mb-16">
        <h2 class="text-3xl font-bold text-primary-900 mb-8">Boutons</h2>

        <!-- Primary Buttons -->
        <div class="mb-12 bg-white rounded-lg p-8 shadow-sm">
          <h3 class="text-2xl font-semibold text-primary-700 mb-6">Primaire</h3>

          <!-- Default State -->
          <div class="mb-8">
            <h4 class="text-sm font-medium text-Grey-600 mb-4 uppercase">Default</h4>
            <div class="flex flex-wrap gap-4 items-end">
              <div>
                <p class="text-xs text-Grey-500 mb-2">Large</p>
                <AtomsButton variant="primary" size="lg">
                  <template #icon-left>
                    <LucideChevronLeft :size="24" :stroke-width="1" />
                  </template>
                  Button
                  <template #icon-right>
                    <LucideChevronRight :size="24" :stroke-width="1" />
                  </template>
                </AtomsButton>
              </div>

              <div>
                <p class="text-xs text-Grey-500 mb-2">Medium</p>
                <AtomsButton variant="primary" size="md">
                  <template #icon-left>
                    <LucideChevronLeft :size="20" :stroke-width="1" />
                  </template>
                  Button
                  <template #icon-right>
                    <LucideChevronRight :size="20" :stroke-width="1" />
                  </template>
                </AtomsButton>
              </div>

              <div>
                <p class="text-xs text-Grey-500 mb-2">Small</p>
                <AtomsButton variant="primary" size="sm">
                  <template #icon-left>
                    <LucideChevronLeft :size="17" :stroke-width="1" />
                  </template>
                  Button
                  <template #icon-right>
                    <LucideChevronRight :size="17" :stroke-width="1" />
                  </template>
                </AtomsButton>
              </div>
            </div>
          </div>

          <!-- White State -->
          <div class="bg-Grey-500 rounded-lg p-6">
            <h4 class="text-sm font-medium text-white mb-4 uppercase">White</h4>
            <div class="flex flex-wrap gap-4 items-end">
              <div>
                <p class="text-xs text-Grey-300 mb-2">Large</p>
                <AtomsButton variant="primary" size="lg" :on-white="true">
                  <template #icon-left>
                    <LucideChevronLeft :size="24" :stroke-width="1" />
                  </template>
                  Button
                  <template #icon-right>
                    <LucideChevronRight :size="24" :stroke-width="1" />
                  </template>
                </AtomsButton>
              </div>

              <div>
                <p class="text-xs text-Grey-300 mb-2">Medium</p>
                <AtomsButton variant="primary" size="md" :on-white="true">
                  <template #icon-left>
                    <LucideChevronLeft :size="20" :stroke-width="1" />
                  </template>
                  Button
                  <template #icon-right>
                    <LucideChevronRight :size="20" :stroke-width="1" />
                  </template>
                </AtomsButton>
              </div>

              <div>
                <p class="text-xs text-Grey-300 mb-2">Small</p>
                <AtomsButton variant="primary" size="sm" :on-white="true">
                  <template #icon-left>
                    <LucideChevronLeft :size="17" :stroke-width="1" />
                  </template>
                  Button
                  <template #icon-right>
                    <LucideChevronRight :size="17" :stroke-width="1" />
                  </template>
                </AtomsButton>
              </div>
            </div>
          </div>
        </div>

        <!-- Secondary Buttons -->
        <div class="mb-12 bg-white rounded-lg p-8 shadow-sm">
          <h3 class="text-2xl font-semibold text-primary-700 mb-6">Secondaire</h3>

          <!-- Default State -->
          <div class="mb-8">
            <h4 class="text-sm font-medium text-Grey-600 mb-4 uppercase">Default</h4>
            <div class="flex flex-wrap gap-4 items-end">
              <div>
                <p class="text-xs text-Grey-500 mb-2">Large</p>
                <AtomsButton variant="secondary" size="lg">
                  <template #icon-left>
                    <LucideChevronLeft :size="24" :stroke-width="1" />
                  </template>
                  Button
                  <template #icon-right>
                    <LucideChevronRight :size="24" :stroke-width="1" />
                  </template>
                </AtomsButton>
              </div>

              <div>
                <p class="text-xs text-Grey-500 mb-2">Medium</p>
                <AtomsButton variant="secondary" size="md">
                  <template #icon-left>
                    <LucideChevronLeft :size="20" :stroke-width="1" />
                  </template>
                  Button
                  <template #icon-right>
                    <LucideChevronRight :size="20" :stroke-width="1" />
                  </template>
                </AtomsButton>
              </div>

              <div>
                <p class="text-xs text-Grey-500 mb-2">Small</p>
                <AtomsButton variant="secondary" size="sm">
                  <template #icon-left>
                    <LucideChevronLeft :size="17" :stroke-width="1" />
                  </template>
                  Button
                  <template #icon-right>
                    <LucideChevronRight :size="17" :stroke-width="1" />
                  </template>
                </AtomsButton>
              </div>
            </div>
          </div>

          <!-- White State -->
          <div class="bg-Grey-500 rounded-lg p-6">
            <h4 class="text-sm font-medium text-white mb-4 uppercase">White</h4>
            <div class="flex flex-wrap gap-4 items-end">

              <div>
                <p class="text-xs text-Grey-300 mb-2">Large</p>
                <AtomsButton variant="secondary" size="lg" :on-white="true">
                  <template #icon-left>
                    <LucideChevronLeft :size="24" :stroke-width="1" />
                  </template>
                  Button
                  <template #icon-right>
                    <LucideChevronRight :size="24" :stroke-width="1" />
                  </template>
                </AtomsButton>
              </div>

              <div>
                <p class="text-xs text-Grey-300 mb-2">Medium</p>
                <AtomsButton variant="secondary" size="md" :on-white="true">
                  <template #icon-left>
                    <LucideChevronLeft :size="20" :stroke-width="1" />
                  </template>
                  Button
                  <template #icon-right>
                    <LucideChevronRight :size="20" :stroke-width="1" />
                  </template>
                </AtomsButton>
              </div>

              <div>
                <p class="text-xs text-Grey-300 mb-2">Small</p>
                <AtomsButton variant="secondary" size="sm" :on-white="true">
                  <template #icon-left>
                    <LucideChevronLeft :size="17" :stroke-width="1" />
                  </template>
                  Button
                  <template #icon-right>
                    <LucideChevronRight :size="17" :stroke-width="1" />
                  </template>
                </AtomsButton>
              </div>
            </div>
          </div>
        </div>

        <!-- Tertiary Buttons -->
        <div class="mb-12 bg-white rounded-lg p-8 shadow-sm">
          <h3 class="text-2xl font-semibold text-primary-700 mb-6">Tertiaire</h3>

          <!-- Default State -->
          <div class="mb-8">
            <h4 class="text-sm font-medium text-Grey-600 mb-4 uppercase">Default</h4>
            <div class="flex flex-wrap gap-4 items-end">
              <div>
                <p class="text-xs text-Grey-500 mb-2">Large</p>
                <AtomsButton variant="tertiary" size="lg">
                  <template #icon-left>
                    <LucideChevronLeft :size="24" :stroke-width="1" />
                  </template>
                  Button
                  <template #icon-right>
                    <LucideChevronRight :size="24" :stroke-width="1" />
                  </template>
                </AtomsButton>
              </div>

              <div>
                <p class="text-xs text-Grey-500 mb-2">Medium</p>
                <AtomsButton variant="tertiary" size="md">
                  <template #icon-left>
                    <LucideChevronLeft :size="20" :stroke-width="1" />
                  </template>
                  Button
                  <template #icon-right>
                    <LucideChevronRight :size="20" :stroke-width="1" />
                  </template>
                </AtomsButton>
              </div>

              <div>
                <p class="text-xs text-Grey-500 mb-2">Small</p>
                <AtomsButton variant="tertiary" size="sm">
                  <template #icon-left>
                    <LucideChevronLeft :size="17" :stroke-width="1" />
                  </template>
                  Button
                  <template #icon-right>
                    <LucideChevronRight :size="17" :stroke-width="1" />
                  </template>
                </AtomsButton>
              </div>
            </div>
          </div>

          <!-- White State -->
          <div class="bg-Grey-500 rounded-lg p-6">
            <h4 class="text-sm font-medium text-white mb-4 uppercase">White</h4>
            <div class="flex flex-wrap gap-4 items-end">
              <div>
                <p class="text-xs text-Grey-300 mb-2">Large</p>
                <AtomsButton variant="tertiary" size="lg" :on-white="true">
                  <template #icon-left>
                    <LucideChevronLeft :size="24" :stroke-width="1" />
                  </template>
                  Button
                  <template #icon-right>
                    <LucideChevronRight :size="24" :stroke-width="1" />
                  </template>
                </AtomsButton>
              </div>

              <div>
                <p class="text-xs text-Grey-300 mb-2">Medium</p>
                <AtomsButton variant="tertiary" size="md" :on-white="true">
                  <template #icon-left>
                    <LucideChevronLeft :size="20" :stroke-width="1" />
                  </template>
                  Button
                  <template #icon-right>
                    <LucideChevronRight :size="20" :stroke-width="1" />
                  </template>
                </AtomsButton>
              </div>

              <div>
                <p class="text-xs text-Grey-300 mb-2">Small</p>
                <AtomsButton variant="tertiary" size="sm" :on-white="true">
                  <template #icon-left>
                    <LucideChevronLeft :size="17" :stroke-width="1" />
                  </template>
                  Button
                  <template #icon-right>
                    <LucideChevronRight :size="17" :stroke-width="1" />
                  </template>
                </AtomsButton>
              </div>
            </div>
          </div>
        </div>

        <!-- Menu Buttons -->
        <div class="mb-12 bg-white rounded-lg p-8 shadow-sm">
          <h3 class="text-2xl font-semibold text-primary-700 mb-6">Menu</h3>

          <!-- Default State -->
          <div class="bg-Grey-500 rounded-lg p-6">
            <h4 class="text-sm font-medium text-white mb-4 uppercase">Default</h4>
            <div class="flex flex-wrap gap-4 items-end">

              <div>
                <p class="text-xs text-Grey-300 mb-2">Large</p>
                <AtomsButton variant="menu" size="lg">
                  <template #icon-left>
                    <LucideChevronLeft :size="24" :stroke-width="1" />
                  </template>
                  Button
                  <template #icon-right>
                    <LucideChevronRight :size="24" :stroke-width="1" />
                  </template>
                </AtomsButton>
              </div>

              <div>
                <p class="text-xs text-Grey-300 mb-2">Medium</p>
                <AtomsButton variant="menu" size="md">
                  <template #icon-left>
                    <LucideChevronLeft :size="20" :stroke-width="1" />
                  </template>
                  Button
                  <template #icon-right>
                    <LucideChevronRight :size="20" :stroke-width="1" />
                  </template>
                </AtomsButton>
              </div>

              <div>
                <p class="text-xs text-Grey-300 mb-2">Small</p>
                <AtomsButton variant="menu" size="sm">
                  <template #icon-left>
                    <LucideChevronLeft :size="17" :stroke-width="1" />
                  </template>
                  Button
                  <template #icon-right>
                    <LucideChevronRight :size="17" :stroke-width="1" />
                  </template>
                </AtomsButton>
              </div>
            </div>
          </div>
        </div>

        <!-- Forms Buttons -->
        <div class="mb-12 bg-white rounded-lg p-8 shadow-sm">
          <h3 class="text-2xl font-semibold text-primary-700 mb-6">Forms</h3>

          <!-- Default State -->
          <div class="bg-Grey-500 rounded-lg p-6">
            <h4 class="text-sm font-medium text-white mb-4 uppercase">Default</h4>
            <div class="flex flex-wrap gap-4 items-end">
              <div>
                <p class="text-xs text-Grey-300 mb-2">Large</p>
                <AtomsButton variant="forms" size="lg">
                  <template #icon-left>
                    <LucideChevronLeft :size="24" :stroke-width="1" />
                  </template>
                  Button
                  <template #icon-right>
                    <LucideChevronRight :size="24" :stroke-width="1" />
                  </template>
                </AtomsButton>
              </div>

              <div>
                <p class="text-xs text-Grey-300 mb-2">Medium</p>
                <AtomsButton variant="forms" size="md">
                  <template #icon-left>
                    <LucideChevronLeft :size="20" :stroke-width="1" />
                  </template>
                  Button
                  <template #icon-right>
                    <LucideChevronRight :size="20" :stroke-width="1" />
                  </template>
                </AtomsButton>
              </div>

              <div>
                <p class="text-xs text-Grey-300 mb-2">Small</p>
                <AtomsButton variant="forms" size="sm">
                  <template #icon-left>
                    <LucideChevronLeft :size="17" :stroke-width="1" />
                  </template>
                  Button
                  <template #icon-right>
                    <LucideChevronRight :size="17" :stroke-width="1" />
                  </template>
                </AtomsButton>
              </div>
            </div>
          </div>
        </div>

        <!-- IA Buttons -->
        <div class="mb-12 bg-white rounded-lg p-8 shadow-sm">
          <h3 class="text-2xl font-semibold text-primary-700 mb-6">IA</h3>

          <!-- Default State -->
          <div class="bg-Grey-500 rounded-lg p-6">
            <h4 class="text-sm font-medium text-white mb-4 uppercase">Default</h4>
            <div class="flex flex-wrap gap-4 items-end">
              <div>
                <p class="text-xs text-Grey-300 mb-2">Large</p>
                <AtomsButton variant="ia" size="lg">
                  Button
                  <template #icon-right>
                    <BadgeIA size="lg" />
                  </template>
                </AtomsButton>
              </div>

              <div>
                <p class="text-xs text-Grey-300 mb-2">Medium</p>
                <AtomsButton variant="ia" size="md">
                  Button
                  <template #icon-right>
                    <BadgeIA size="md" />
                  </template>
                </AtomsButton>
              </div>

              <div>
                <p class="text-xs text-Grey-300 mb-2">Small</p>
                <AtomsButton variant="ia" size="sm">
                  Button
                  <template #icon-right>
                    <BadgeIA size="sm" />
                  </template>
                </AtomsButton>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Cards Section -->
      <section v-show="activeSection === 'cards'" class="mt-8 mb-16">
        <h2 class="text-3xl font-bold text-primary-900 mb-8">Cards</h2>

        <div class="bg-Grey-300 rounded-lg p-8 shadow-sm">
          <h3 class="text-2xl font-semibold text-primary-700 mb-6">Event line</h3>

          <div class="flex flex-wrap gap-6 mb-8">
            <MoleculesCard
              type="event"
              :date="new Date(2025, 8, 23)"
              :tag="{ text: 'Tag', variant: 'stroke', color: 'primary', size: 'md' }"
              content-text="Titre lorem ipsum"
            />
          </div>

          <h3 class="text-2xl font-semibold text-primary-700 mb-6">Annonce</h3>

          <div class="flex flex-wrap gap-6 mb-8">
            <MoleculesCard
              type="annonce"
              title="Titre lorem ipsum"
              contract-type="CDD"
              image-url="/card.jpg"
              :has-video="true"
            />
          </div>

          <h3 class="text-2xl font-semibold text-primary-700 mb-6">Formation</h3>

          <div class="flex flex-wrap gap-6">
            <MoleculesCard
              type="job"
              :order-number="1"
              title="Titre lorem ipsum"
              contract-type="CDD"
              image-url="/card.jpg"
              description="Nous recherchons un(e) Chef de projet informatique pour piloter...."
              :has-video="true"
            />
          </div>

          <h3 class="text-2xl font-semibold text-primary-700 mb-6 mt-8">Profile</h3>

          <div class="flex flex-wrap gap-6">
            <MoleculesCard
              type="profile"
              title="Titre lorem ipsum"
              contract-type="CDD"
              image-url="/card.jpg"
              description="Nous recherchons un(e) Chef de projet informatique pour piloter...."
            />
          </div>

          <h3 class="text-2xl font-semibold text-primary-700 mb-6 mt-8">Stats</h3>

          <div class="flex flex-wrap gap-6">
            <MoleculesCard
              type="stats"
              title="Titre lorem ipsum"
              :candidates-processed="10"
              :candidates-pending="1"
              :candidates-rejected="2"
              :candidates-total="13"
            />
          </div>
        </div>

        <h2 class="text-3xl font-bold text-primary-900 mb-8 mt-8">Modal</h2>

        <div class="bg-Grey-300 rounded-lg p-8 shadow-sm">
          <h3 class="text-2xl font-semibold text-primary-700 mb-6">Modal de confirmation</h3>

          <div class="flex flex-wrap gap-4 mb-6">
            <button
              @click="showSuccessModal = true"
              class="py-2 px-4 bg-green-500 text-white rounded-lg hover:bg-green-600"
            >
              Succès création
            </button>
            <button
              @click="showPublishedModal = true"
              class="py-2 px-4 bg-blue-500 text-white rounded-lg hover:blue-600"
            >
              Succès publication
            </button>
            <button
              @click="showDeletedModal = true"
              class="py-2 px-4 bg-red-500 text-white rounded-lg hover:bg-red-600"
            >
              Succès suppression
            </button>
          </div>

          <!-- Modales -->
          <MoleculesModal
            :is-open="showSuccessModal"
            title="Annonce créée avec succès"
            message="Votre annonce a été créée et sauvegardée. Vous pouvez maintenant la publier ou la modifier."
            button-text="Parfait"
            @close="showSuccessModal = false"
          />

          <MoleculesModal
            :is-open="showPublishedModal"
            title="Annonce publiée"
            message="Votre annonce est maintenant en ligne et visible par les candidats."
            button-text="Compris"
            @close="showPublishedModal = false"
          />

          <MoleculesModal
            :is-open="showDeletedModal"
            title="Annonce supprimée"
            message="L'annonce a été définitivement supprimée de la plateforme."
            button-text="OK"
            @close="showDeletedModal = false"
          />
        </div>
      </section>

      <!-- Editor -->
      <section v-show="activeSection === 'editor'">
      <div class="bg-white rounded-lg p-8 shadow-sm mb-8">
        <h3 class="text-2xl font-semibold text-primary-700 mb-6">Editor</h3>
        <div class="bg-Grey-300 rounded-lg p-8 flex justify-center">
          <OrganismsEditor
            v-model="editorContent"
            :width="564"
            :height="247"
            placeholder="Type your message"
          />
        </div>
      </div>
      </section>

      <!-- Forms Section -->
      <section v-show="activeSection === 'forms'" class="mt-8 mb-16">
        <h2 class="text-3xl font-bold text-primary-900 mb-8">Forms</h2>

        <!-- Checkboxes -->
        <div class="bg-white rounded-lg p-8 shadow-sm mb-8">
          <h3 class="text-2xl font-semibold text-primary-700 mb-6">Checkboxes</h3>
          <div class="bg-Grey-300 rounded-lg p-8">
            <div class="space-y-6">
              <!-- Basic Examples -->
              <div>
                <h4 class="text-sm font-medium text-Grey-600 mb-4 uppercase">Basic Examples</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <!-- Non coché -->
                  <div>
                    <p class="text-xs text-Grey-500 mb-2">Non coché</p>
                    <AtomsCheckbox
                      v-model="simpleCheckbox"
                      label="Placeholder"
                      hint="Hint"
                    />
                  </div>

                  <!-- Coché -->
                  <div>
                    <p class="text-xs text-Grey-500 mb-2">Coché</p>
                    <AtomsCheckbox
                      v-model="checkedCheckbox"
                      label="Placeholder"
                      hint="Hint"
                    />
                  </div>
                </div>
              </div>

              <!-- Disabled States -->
              <div>
                <h4 class="text-sm font-medium text-Grey-600 mb-4 uppercase">Disabled States</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <!-- Disabled coché -->
                  <div>
                    <p class="text-xs text-Grey-500 mb-2">Disabled coché</p>
                    <AtomsCheckbox
                      v-model="disabledCheckedCheckbox"
                      :disabled="true"
                      label="Placeholder"
                      hint="Hint"
                    />
                  </div>
                </div>
              </div>

              <!-- Error States -->
              <div>
                <h4 class="text-sm font-medium text-Grey-600 mb-4 uppercase">Error States</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <!-- Error non coché -->
                  <div>
                    <p class="text-xs text-Grey-500 mb-2">Error non coché</p>
                    <AtomsCheckbox
                      v-model="errorCheckbox"
                      :error="true"
                      label="Placeholder"
                      hint="Hint"
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Radios -->
        <div class="bg-white rounded-lg p-8 shadow-sm mb-8">
          <h3 class="text-2xl font-semibold text-primary-700 mb-6">Radios</h3>
          <div class="bg-Grey-300 rounded-lg p-8">
            <div class="space-y-6">
              <!-- Basic Examples -->
              <div>
                <h4 class="text-sm font-medium text-Grey-600 mb-4 uppercase">Basic Examples</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <!-- Non coché -->
                  <div>
                    <p class="text-xs text-Grey-500 mb-2">Non coché</p>
                    <AtomsRadio
                      v-model="selectedRadio"
                      name="basic-radio"
                      value="option1"
                      label="Placeholder"
                      hint="Hint"
                    />
                  </div>

                  <!-- Coché -->
                  <div>
                    <p class="text-xs text-Grey-500 mb-2">Coché</p>
                    <AtomsRadio
                      v-model="selectedRadio"
                      name="basic-radio"
                      value="option2"
                      label="Placeholder"
                      hint="Hint"
                    />
                  </div>
                </div>
              </div>

              <!-- Disabled States -->
              <div>
                <h4 class="text-sm font-medium text-Grey-600 mb-4 uppercase">Disabled States</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <!-- Disabled coché -->
                  <div>
                    <p class="text-xs text-Grey-500 mb-2">Disabled coché</p>
                    <AtomsRadio
                      v-model="disabledRadio"
                      name="disabled-radio"
                      value="option1"
                      :disabled="true"
                      label="Placeholder"
                      hint="Hint"
                    />
                  </div>
                </div>
              </div>

              <!-- Error States -->
              <div>
                <h4 class="text-sm font-medium text-Grey-600 mb-4 uppercase">Error States</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <!-- Error non coché -->
                  <div>
                    <p class="text-xs text-Grey-500 mb-2">Error non coché</p>
                    <AtomsRadio
                      v-model="errorRadio"
                      name="error-radio"
                      value="option1"
                      :error="true"
                      label="Placeholder"
                      hint="Hint"
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Inputs & Selects -->
        <div class="bg-white rounded-lg p-8 shadow-sm mb-8">
          <h3 class="text-2xl font-semibold text-primary-700 mb-6">Inputs & Selects</h3>
          <div class="bg-Grey-300 rounded-lg p-8" style="min-height: 600px;">
            <div class="space-y-6">
              <!-- Basic Examples -->
              <div>
                <h4 class="text-sm font-medium text-Grey-600 mb-4 uppercase">Basic Examples</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <!-- Input avec Chevron Left -->
                  <div>
                    <p class="text-xs text-Grey-500 mb-2">Input</p>
                    <AtomsInput
                      v-model="inputWithIconLeft"
                      label="Placeholder"
                      placeholder="label"
                      hint="Hint"
                      :icon-right="true"
                    />
                  </div>

                  <!-- Input Error -->
                  <div>
                    <p class="text-xs text-Grey-500 mb-2">Input Error</p>
                    <AtomsInput
                      v-model="inputError"
                      label="Placeholder"
                      placeholder="label"
                      hint="Hint"
                      :error="true"
                    />
                  </div>

                  <!-- Select fermé -->
                  <div>
                    <p class="text-xs text-Grey-500 mb-2">Select fermé</p>
                    <AtomsSelect
                      v-model="selectValue"
                      label="Placeholder"
                      placeholder="label"
                      hint="Hint"
                      :options="selectOptions"
                    />
                  </div>

                  <!-- Select ouvert (forcé) -->
                  <div>
                    <p class="text-xs text-Grey-500 mb-2">Select ouvert</p>
                    <AtomsSelect
                      v-model="selectValueOpen"
                      label="Placeholder"
                      placeholder="label"
                      hint="Hint"
                      :options="selectOptions"
                      :force-open="true"
                    />
                  </div>

                  <!-- Search Bar -->
                  <div>
                    <p class="text-xs text-Grey-500 mb-2">Search Bar</p>
                    <AtomsSearchBar
                      v-model="searchValue"
                      placeholder="label"
                      @search="handleSearch"
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Accordions -->
        <div class="bg-white rounded-lg p-8 shadow-sm mb-8">
          <h3 class="text-2xl font-semibold text-primary-700 mb-6">Accordions</h3>
          <div class="bg-Grey-300 rounded-lg p-8">
            <div class="space-y-6">
              <!-- Accordion fermé -->
              <div>
                <p class="text-xs text-Grey-500 mb-2">Accordion (fermé)</p>
                <AtomsAccordion title="Vendredi 3 mars">
                  <AtomsButton variant="forms" size="md">08:30</AtomsButton>
                  <AtomsButton variant="forms" size="md">10:00</AtomsButton>
                  <AtomsButton variant="forms" size="md">11:15</AtomsButton>
                  <AtomsButton variant="forms" size="md">14:00</AtomsButton>
                  <AtomsButton variant="forms" size="md">15:45</AtomsButton>
                  <AtomsButton variant="forms" size="md">16:30</AtomsButton>
                </AtomsAccordion>
              </div>

              <!-- Accordion ouvert -->
              <div>
                <p class="text-xs text-Grey-500 mb-2">Accordion (ouvert)</p>
                <AtomsAccordion title="Vendredi 3 mars" :open="true">
                  <AtomsButton variant="forms" size="md">08:30</AtomsButton>
                  <AtomsButton variant="forms" size="md">10:00</AtomsButton>
                  <AtomsButton variant="forms" size="md">11:15</AtomsButton>
                  <AtomsButton variant="forms" size="md">14:00</AtomsButton>
                  <AtomsButton variant="forms" size="md">15:45</AtomsButton>
                  <AtomsButton variant="forms" size="md">16:30</AtomsButton>
                </AtomsAccordion>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Filter Section -->
      <section v-show="activeSection === 'filter'" class="mt-8 mb-16">
        <h2 class="text-3xl font-bold text-primary-900 mb-8">Filter</h2>

        <!-- Filter Bars -->
        <div class="bg-white rounded-lg p-8 shadow-sm mt-8">
          <h3 class="text-2xl font-semibold text-primary-700 mb-6">Filter Bar</h3>

          <!-- Barre de filtre -->
          <div class="mb-8">
            <div class="bg-Grey-300 rounded-lg p-8">
               <div class="w-full min-h-[54px] flex items-center justify-start px-4 rounded-md">
                 <MoleculesFilterBar
                   :filters="devFiltersDark"
                   variant="dark"
                   @update-filter="handleDevFilterUpdate"
                   @apply-filter="handleFilterApply"
                 />
               </div>
            </div>
          </div>

          <!-- Light Variant -->
          <div class="mb-8">
            <h4 class="text-sm font-medium text-Grey-600 mb-4 uppercase">Variant Light</h4>
            <div class="bg-Grey-300 rounded-lg p-8">
              <MoleculesFilterBar
                :filters="devFilters"
                variant="light"
                @update-filter="handleDevFilterUpdate"
                @apply-filter="handleFilterApply"
              />
            </div>
          </div>

          <!-- Dark Variant -->
          <div>
            <h4 class="text-sm font-medium text-Grey-600 mb-4 uppercase">Variant Dark</h4>
            <div class="bg-primary-700 rounded-lg p-8">
              <MoleculesFilterBar
                :filters="devFiltersDark"
                variant="dark"
                @update-filter="handleDevFilterUpdate"
                @apply-filter="handleFilterApply"
              />
            </div>
          </div>
        </div>
      </section>

      <!-- Menu Section -->
      <section v-show="activeSection === 'menus'" class="mt-8 mb-16">
        <h2 class="text-3xl font-bold text-primary-900 mb-8">Menus</h2>

        <!-- Navbar -->
        <div class="mb-12 bg-white rounded-lg p-8 shadow-sm">
          <h3 class="text-2xl font-semibold text-primary-700 mb-6">Navbar</h3>
          <div class="bg-Grey-300 rounded-lg p-8">
            <div class="relative h-[100px]">
              <div class="absolute inset-0">
                <OrganismsNavbar :is-static="true" />
              </div>
            </div>
          </div>
        </div>

        <!-- Sidebars -->
        <div class="bg-white rounded-lg p-8 shadow-sm">
          <h3 class="text-2xl font-semibold text-primary-700 mb-6">Sidebars</h3>
          <div class="bg-Grey-300 rounded-lg p-8">
            <div class="flex gap-8 justify-center">
              <div>
                <p class="text-sm font-semibold text-primary-700 mb-4 text-center">RH</p>
                <OrganismsSidebarRH active-item="accueil" :is-static="true" />
              </div>
              <div>
                <p class="text-sm font-semibold text-primary-700 mb-4 text-center">Mini RH</p>
                <OrganismsSidebarMini active-item="accueil" variant="rh" :is-static="true" />
              </div>
              <div>
                <p class="text-sm font-semibold text-primary-700 mb-4 text-center">Collaborateur</p>
                <OrganismsSidebarCollaborateur active-item="accueil" :is-static="true" />
              </div>
              <div>
                <p class="text-sm font-semibold text-primary-700 mb-4 text-center">Mini Collaborateur</p>
                <OrganismsSidebarMini active-item="accueil" variant="collaborateur" :is-static="true" />
              </div>
            </div>
          </div>
        </div>

        <!-- Tabs -->
        <div class="bg-white rounded-lg p-8 shadow-sm">
          <h3 class="text-2xl font-semibold text-primary-700 mb-6">Tabs</h3>
          <div class="bg-Grey-300 rounded-lg p-8">
            <div class="space-y-8">
              <!-- Items individuels -->
              <div>
                <h4 class="text-sm font-medium text-Grey-600 mb-4 uppercase">Items individuels</h4>
                <div class="flex gap-4 items-center justify-center">
                  <div>
                    <p class="text-xs text-Grey-500 mb-2 text-center">Default</p>
                    <AtomsTabItem label="Text" variant="default" />
                  </div>
                  <div>
                    <p class="text-xs text-Grey-500 mb-2 text-center">Active</p>
                    <AtomsTabItem label="Text" variant="active" />
                  </div>
                </div>
              </div>

              <!-- Menu secondaire -->
              <div>
                <h4 class="text-sm font-medium text-Grey-600 mb-4 uppercase">Menu secondaire</h4>
                <div class="flex justify-center">
                  <MoleculesSecondaryMenu
                    :items="[
                      { id: 'item1', label: 'Text' },
                      { id: 'item2', label: 'Text' },
                      { id: 'item3', label: 'Text' },
                      { id: 'item4', label: 'Text' }
                    ]"
                    @change="(event) => console.log('Menu changed:', event)"
                  />
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Pagination Section -->
      <section v-show="activeSection === 'pagination'" class="mt-8 mb-16">
        <h2 class="text-3xl font-bold text-primary-900 mb-8">Pagination</h2>

        <div class="bg-white rounded-lg p-8 shadow-sm">
          <h3 class="text-2xl font-semibold text-primary-700 mb-6">Basic Pagination</h3>
          <div class="bg-Grey-300 rounded-lg p-8 flex justify-center">
            <MoleculesPagination
              :current-page="currentPaginationPage"
              :total-pages="10"
              @page-change="currentPaginationPage = $event"
            />
          </div>
          <p class="text-sm text-Grey-500 mt-4">Page actuelle: {{ currentPaginationPage }}</p>
        </div>
      </section>

      <!-- Steps & Stepper Section -->
      <section v-show="activeSection === 'steps'" class="mt-8 mb-16">
        <h2 class="text-3xl font-bold text-primary-900 mb-8">Steps & Stepper</h2>

        <!-- Steps individuels -->
        <div class="mb-12 bg-white rounded-lg p-8 shadow-sm">
          <h3 class="text-2xl font-semibold text-primary-700 mb-6">Steps</h3>
          <div class="bg-Grey-300 rounded-lg p-8">
            <div class="flex gap-8 justify-center items-start">
              <div>
                <p class="text-xs text-Grey-500 mb-4 text-center">Default</p>
                <AtomsStep :step-number="1" label="Step" />
              </div>
              <div>
                <p class="text-xs text-Grey-500 mb-4 text-center">Active</p>
                <AtomsStep :step-number="1" label="Step" :is-active="true" />
              </div>
              <div>
                <p class="text-xs text-Grey-500 mb-4 text-center">Completed</p>
                <AtomsStep :step-number="1" label="Step" :is-completed="true" />
              </div>
            </div>
          </div>
        </div>

        <!-- Stepper complet -->
        <div class="bg-white rounded-lg p-8 shadow-sm">
          <h3 class="text-2xl font-semibold text-primary-700 mb-6">Stepper</h3>
          <div class="bg-Grey-300 rounded-lg p-8">
            <div class="flex justify-center">
              <MoleculesStepper
                :steps="[
                  'Intitulé et contexte',
                  'Compétences techniques',
                  'Compétences comportementales',
                  'Contrat et temps de travail',
                ]"
              />
            </div>
          </div>
        </div>

        <h2 class="text-3xl font-bold text-primary-900 mb-8 mt-8">Charts</h2>

        <div class="grid grid-cols-1 gap-8">
          <!-- Doughnut Chart -->
          <div class="bg-white rounded-lg p-8 shadow-sm">
            <h3 class="text-2xl font-semibold text-primary-700 mb-6">Doughnut Chart</h3>
            <div class="bg-Grey-300 rounded-lg p-8 flex flex-col gap-10 justify-center">
              <ClientOnly>
                <MoleculesDoughnutChart
                  :series="[73, 14, 13]"
                  :labels="['En poste', 'Arrivées', 'Départs']"
                  :colors="['#1CAB78', '#55C3E9', '#F07F47']"
                  center-value="50"
                  center-label="Collaborateurs"
                />
              </ClientOnly>
              <ClientOnly>
                <MoleculesProgressRingChart
                  :percentage="73"
                  center-value="50"
                  center-label="Collaborateurs"
                  :stroke-width="22"
                />
              </ClientOnly>
            </div>
          </div>

          <!-- Bar Chart -->
          <div class="bg-white rounded-lg p-8 shadow-sm">
            <h3 class="text-2xl font-semibold text-primary-700 mb-6">Bar Chart DISC</h3>
            <div class="bg-Grey-300 rounded-lg p-8 flex justify-center">
              <ClientOnly>
                <MoleculesBarChart
                  :series="[2, 45, 78, 65]"
                  :labels="['D', 'I', 'S', 'C']"
                  :colors="['#EB5035', '#FFD83B', '#45CA24', '#476EF6']"
                />
              </ClientOnly>
            </div>
          </div>

          <!-- Multiple Bar Chart -->
          <div class="bg-white rounded-lg p-8 shadow-sm">
            <h3 class="text-2xl font-semibold text-primary-700 mb-6">Multiple Bar Chart</h3>
            <div class="bg-Grey-300 rounded-lg p-8 flex justify-center">
              <ClientOnly>
                <MoleculesMultipleBarChart
                  :series="[
                    { name: 'Income', data: [30, 45, 60, 40] },
                    { name: 'Outcome', data: [20, 35, 50, 30] }
                  ]"
                  :labels="['Gestion de projet', 'SEO/SEA', 'Gestion des réseaux sociaux', 'CRM & Emailing']"
                  :colors="['#3A3B99', '#3A3B9933']"
                />
              </ClientOnly>
            </div>
          </div>

          <!-- Progress Bar -->
          <div class="bg-white rounded-lg p-8 shadow-sm">
            <h3 class="text-2xl font-semibold text-primary-700 mb-6">Progress Bar</h3>
            <div class="bg-Grey-300 rounded-lg p-8 flex flex-col gap-8">
              <div>
                <p class="text-sm text-primary-900 mb-3">Progress 25%</p>
                <MoleculesProgressBar :percentage="25" label="Étape 1" />
              </div>
              <div>
                <p class="text-sm text-primary-900 mb-3">Progress 50%</p>
                <MoleculesProgressBar :percentage="50" label="Étape 2" />
              </div>
              <div>
                <p class="text-sm text-primary-900 mb-3">Progress 75%</p>
                <MoleculesProgressBar :percentage="75" label="Étape 3" />
              </div>
              <div>
                <p class="text-sm text-primary-900 mb-3">Progress 100%</p>
                <MoleculesProgressBar :percentage="100" label="Complété" />
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Table Section -->
      <section v-show="activeSection === 'tables'" class="mt-8 mb-16">
        <h2 class="text-3xl font-bold text-primary-900 mb-8">Tables</h2>

        <div class="bg-Grey-300 rounded-lg p-8 shadow-sm">
          <h3 class="text-2xl font-semibold text-primary-700 mb-6">Table basique</h3>

          <div class="mb-8">
            <MoleculesTable
              :data="tableData"
              :columns="tableColumns"
              variant="default"
              hoverable
              :sortable="true"
              :default-sort="{ key: 'nom', order: 'asc' }"
              @sort-change="handleSortChange"
            />
          </div>
        </div>
      </section>

      <!-- Tags Section -->
      <section v-show="activeSection === 'tags'" class="mt-8 mb-16">
        <h2 class="text-3xl font-bold text-primary-900 mb-8">Tags</h2>

        <div class="bg-Grey-300 rounded-lg p-8 shadow-sm">
          <!-- Statut Section -->
          <div class="mb-8">
            <h3 class="text-2xl font-semibold text-primary-700 mb-6">Statut</h3>
            <div class="flex flex-wrap gap-4">
              <div>
                <p class="text-xs text-Grey-500 mb-2">Validé</p>
                <AtomsTag variant="solid" color="primary" size="md" status-color="green">Tag</AtomsTag>
              </div>
              <div>
                <p class="text-xs text-Grey-500 mb-2">En cours</p>
                <AtomsTag variant="solid" color="primary" size="md" status-color="orange">Tag</AtomsTag>
              </div>
              <div>
                <p class="text-xs text-Grey-500 mb-2">Brouillon</p>
                <AtomsTag variant="solid" color="primary" size="md" status-color="yellow">Tag</AtomsTag>
              </div>
            </div>
          </div>

          <!-- Solid Tags -->
          <div class="mb-8">
            <h3 class="text-2xl font-semibold text-primary-700 mb-6">Solid</h3>

            <!-- Medium Tags -->
            <div class="mb-8">
              <h4 class="text-sm font-medium text-Grey-600 mb-4 uppercase">Medium</h4>
              <div class="flex flex-wrap gap-4">
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Primary</p>
                  <AtomsTag variant="solid" color="primary" size="md" status-color="green">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Secondary</p>
                  <AtomsTag variant="solid" color="secondary" size="md" status-color="green">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Green</p>
                  <AtomsTag variant="solid" color="green" size="md" status-color="green">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Orange</p>
                  <AtomsTag variant="solid" color="orange" size="md" status-color="green">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Yellow</p>
                  <AtomsTag variant="solid" color="yellow" size="md" status-color="green">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Black</p>
                  <AtomsTag variant="solid" color="black" size="md" status-color="green">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">White</p>
                  <AtomsTag variant="solid" color="white" size="md" status-color="green">Tag</AtomsTag>
                </div>
              </div>
            </div>

            <!-- Large Tags -->
            <div>
              <h4 class="text-sm font-medium text-Grey-600 mb-4 uppercase">Large</h4>
              <div class="flex flex-wrap gap-4">
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Primary</p>
                  <AtomsTag variant="solid" color="primary" size="lg" status-color="green">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Secondary</p>
                  <AtomsTag variant="solid" color="secondary" size="lg" status-color="green">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Green</p>
                  <AtomsTag variant="solid" color="green" size="lg" status-color="green">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Orange</p>
                  <AtomsTag variant="solid" color="orange" size="lg" status-color="green">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Yellow</p>
                  <AtomsTag variant="solid" color="yellow" size="lg" status-color="green">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Black</p>
                  <AtomsTag variant="solid" color="black" size="lg" status-color="green">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">White</p>
                  <AtomsTag variant="solid" color="white" size="lg" status-color="green">Tag</AtomsTag>
                </div>
              </div>
            </div>
          </div>          <!-- Soft Tags -->
          <div class="mb-8">
            <h3 class="text-2xl font-semibold text-primary-700 mb-6">Soft</h3>

            <!-- Medium Soft -->
            <div class="mb-6">
              <h4 class="text-sm font-medium text-Grey-600 mb-4 uppercase">Medium</h4>
              <div class="flex flex-wrap gap-4">
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Primary</p>
                  <AtomsTag variant="soft" color="primary" size="md" status-color="green">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Secondary</p>
                  <AtomsTag variant="soft" color="secondary" size="md" status-color="green">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Green</p>
                  <AtomsTag variant="soft" color="green" size="md" status-color="green">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Orange</p>
                  <AtomsTag variant="soft" color="orange" size="md" status-color="green">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Yellow</p>
                  <AtomsTag variant="soft" color="yellow" size="md" status-color="green">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Black</p>
                  <AtomsTag variant="soft" color="black" size="md" status-color="green">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">White</p>
                  <AtomsTag variant="soft" color="white" size="md" status-color="green">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">IA</p>
                  <AtomsTag variant="soft" color="purple" size="md">Tag</AtomsTag>
                </div>
              </div>
            </div>

            <!-- Large Soft -->
            <div>
              <h4 class="text-sm font-medium text-Grey-600 mb-4 uppercase">Large</h4>
              <div class="flex flex-wrap gap-4">
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Primary</p>
                  <AtomsTag variant="soft" color="primary" size="lg" status-color="green">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Secondary</p>
                  <AtomsTag variant="soft" color="secondary" size="lg" status-color="green">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Green</p>
                  <AtomsTag variant="soft" color="green" size="lg" status-color="green">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Orange</p>
                  <AtomsTag variant="soft" color="orange" size="lg" status-color="green">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Yellow</p>
                  <AtomsTag variant="soft" color="yellow" size="lg" status-color="green">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Black</p>
                  <AtomsTag variant="soft" color="black" size="lg" status-color="green">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">White</p>
                  <AtomsTag variant="soft" color="white" size="lg" status-color="green">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">IA</p>
                  <AtomsTag variant="soft" color="purple" size="lg">Tag</AtomsTag>
                </div>
              </div>
            </div>
          </div>

          <!-- Stroke Tags -->
          <div class="mb-8">
            <h3 class="text-2xl font-semibold text-primary-700 mb-6">Stroke</h3>

            <!-- Medium Stroke -->
            <div class="mb-6">
              <h4 class="text-sm font-medium text-Grey-600 mb-4 uppercase">Medium</h4>
              <div class="flex flex-wrap gap-4">
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Primary</p>
                  <AtomsTag variant="stroke" color="primary" size="md" status-color="green">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Secondary</p>
                  <AtomsTag variant="stroke" color="secondary" size="md" status-color="green">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Green</p>
                  <AtomsTag variant="stroke" color="green" size="md" status-color="green">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Orange</p>
                  <AtomsTag variant="stroke" color="orange" size="md" status-color="green">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Yellow</p>
                  <AtomsTag variant="stroke" color="yellow" size="md" status-color="green">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Black</p>
                  <AtomsTag variant="stroke" color="black" size="md" status-color="green">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">White</p>
                  <AtomsTag variant="stroke" color="white" size="md" status-color="green">Tag</AtomsTag>
                </div>
              </div>
            </div>

            <!-- Large Stroke -->
            <div>
              <h4 class="text-sm font-medium text-Grey-600 mb-4 uppercase">Large</h4>
              <div class="flex flex-wrap gap-4">
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Primary</p>
                  <AtomsTag variant="stroke" color="primary" size="lg" status-color="green">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Secondary</p>
                  <AtomsTag variant="stroke" color="secondary" size="lg" status-color="green">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Green</p>
                  <AtomsTag variant="stroke" color="green" size="lg" status-color="green">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Orange</p>
                  <AtomsTag variant="stroke" color="orange" size="lg" status-color="green">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Yellow</p>
                  <AtomsTag variant="stroke" color="yellow" size="lg" status-color="green">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Black</p>
                  <AtomsTag variant="stroke" color="black" size="lg" status-color="green">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">White</p>
                  <AtomsTag variant="stroke" color="white" size="lg" status-color="green">Tag</AtomsTag>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import BadgeIA from '~/components/atoms/BadgeIA.vue'
import AtomsTag from '~/components/atoms/Tag.vue'
import {
  Pencil as LucidePencil,
  FileQuestion as LucideFileQuestion,
  Network as LucideNetwork
} from 'lucide-vue-next'

// Navigation principale
const activeSection = ref('fondation')
const navigationItems = [
  { id: 'fondation', label: 'Foundation' },
  { id: 'alertes', label: 'Alerts' },
  { id: 'blocks', label: 'Blocs' },
  { id: 'boutons', label: 'Button' },
  { id: 'cards', label: 'Cards' },
  { id: 'editor', label: 'Editor' },
  { id: 'forms', label: 'Forms' },
  { id: 'filter', label: 'Filter' },
  { id: 'menus', label: 'Menu' },
  { id: 'pagination', label: 'Pagination' },
  { id: 'steps', label: 'Steps & graph' },
  { id: 'tables', label: 'Tables' },
  { id: 'tags', label: 'Tags' },
]

// Variables pour les modales
const showSuccessModal = ref(false)
const showPublishedModal = ref(false)
const showDeletedModal = ref(false)

// Variables pour les tables
const tableData = ref([
  { 
    id: 1, 
    nom: 'Jean Dupont', 
    age: 45, 
    adresse: 'Paris 15e arrondissement', 
    email: 'jean.dupont@email.com', 
    status: { text: 'Actif', variant: 'solid', color: 'green' },
    actions: [
      { key: 'access', label: '>', variant: 'primary', handler: (row) => console.log('Accès:', row) }
    ]
  },
  { 
    id: 2, 
    nom: 'Marie Martin', 
    age: 27, 
    adresse: 'Lyon 3e arrondissement', 
    email: 'marie.martin@email.com', 
    status: { text: 'En attente', variant: 'soft', color: 'orange' },
    actions: [
      { key: 'access', label: '>', variant: 'primary', handler: (row) => console.log('Accès:', row) }
    ]
  },
  { 
    id: 3, 
    nom: 'Pierre Bernard', 
    age: 31, 
    adresse: 'Marseille 2e arrondissement', 
    email: 'pierre.bernard@email.com', 
    status: { text: 'Inactif', variant: 'soft', color: 'black' },
    actions: [
      { key: 'access', label: '>', variant: 'primary', handler: (row) => console.log('Accès:', row) }
    ]
  },
  { 
    id: 4, 
    nom: 'Sophie Laurent', 
    age: 38, 
    adresse: 'Toulouse centre-ville', 
    email: 'sophie.laurent@email.com', 
    status: { text: 'Validé', variant: 'stroke', color: 'primary', statusColor: 'green' },
    actions: [
      { key: 'access', label: '>', variant: 'primary', handler: (row) => console.log('Accès:', row) }
    ]
  },
  { 
    id: 5, 
    nom: 'Thomas Petit', 
    age: 29, 
    adresse: 'Nice vieille ville', 
    email: 'thomas.petit@email.com', 
    status: { text: 'Suspendu', variant: 'solid', color: 'yellow' },
    actions: [
      { key: 'access', label: '>', variant: 'primary', handler: (row) => console.log('Accès:', row) }
    ]
  }
])

const tableColumns = ref([
  { key: 'nom', label: 'NOM', type: 'text', cellClass: 'font-medium' },
  { key: 'age', label: 'ÂGE', type: 'text' },
  { key: 'adresse', label: 'ADRESSE', type: 'text' },
  { key: 'email', label: 'EMAIL', type: 'text', cellClass: 'text-secondary-500', sortable: false },
  { key: 'status', label: 'STATUS', type: 'tag' },
  { key: 'actions', label: 'ACCES', type: 'action', headerClass: 'text-center', cellClass: 'text-center' }
])

// Fonctions pour les tables
const handleDeleteRow = (data) => {
  console.log('Supprimer la ligne:', data.row)
  alert(`Suppression de ${data.row.nom}`)
}

const handleSortChange = (sortConfig) => {
  console.log('Tri changé:', sortConfig)
}

// Configuration SEO pour la page
useHead({
  title: 'Design System - Tholka',
  meta: [
    { name: 'robots', content: 'noindex, nofollow' }
  ]
})

const editorContent = ref('')

// State for pagination
const currentPaginationPage = ref(1)

// State for filter
const filterOptions = [
  { id: 'quiz', label: 'Quiz' },
  { id: 'test', label: 'Test' },
  { id: 'exam', label: 'Examen' },
  { id: 'training', label: 'Formation' }
]
const activeFilters = ref([])

// Filters for FilterBar demo
const devFilters = ref([
  {
    id: 'category',
    label: 'Catégorie',
    value: [],
    options: [
      { id: 'management', label: 'Management & Leadership' },
      { id: 'behavioral', label: 'Compétences comportementales' },
      { id: 'performance', label: 'Performance & Organisation' },
      { id: 'tools', label: 'Outils & pratiques' },
      { id: 'rh', label: 'Ressources Humaines' },
      { id: 'metier', label: 'Compétences métier' },
      { id: 'developpement', label: 'Développement personnel' },
      { id: 'culture', label: 'Culture & valeurs de l’entreprise' },
    ]
  },
  {
    id: 'discProfile',
    label: 'Profil DISC',
    value: [],
    options: [
      { id: 'red', label: 'Rouge' },
      { id: 'green', label: 'Vert' },
      { id: 'yellow', label: 'Jaune' },
      { id: 'blue', label: 'Bleu' },
    ]
  },
  {
    id: 'department',
    label: 'Pôle',
    value: [],
    options: [
      { id: 'communication', label: 'Communication' },
      { id: 'finance', label: 'Comptabilité' },
      { id: 'rh', label: 'RH' },
      { id: 'it', label: 'Informatique' },
      { id: 'data', label: 'Data & Analytics' },
      { id: 'design', label: 'Designer' },
      { id: 'sav', label: 'SAV' },
      { id: 'logistic', label: 'Logistique' },
      { id: 'support', label: 'Support' },
    ]
  },
  {
    id: 'contractType',
    label: 'Type de contrat',
    value: [],
    options: [
      { id: 'cdd', label: 'CDD' },
      { id: 'cdi', label: 'CDI' },
    ]
  }
])

const devFiltersDark = ref([
  {
    id: 'category',
    label: 'Catégorie',
    value: [],
    options: [
      { id: 'management', label: 'Management & Leadership' },
      { id: 'comportemental', label: 'Compétences comportementales' },
      { id: 'performance', label: 'Performance & Organisation' },
      { id: 'outils', label: 'Outils & pratiques' },
      { id: 'rh', label: 'Ressources Humaines' },
      { id: 'metier', label: 'Compétences métier' },
      { id: 'developpement', label: 'Développement personnel' },
      { id: 'culture', label: 'Culture & valeurs de l\'entreprise' }
    ]
  },
  {
    id: 'type',
    label: 'Type de formation',
    value: [],
    options: [
      { id: 'capsule', label: 'Capsule de savoir' },
      { id: 'parcours', label: 'Parcours de formation' },
    ]
  },
  {
    id: 'modality',
    label: 'Modalité',
    value: [],
    options: [
      { id: 'in-person', label: 'Présentiel' },
      { id: 'remote', label: 'Distanciel' },
      { id: 'e-learning', label: 'E-learning' },
    ]
  }
])

const handleDevFilterUpdate = ({ id, value }) => {
  const filter = devFilters.value.find(f => f.id === id)
  if (filter) {
    filter.value = value
  }
}

const handleFilterApply = (filters) => {
  console.log('Filtres appliqués:', filters)
}

// États des checkboxes
const simpleCheckbox = ref(false)           // Non coché
const checkedCheckbox = ref(true)           // Coché
const disabledCheckedCheckbox = ref(true)   // Disabled coché
const errorCheckbox = ref(false)            // Error non coché

// États des radios
const selectedRadio = ref('option2')        // Option cochée
const disabledRadio = ref('option1')        // Disabled coché
const errorRadio = ref(null)                // Error non coché

// États des inputs et selects
const inputWithIconLeft = ref('')
const inputError = ref('')
const selectValue = ref('')
const selectValueOpen = ref('')

// État de la barre de recherche
const searchValue = ref('')

// Fonction de recherche
const handleSearch = (value) => {
  console.log('Recherche:', value)
}

// Options pour les selects
const selectOptions = [
  { value: '1', label: 'Button' },
  { value: '2', label: 'Button' },
  { value: '3', label: 'Button' },
  { value: '4', label: 'Button' },
  { value: '5', label: 'Button' }
]

// Mock data pour les événements
const mockEvents = [
  {
    day: '23',
    monthYear: 'sept. 2025',
    year: 2025,
    tagLabel: 'Tag',
    title: 'Titre lorem ispum'
  },
  {
    day: '25',
    monthYear: 'sept. 2025',
    year: 2025,
    tagLabel: 'Tag',
    title: 'Titre lorem ispum'
  },
  {
    day: '26',
    monthYear: 'sept. 2025',
    year: 2025,
    tagLabel: 'Tag',
    title: 'Titre lorem ispum'
  },
  {
    day: '28',
    monthYear: 'sept. 2025',
    year: 2025,
    tagLabel: 'Tag',
    title: 'Titre lorem ispum'
  },
  {
    day: '30',
    monthYear: 'sept. 2025',
    year: 2025,
    tagLabel: 'Tag',
    title: 'Titre lorem ispum'
  }
]

// Mock data pour les documents
const mockDocuments = [
  { label: 'Button', url: '#' },
  { label: 'Button', url: '#' },
  { label: 'Button', url: '#' }
]

// Handler pour le clic sur un document
const handleDocumentClick = (document) => {
  console.log('Document cliqué:', document)
}

// Mock data pour les congés
const mockVacations = [
  { type: 'RTT', status: 'Accepté', date: '19/11/2025' },
  { type: 'RTT', status: 'En attente', date: '19/11/2025' },
  { type: 'RTT', status: 'Refusé', date: '19/11/2025' }
]

// Mock data pour les contacts
const mockContacts = [
  { name: 'Manager', email: 'manager@enterprise.com' },
  { name: 'Service RH', email: 'rh@enterprise.com' }
]

// Mock data pour les accès rapides
const mockQuickAccess = [
  { label: 'Créer une annonce', icon: LucidePencil, color: 'secondary' },
  { label: 'Outil de ticketing', icon: LucideFileQuestion, color: 'orange' },
  { label: 'Organigramme', icon: LucideNetwork, color: 'green' }
]

// Mock data pour les annonces
const mockAnnonces = [
  {
    title: 'Chef de Projet Digital',
    contractType: 'CDI',
    imageUrl: 'https://images.unsplash.com/photo-1552664730-d307ca884978?w=300&h=200&fit=crop'
  },
  {
    title: 'Développeur Frontend Vue.js',
    contractType: 'CDI',
    imageUrl: 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=300&h=200&fit=crop'
  },
  {
    title: 'Designer UX/UI',
    contractType: 'Stage',
    imageUrl: 'https://images.unsplash.com/photo-1561070791-2526d30994b5?w=300&h=200&fit=crop'
  }
]
</script>