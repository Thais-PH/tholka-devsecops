<template>
  <div class="flex flex-col w-full h-screen bg-secondary-300 overflow-hidden">
    <!-- Navbar -->
    <OrganismsNavbar
      variant="rh"
      @toggle-sidebar="isSidebarOpen = !isSidebarOpen"
    />

    <!-- Main Layout -->
    <div class="flex flex-1 overflow-hidden pt-[82.73px]">
      <!-- Sidebar Mini -->
      <OrganismsSidebarMini
        variant="rh"
        active-item="formation"
        @navigate="handleNavigation"
      />

      <!-- Main Content -->
      <main class="flex-1 overflow-y-auto hide-scrollbar">
        
        <!-- Hero Section -->
        <section class="relative w-full overflow-hidden">
          <!-- Background Image + Gradient -->
          <div class="absolute inset-0 z-0">
            <img 
              src="/annonces/background-formation.jpg" 
              alt="Formation background"
              class="w-full h-full object-cover"
            />
            <div class="absolute inset-0 bg-gradient-to-b from-[rgba(37,41,88,0)] via-[rgba(5,13,46,0.5)] to-primary-700"></div>
          </div>

          <!-- Hero Content -->
          <div class="relative z-10 flex flex-col md:flex-row justify-between items-start gap-6 px-6 md:px-16 lg:px-24 py-10 md:py-16 lg:py-24">
            <!-- Left Content -->
            <div class="flex flex-col items-start gap-4 max-w-2xl">
              <!-- Nouveau Tag -->
              <AtomsTag variant="solid" color="orange" size="sm">
                Nouveau
              </AtomsTag>

              <!-- Title -->
              <h2 class="text-h2 md:text-[40px] font-sans font-bold text-Light leading-tight">
                Découvrez notre parcours manager
              </h2>

              <!-- Description -->
              <p class="text-lg md:text-xl font-roboto text-Light/90 leading-relaxed">
                Un parcours conçu pour accompagner les collaborateurs qui souhaitent évoluer vers un rôle managérial. À travers des capsules pratiques et progressives, il développe les bases essentielles : posture, communication, gestion d’équipe et prise de décision.
              </p>

              <!-- Tags Row -->
              <div class="flex flex-wrap items-center gap-3 mt-2">
                <AtomsTag variant="soft" color="white" size="md">
                  Management & Leadership
                </AtomsTag>
                <AtomsTag variant="soft" color="white" size="md">
                  Ressources humaines
                </AtomsTag>
              </div>

              <!-- CTA Button -->
              <AtomsButton variant="primary" size="md" class="mt-4">
                Voir le parcours
              </AtomsButton>
            </div>

            <!-- Right Content: Nouvelle Formation Button -->
            <div class="flex-shrink-0">
              <AtomsButton variant="primary" size="md">
                <template #icon-left>
                  <LucidePlus :size="20" :stroke-width="1" />
                </template>
                Nouvelle formation
              </AtomsButton>
            </div>
          </div>
        </section>

        <!-- Secondary Menu Bar with Filters -->
        <section class="w-full bg-primary-700">
          <div class="flex flex-col md:flex-row justify-between items-center gap-4 px-6 md:px-16 lg:px-24 py-2">
            <!-- Navigation Tabs (optional, peut être vide ou avec des liens) -->
            <div class="flex items-center gap-6">
              <span class="text-Light font-roboto text-base cursor-pointer hover:text-secondary-500 transition-colors">
                Toutes les formations
              </span>
            </div>

            <!-- Filter Bar -->
            <MoleculesFilterBar 
              variant="dark"
              :default-category-label="'Catégorie'"
              :default-type-label="'Type de formation'"
              :default-modality-label="'Modalité'"
              @filter-change="handleFilterChange"
            />
          </div>
        </section>

        <!-- Main Body Content -->
        <div class="flex flex-col gap-16 md:gap-20 px-6 md:px-16 lg:px-24 py-10 md:py-16">
          
          <!-- Section: Top 5 des capsules les + suivies -->
          <section class="w-full">
            <h3 class="text-h3 text-primary-500 mb-6 md:mb-10">
              Top 5 des capsules les + suivies
            </h3>
            
            <!-- Horizontal Scroll Container -->
            <div class="flex overflow-x-auto pb-4 gap-10 md:gap-16 lg:gap-24 hide-scrollbar">
              <MoleculesCard 
                v-for="(capsule, index) in topCapsules" 
                :key="`top-${index}`"
                type="job"
                :order-number="index + 1"
                :title="capsule.title"
                :tag="{ text: capsule.tag, variant: 'soft', color: 'primary' }"
                :image-url="capsule.imageUrl"
                :resume="capsule.resume"
                class="flex-shrink-0"
              />
            </div>
          </section>

          <!-- Section: Nos parcours de formation -->
          <section class="w-full">
            <h3 class="text-h3 text-primary-500 mb-6 md:mb-10">
              Nos parcours de formation
            </h3>
            
            <!-- Horizontal Scroll Container -->
            <div class="flex overflow-x-auto pb-4 gap-6 md:gap-10 hide-scrollbar">
              <MoleculesCard 
                v-for="(parcours, index) in parcoursList" 
                :key="`parcours-${index}`"
                type="job"
                :title="parcours.title"
                :tag="{ text: parcours.tag, variant: 'soft', color: 'primary' }"
                :image-url="parcours.imageUrl"
                :resume="parcours.resume"
                class="flex-shrink-0"
              />
            </div>
          </section>

          <!-- Section: Nos capsules de savoir -->
          <section class="w-full">
            <h3 class="text-h3 text-primary-500 mb-6 md:mb-10">
              Nos capsules de savoir
            </h3>
            
            <!-- Horizontal Scroll Container -->
            <div class="flex overflow-x-auto pb-4 gap-6 md:gap-10 hide-scrollbar">
              <MoleculesCard 
                v-for="(capsule, index) in capsulesList" 
                :key="`capsule-${index}`"
                type="job"
                :title="capsule.title"
                :tag="{ text: capsule.tag, variant: 'soft', color: 'primary' }"
                :image-url="capsule.imageUrl"
                :resume="capsule.resume"
                class="flex-shrink-0"
              />
            </div>
          </section>

        </div>
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { Plus as LucidePlus } from 'lucide-vue-next'
import { useRouter } from 'vue-router'

useHead({
  title: 'Formation - Tholka RH',
})

const router = useRouter()

// État de la sidebar mobile (pour la navbar)
const isSidebarOpen = ref(false)

// Navigation depuis la sidebar mini
const handleNavigation = (itemId) => {
  const routes = {
    accueil: '/rh',
    equipe: '/rh/equipe',
    recrutement: '/rh/recrutement',
    mobilite: '/rh/mobilite',
    bienetre: '/rh/bienetre',
    administration: '/rh/administration',
    remuneration: '/rh/remuneration',
    formation: '/rh/formation'
  }
  if (routes[itemId]) {
    router.push(routes[itemId])
  }
}

// Gestion des filtres
const handleFilterChange = (filters) => {
  console.log('Filtres changés:', filters)
  // Ici on pourrait filtrer les données
}

// Données pour Top 5 des capsules
const topCapsules = [
  {
    title: 'Gestion des conflits',
    tag: 'Compétences comportementales',
    resume: 'Identifier et désamorcer les tensions au bon moment.',
    imageUrl: '/annonces/capsule-1.jpg'
  },
  {
    title: 'Communiquer avec un profil DISC',
    tag: 'Compétences comportementales',
    resume: 'Comment s\'adapter efficacement aux besoins communicatifs des interlocuteurs ?',
    imageUrl: '/annonces/capsule-2.jpg'
  },
  {
    title: 'Maîtriser les bases d\'Excel',
    tag: 'Outils & pratiques',
    resume: 'Allez plus loin avec les tableaux, les formules et les tableaux croisés dynamiques',
    imageUrl: '/annonces/capsule-3.jpg'
  },
  {
    title: 'Communication assertive',
    tag: 'Compétences comportementales',
    resume: 'S’exprimer clairement tout en respectant son interlocuteur.',
    imageUrl: '/annonces/capsule-4.jpg'
  },
  {
    title: 'Motiver son équipe au quotidien',
    tag: 'Management & Leadership',
    resume: 'Identifier et activer les leviers de motivation.',
    imageUrl: '/annonces/capsule-5.jpg'
  }
]

// Données pour Nos parcours de formation
const parcoursList = [
  {
    title: 'Parcours Manager',
    tag: 'Parcours complet',
    resume: 'Un parcours complet pour réussir votre prise de poste.',
    imageUrl: '/annonces/parcours-1.jpg'
  },
  {
    title: 'Parcours Commercial',
    tag: 'Parcours complet',
    resume: 'Développez vos compétences commerciales.',
    imageUrl: '/annonces/parcours-2.jpg'
  },
  {
    title: 'Parcours RH',
    tag: 'Parcours complet',
    resume: 'Maîtrisez les fondamentaux des Ressources Humaines.',
    imageUrl: '/annonces/parcours-3.jpg'
  },
  {
    title: 'Parcours Digital',
    tag: 'Parcours complet',
    resume: 'Transformez-vous en acteur du digital.',
    imageUrl: '/annonces/parcours-4.jpg'
  }
]

// Données pour Nos capsules de savoir
const capsulesList = [
  {
    title: 'Excel niveau avancé',
    tag: 'Bureautique',
    resume: 'Maîtrisez les fonctions avancées d\'Excel.',
    imageUrl: '/annonces/savoir-1.jpg'
  },
  {
    title: 'Prise de parole en public',
    tag: 'Communication',
    resume: 'Gagnez en aisance face à votre audience.',
    imageUrl: '/annonces/savoir-2.jpg'
  },
  {
    title: 'Gestion des conflits',
    tag: 'Soft skills',
    resume: 'Apprenez à désamorcer les situations tendues.',
    imageUrl: '/annonces/savoir-3.jpg'
  },
  {
    title: 'Intelligence émotionnelle',
    tag: 'Développement personnel',
    resume: 'Développez votre QE pour mieux collaborer.',
    imageUrl: '/annonces/savoir-4.jpg'
  },
  {
    title: 'Conduite du changement',
    tag: 'Management',
    resume: 'Accompagnez vos équipes dans les transitions.',
    imageUrl: '/annonces/savoir-5.jpg'
  }
]
</script>

<style scoped>
.hide-scrollbar {
  -ms-overflow-style: none;
  scrollbar-width: none;
}
.hide-scrollbar::-webkit-scrollbar {
  display: none;
}
</style>
