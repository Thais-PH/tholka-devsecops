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
        <div class="bg-white rounded-lg p-8 shadow-sm">
          <p class="text-Grey-600">À venir</p>
        </div>
      </section>

      <!-- Typographies -->
      <section class="mb-16">
        <h2 class="text-3xl font-bold text-primary-900 mb-8">Typographies</h2>
        <div class="bg-white rounded-lg p-8 shadow-sm">
          <p class="text-Grey-600">À venir</p>
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

      <!-- Steps & Stepper Section -->
      <section class="mt-8 mb-16">
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
      </section>
    </div>
  </div>
</template>

<script setup>
import BadgeIA from '~/components/atoms/BadgeIA.vue'
// Configuration SEO pour la page
useHead({
  title: 'Design System - Tholka',
  meta: [
    { name: 'robots', content: 'noindex, nofollow' }
  ]
})
</script>