<template>
  <div class="min-h-screen bg-Grey-100 p-8">
    <div class="max-w-7xl mx-auto">
      <!-- Header -->
      <div class="mb-12">
        <h1 class="text-4xl font-bold text-primary-900 mb-2">Design System</h1>
      </div>

      <!-- Couleurs -->
      <section class="mb-16">
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
              <div class="w-12 h-12 rounded-lg bg-primary-700 border border-Grey-300"></div>
              <div>
                <p class="text-sm font-medium text-Black">Title</p>
                <p class="text-xs text-Grey-500">#252958</p>
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
      </section>

      <!-- Typographies -->
      <section class="mb-16">
        <h2 class="text-3xl font-bold text-primary-900 mb-8">Typographies</h2>
        
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

      <!-- Boutons Section -->
      <section class="mt-8 mb-16">
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

      <!-- Menu Section -->
      <section class="mt-8 mb-16">
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
                <OrganismsSidebarRH active-item="accueil" />
              </div>
              <div>
                <p class="text-sm font-semibold text-primary-700 mb-4 text-center">Mini RH</p>
                <OrganismsSidebarMini active-item="accueil" variant="rh" />
              </div>
              <div>
                <p class="text-sm font-semibold text-primary-700 mb-4 text-center">Collaborateur</p>
                <OrganismsSidebarCollaborateur active-item="accueil" />
              </div>
              <div>
                <p class="text-sm font-semibold text-primary-700 mb-4 text-center">Mini Collaborateur</p>
                <OrganismsSidebarMini active-item="accueil" variant="collaborateur" />
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Tags Section -->
      <section class="mt-8 mb-16">
        <h2 class="text-3xl font-bold text-primary-900 mb-8">Tags</h2>
        
        <div class="bg-white rounded-lg p-8 shadow-sm">
          <!-- Solid Tags -->
          <div class="mb-8">
            <h3 class="text-2xl font-semibold text-primary-700 mb-6">Solid</h3>
            
            <!-- Medium Tags -->
            <div class="mb-8">
              <h4 class="text-sm font-medium text-Grey-600 mb-4 uppercase">Medium</h4>
              <div class="flex flex-wrap gap-4">
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Primary</p>
                  <AtomsTag variant="solid" color="primary" size="md">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Secondary</p>
                  <AtomsTag variant="solid" color="secondary" size="md">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Green</p>
                  <AtomsTag variant="solid" color="green" size="md">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Orange</p>
                  <AtomsTag variant="solid" color="orange" size="md">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Yellow</p>
                  <AtomsTag variant="solid" color="yellow" size="md">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Default</p>
                  <AtomsTag variant="solid" color="default" size="md">Tag</AtomsTag>
                </div>
              </div>
            </div>

            <!-- Large Tags -->
            <div>
              <h4 class="text-sm font-medium text-Grey-600 mb-4 uppercase">Large</h4>
              <div class="flex flex-wrap gap-4">
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Primary</p>
                  <AtomsTag variant="solid" color="primary" size="lg">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Secondary</p>
                  <AtomsTag variant="solid" color="secondary" size="lg">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Green</p>
                  <AtomsTag variant="solid" color="green" size="lg">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Orange</p>
                  <AtomsTag variant="solid" color="orange" size="lg">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Yellow</p>
                  <AtomsTag variant="solid" color="yellow" size="lg">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Default</p>
                  <AtomsTag variant="solid" color="default" size="lg">Tag</AtomsTag>
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
                  <AtomsTag variant="soft" color="primary" size="md">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Secondary</p>
                  <AtomsTag variant="soft" color="secondary" size="md">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Green</p>
                  <AtomsTag variant="soft" color="green" size="md">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Orange</p>
                  <AtomsTag variant="soft" color="orange" size="md">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Yellow</p>
                  <AtomsTag variant="soft" color="yellow" size="md">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Default</p>
                  <AtomsTag variant="soft" color="default" size="md">Tag</AtomsTag>
                </div>
              </div>
            </div>

            <!-- Large Soft -->
            <div>
              <h4 class="text-sm font-medium text-Grey-600 mb-4 uppercase">Large</h4>
              <div class="flex flex-wrap gap-4">
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Primary</p>
                  <AtomsTag variant="soft" color="primary" size="lg">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Secondary</p>
                  <AtomsTag variant="soft" color="secondary" size="lg">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Green</p>
                  <AtomsTag variant="soft" color="green" size="lg">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Orange</p>
                  <AtomsTag variant="soft" color="orange" size="lg">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Yellow</p>
                  <AtomsTag variant="soft" color="yellow" size="lg">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Default</p>
                  <AtomsTag variant="soft" color="default" size="lg">Tag</AtomsTag>
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
                  <AtomsTag variant="stroke" color="primary" size="md">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Secondary</p>
                  <AtomsTag variant="stroke" color="secondary" size="md">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Green</p>
                  <AtomsTag variant="stroke" color="green" size="md">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Orange</p>
                  <AtomsTag variant="stroke" color="orange" size="md">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Yellow</p>
                  <AtomsTag variant="stroke" color="yellow" size="md">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Default</p>
                  <AtomsTag variant="stroke" color="default" size="md">Tag</AtomsTag>
                </div>
              </div>
            </div>

            <!-- Large Stroke -->
            <div>
              <h4 class="text-sm font-medium text-Grey-600 mb-4 uppercase">Large</h4>
              <div class="flex flex-wrap gap-4">
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Primary</p>
                  <AtomsTag variant="stroke" color="primary" size="lg">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Secondary</p>
                  <AtomsTag variant="stroke" color="secondary" size="lg">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Green</p>
                  <AtomsTag variant="stroke" color="green" size="lg">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Orange</p>
                  <AtomsTag variant="stroke" color="orange" size="lg">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Yellow</p>
                  <AtomsTag variant="stroke" color="yellow" size="lg">Tag</AtomsTag>
                </div>
                <div>
                  <p class="text-xs text-Grey-500 mb-2">Default</p>
                  <AtomsTag variant="stroke" color="default" size="lg">Tag</AtomsTag>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Alertes Section -->
      <section class="mt-8 mb-16">
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
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</template>

<script setup>
import BadgeIA from '~/components/atoms/BadgeIA.vue'
import AtomsTag from '~/components/atoms/Tag.vue'
// Configuration SEO pour la page
useHead({
  title: 'Design System - Tholka',
  meta: [
    { name: 'robots', content: 'noindex, nofollow' }
  ]
})
</script>