<template>
  <div class="flex flex-col w-full h-screen bg-secondary-300 overflow-hidden">
    <!-- Navbar -->
    <OrganismsNavbar
      variant="rh"
      :is-sidebar-open="isSidebarOpen"
      @toggle-sidebar="isSidebarOpen = !isSidebarOpen"
    />

    <!-- Main Layout -->
    <div class="flex flex-1 overflow-hidden pt-[82.73px]">
      <!-- Sidebar RH -->
      <OrganismsSidebarRH
        :is-open="isSidebarOpen"
        active-item="recrutement"
        @close="isSidebarOpen = false"
      />

      <!-- Main Content -->
      <main class="flex-1 overflow-y-auto hide-scrollbar lg:ml-[300px]">
        <div class="flex flex-col items-start px-4 md:px-8 lg:px-[52px] py-8 gap-5 w-full">
          
          <!-- Header: Breadcrumb + Secondary Menu -->
          <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-6 sm:gap-4 w-full">
            <!-- Breadcrumb -->
            <AtomsBreadcrumb :items="breadcrumbItems" />
            
            <!-- Secondary Menu -->
            <div class="shrink-0 sm:ml-auto">
              <MoleculesSecondaryMenu
                :items="menuItems"
                :default-active-index="activeTabIndex"
                @change="handleMenuChange"
              />
            </div>
          </div>

          <!-- Application Section -->
          <div class="flex flex-col justify-center items-start gap-8 w-full rounded-[20px]">
            
            <!-- Header Card -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center p-6 gap-4 w-full bg-white rounded-lg">
              <!-- Bloc gauche: Photo + Infos -->
              <div class="flex flex-row items-center gap-4">
                <!-- Photo avec icône DISC -->
                <div class="relative w-[74px] h-[74px] shrink-0">
                  <img 
                    :src="candidate.photo || '/profiles/default-avatar.png'" 
                    :alt="candidate.name"
                    class="w-full h-full object-cover rounded-lg"
                  />
                  <!-- Icône DISC -->
                  <div class="absolute flex items-center justify-center p-1 bg-white rounded-full" style="width: 27px; height: 28px; left: 51px; top: 55px;">
                    <img 
                      :src="discIconPath" 
                      alt="Profil DISC"
                      class="w-[19px] h-[20px]"
                    />
                  </div>
                </div>

                <!-- Titre et infos -->
                <div class="flex flex-col items-start gap-1">
                  <!-- Nom + Tag externe -->
                  <div class="flex flex-row items-center gap-4">
                    <h1 class="font-nunito font-bold text-2xl text-primary-500">{{ candidate.name }}</h1>
                    <AtomsTag 
                      color="primary" 
                      variant="soft" 
                      size="md"
                    >
                      {{ candidate.type }}
                    </AtomsTag>
                  </div>
                  <!-- Date de candidature -->
                  <span class="font-roboto text-sm text-primary-900/50">
                    A postulé il y a {{ candidate.daysAgo }} jours
                  </span>
                </div>
              </div>

              <!-- Tag dropdown de statut + Source -->
              <div class="flex flex-col items-start sm:items-end gap-4">
                <AtomsTagDropdown
                  v-model="selectedStatus"
                  :options="statusOptions"
                />
                <span class="font-roboto font-normal text-sm text-primary-500">
                  Source : {{ candidate.source }}
                </span>
              </div>
            </div>

            <!-- ========== ONGLET INFORMATIONS ========== -->
            <template v-if="activeTab === 'info'">
              <!-- Section Coordonnées et documents -->
              <div class="flex flex-col items-start p-4 md:p-6 gap-4 w-full bg-white rounded-lg">
                <h2 class="font-nunito font-bold text-[18px] leading-[30px] text-primary-500">Coordonnées et documents</h2>

                <!-- Adresse (pleine largeur) -->
                <AtomsInputDisplay
                  :model-value="candidate.address"
                  label="Adresse"
                  class="w-full"
                />

                <!-- Code postal / Ville -->
                <div class="flex flex-col md:flex-row items-start gap-4 w-full">
                  <AtomsInputDisplay
                    :model-value="candidate.postalCode"
                    label="Code postal"
                    class="flex-1 w-full md:w-auto"
                  />
                  <AtomsInputDisplay
                    :model-value="candidate.city"
                    label="Ville"
                    class="flex-1 w-full md:w-auto"
                  />
                </div>

                <!-- Email / Téléphone -->
                <div class="flex flex-col md:flex-row items-start gap-4 w-full">
                  <AtomsInputDisplay
                    :model-value="candidate.email"
                    label="Email"
                    copyable
                    class="flex-1 w-full md:w-auto"
                  />
                  <AtomsInputDisplay
                    :model-value="candidate.phone"
                    label="Téléphone"
                    copyable
                    class="flex-1 w-full md:w-auto"
                  />
                </div>

                <!-- CV / Lettre de motivation -->
                <div class="flex flex-col md:flex-row items-start gap-4 w-full">
                  <AtomsInputDisplay
                    label="CV"
                    file-icon
                    class="flex-1 w-full md:w-auto"
                  >
                    <span class="font-semibold">CV_TDUPUIS_2026</span><span class="font-normal">&nbsp;&nbsp;&nbsp;81,6KB</span>
                  </AtomsInputDisplay>
                  <AtomsInputDisplay
                    :model-value="candidate.coverLetter"
                    label="Lettre de motivation"
                    class="flex-1 w-full md:w-auto"
                  />
                </div>

                <!-- Réseaux sociaux / Lien -->
                <div class="flex flex-col md:flex-row items-start gap-4 w-full">
                  <AtomsInputDisplay
                    :model-value="candidate.socialNetworks"
                    label="Réseaux sociaux"
                    class="flex-1 w-full md:w-auto"
                  />
                  <AtomsInputDisplay
                    :model-value="candidate.link"
                    label="Lien"
                    class="flex-1 w-full md:w-auto"
                  />
                </div>

                <!-- Commentaire (pleine largeur, plus grande) -->
                <div class="flex flex-col gap-[15px] w-full">
                  <label class="text-base font-roboto text-primary-900">Commentaire</label>
                  <div 
                    class="flex flex-row items-start px-4 py-[14px] bg-white border border-Grey-500 rounded-lg min-h-[165px] w-full"
                  >
                    <span class="font-roboto text-base text-primary-900">
                      {{ candidate.notes || '' }}
                    </span>
                  </div>
                </div>
              </div>
            </template>

            <!-- ========== ONGLET SUIVI DE LA CANDIDATURE ========== -->
            <template v-else-if="activeTab === 'suivi'">
              <!-- Stepper horizontal -->
              <div class="flex flex-col items-start px-6 py-4 gap-4 w-full bg-white rounded-lg shadow-sm">
                <MoleculesStepper
                  :steps="trackingSteps"
                  :current-step="currentTrackingStep"
                  class="!max-w-none w-full"
                />
              </div>

              <!-- 3 cartes côte à côte -->
              <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 w-full">
                
                <!-- Card 1: Notes entretien RH -->
                <div class="flex flex-col bg-white rounded-lg border border-primary-300 overflow-hidden h-fit">
                  
                  <!-- Container 1: Title + First Note -->
                  <div class="flex flex-col px-6 py-5 gap-4">
                    <!-- Header with Title -->
                    <div class="flex flex-row justify-between items-center">
                      <h3 class="font-nunito font-bold text-[18px] leading-[22px] text-primary-500 text-center">Notes entretien RH</h3>
                      <button class="text-primary-500 hover:text-primary-700">
                        <PenSquare class="w-6 h-6" :stroke-width="1" />
                      </button>
                    </div>

                    <!-- First Note (if exists) -->
                    <div v-if="hrNotes.length > 0" class="flex flex-col gap-2">
                        <!-- Header commentaire -->
                        <div class="flex flex-row items-center justify-between">
                          <div class="flex flex-row items-center gap-4">
                            <img :src="hrNotes[0].avatar" :alt="hrNotes[0].author" class="w-6 h-6 rounded-full object-cover" />
                            <span class="font-roboto font-medium text-base text-Black">{{ hrNotes[0].author }}</span>
                          </div>
                          <span class="font-roboto font-medium text-base text-primary-900/50">{{ hrNotes[0].date }}</span>
                        </div>
                        
                        <!-- Contenu -->
                        <div class="font-roboto font-normal text-base text-primary-900/50 leading-[140%]" v-html="formatContent(hrNotes[0].content)">
                        </div>
                        
                        <!-- Actions -->
                        <div class="flex flex-row items-center gap-4 mt-2">
                          <button @click="hrNotes[0].isLiked = !hrNotes[0].isLiked">
                            <svg 
                              xmlns="http://www.w3.org/2000/svg" 
                              width="24" 
                              height="24" 
                              viewBox="0 0 24 24" 
                              fill="none" 
                              stroke="currentColor" 
                              stroke-width="1" 
                              stroke-linecap="round" 
                              stroke-linejoin="round" 
                              class="w-6 h-6 transition-colors"
                              :class="hrNotes[0].isLiked ? 'text-white fill-primary-500' : 'text-Black'" 
                            >
                              <path d="M15 5.88 14 10h5.83a2 2 0 0 1 1.92 2.56l-2.33 8A2 2 0 0 1 17.5 22H4a2 2 0 0 1-2-2v-8a2 2 0 0 1 2-2h2.76a2 2 0 0 0 1.79-1.11L12 2a3.13 3.13 0 0 1 3 3.88Z" />
                              <path d="M7 10v12" />
                            </svg>
                          </button>
                          <SmilePlus class="w-6 h-6 text-Black" :stroke-width="1" />
                          <button class="font-roboto font-medium text-base text-Black hover:text-primary-500">
                            Répondre
                          </button>
                        </div>
                    </div>
                  </div>
                  
                  <!-- Container 2: Remaining Notes -->
                  <div v-if="hrNotes.length > 1" class="flex flex-col border-t border-primary-300">
                    <div v-for="(note, index) in hrNotes.slice(1)" :key="index" class="flex flex-col px-6 py-5 gap-2 border-b border-primary-300 last:border-b-0">
                      <!-- Header commentaire -->
                      <div class="flex flex-row items-center justify-between">
                        <div class="flex flex-row items-center gap-4">
                          <img :src="note.avatar" :alt="note.author" class="w-6 h-6 rounded-full object-cover" />
                          <span class="font-roboto font-medium text-base text-Black">{{ note.author }}</span>
                        </div>
                        <span class="font-roboto font-medium text-base text-primary-900/50">{{ note.date }}</span>
                      </div>
                      
                      <!-- Contenu -->
                      <div class="font-roboto font-normal text-base text-primary-900/50 leading-[140%]" v-html="formatContent(note.content)">
                      </div>
                      
                      <!-- Actions -->
                      <div class="flex flex-row items-center gap-4 mt-2">
                        <button @click="note.isLiked = !note.isLiked">
                          <svg 
                            xmlns="http://www.w3.org/2000/svg" 
                            width="24" 
                            height="24" 
                            viewBox="0 0 24 24" 
                            fill="none" 
                            stroke="currentColor" 
                            stroke-width="1" 
                            stroke-linecap="round" 
                            stroke-linejoin="round" 
                            class="w-6 h-6 transition-colors"
                            :class="note.isLiked ? 'text-white fill-primary-500' : 'text-Black'" 
                          >
                            <path d="M15 5.88 14 10h5.83a2 2 0 0 1 1.92 2.56l-2.33 8A2 2 0 0 1 17.5 22H4a2 2 0 0 1-2-2v-8a2 2 0 0 1 2-2h2.76a2 2 0 0 0 1.79-1.11L12 2a3.13 3.13 0 0 1 3 3.88Z" />
                            <path d="M7 10v12" />
                          </svg>
                        </button>
                        <SmilePlus class="w-6 h-6 text-Black" :stroke-width="1" />
                        <button class="font-roboto font-medium text-base text-Black hover:text-primary-500">
                          Répondre
                        </button>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Card 2: Notes entretien Technique -->
                <div class="flex flex-col bg-white rounded-lg border border-primary-300 overflow-hidden h-fit">
                  
                  <!-- Container 1: Title + First Note -->
                  <div class="flex flex-col px-6 py-5 gap-4">
                    <!-- Title Line -->
                    <div class="flex flex-row justify-between items-center">
                      <h3 class="font-nunito font-bold text-[18px] leading-[22px] text-primary-500 text-center">Notes entretien technique</h3>
                      <button class="text-primary-500 hover:text-primary-700">
                        <PenSquare class="w-6 h-6" :stroke-width="1" />
                      </button>
                    </div>

                    <!-- First Note (if exists) -->
                    <div v-if="techNotes.length > 0" class="flex flex-col gap-2">
                        <!-- Header commentaire -->
                        <div class="flex flex-row items-center justify-between">
                          <div class="flex flex-row items-center gap-4">
                            <img :src="techNotes[0].avatar" :alt="techNotes[0].author" class="w-6 h-6 rounded-full object-cover" />
                            <span class="font-roboto font-medium text-base text-Black">{{ techNotes[0].author }}</span>
                          </div>
                          <span class="font-roboto font-medium text-base text-primary-900/50">{{ techNotes[0].date }}</span>
                        </div>
                        
                        <!-- Contenu -->
                        <div class="font-roboto font-normal text-base text-primary-900/50 leading-[140%]" v-html="formatContent(techNotes[0].content)">
                        </div>
                        
                        <!-- Actions -->
                        <div class="flex flex-row items-center gap-4 mt-2">
                           <button @click="techNotes[0].isLiked = !techNotes[0].isLiked">
                            <svg 
                              xmlns="http://www.w3.org/2000/svg" 
                              width="24" 
                              height="24" 
                              viewBox="0 0 24 24" 
                              fill="none" 
                              stroke="currentColor" 
                              stroke-width="1" 
                              stroke-linecap="round" 
                              stroke-linejoin="round" 
                              class="w-6 h-6 transition-colors"
                              :class="techNotes[0].isLiked ? 'text-white fill-primary-500' : 'text-Black'" 
                            >
                              <path d="M15 5.88 14 10h5.83a2 2 0 0 1 1.92 2.56l-2.33 8A2 2 0 0 1 17.5 22H4a2 2 0 0 1-2-2v-8a2 2 0 0 1 2-2h2.76a2 2 0 0 0 1.79-1.11L12 2a3.13 3.13 0 0 1 3 3.88Z" />
                              <path d="M7 10v12" />
                            </svg>
                          </button>
                          <SmilePlus class="w-6 h-6 text-Black" :stroke-width="1" />
                          <button class="font-roboto font-medium text-base text-Black hover:text-primary-500">
                            Répondre
                          </button>
                        </div>
                    </div>
                  </div>
                  
                  <!-- Container 2: Remaining Notes -->
                  <div v-if="techNotes.length > 1" class="flex flex-col border-t border-primary-300">
                    <div v-for="(note, index) in techNotes.slice(1)" :key="index" class="flex flex-col px-6 py-5 gap-2 border-b border-primary-300 last:border-b-0">
                      <!-- Header commentaire -->
                      <div class="flex flex-row items-center justify-between">
                        <div class="flex flex-row items-center gap-4">
                          <img :src="note.avatar" :alt="note.author" class="w-6 h-6 rounded-full object-cover" />
                          <span class="font-roboto font-medium text-base text-Black">{{ note.author }}</span>
                        </div>
                        <span class="font-roboto font-medium text-base text-primary-900/50">{{ note.date }}</span>
                      </div>
                      
                      <!-- Contenu -->
                      <div class="font-roboto font-normal text-base text-primary-900/50 leading-[140%]" v-html="formatContent(note.content)">
                      </div>
                      
                      <!-- Actions -->
                      <div class="flex flex-row items-center gap-4 mt-2">
                         <button @click="note.isLiked = !note.isLiked">
                          <svg 
                            xmlns="http://www.w3.org/2000/svg" 
                            width="24" 
                            height="24" 
                            viewBox="0 0 24 24" 
                            fill="none" 
                            stroke="currentColor" 
                            stroke-width="1" 
                            stroke-linecap="round" 
                            stroke-linejoin="round" 
                            class="w-6 h-6 transition-colors"
                            :class="note.isLiked ? 'text-white fill-primary-500' : 'text-Black'" 
                          >
                            <path d="M15 5.88 14 10h5.83a2 2 0 0 1 1.92 2.56l-2.33 8A2 2 0 0 1 17.5 22H4a2 2 0 0 1-2-2v-8a2 2 0 0 1 2-2h2.76a2 2 0 0 0 1.79-1.11L12 2a3.13 3.13 0 0 1 3 3.88Z" />
                            <path d="M7 10v12" />
                          </svg>
                        </button>
                        <SmilePlus class="w-6 h-6 text-Black" :stroke-width="1" />
                        <button class="font-roboto font-medium text-base text-Black hover:text-primary-500">
                          Répondre
                        </button>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Card 3: Offre -->
                <div class="flex flex-col bg-white rounded-lg border border-primary-300 overflow-hidden h-fit">
                  <!-- Header -->
                  <div class="flex flex-row justify-between items-start px-6 py-5">
                    <div class="flex flex-col gap-4">
                      <h3 class="font-nunito font-bold text-[18px] leading-[22px] text-primary-500">Offre</h3>
                      <AtomsTag color="purple" variant="soft" size="md" class="w-fit">
                        Source : CV, Michael Page, France travail, Retours d’entretien
                      </AtomsTag>
                      <p class="font-roboto text-base leading-[140%] bg-[linear-gradient(216.47deg,#3A3B99_27.08%,#7F3ADA_95.25%)] bg-clip-text text-transparent">
                        Le candidat présente une bonne adéquation au poste : compétences techniques validées, profil DISC cohérent avec le rôle et retours positifs des entretiens.
                        <br><br>
                        Une proposition de <span class="font-bold">38 000,00€</span> brut annuel serait alignée au marché et à l’expérience du candidat.
                      </p>
                    </div>
                    <button class="text-primary-500 hover:text-primary-700">
                      <PenSquare class="w-6 h-6" :stroke-width="1" />
                    </button>
                  </div>
                </div>

              </div>
            </template>

          </div>
        </div>
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { PenSquare, Lock, ThumbsUp, SmilePlus, Sparkles } from 'lucide-vue-next'

const route = useRoute()
const router = useRouter()

// État de la sidebar mobile
const isSidebarOpen = ref(false)

// Menu items (déclaré avant pour pouvoir l'utiliser dans l'initialisation)
const menuItems = [
  { id: 'info', label: 'Informations' },
  { id: 'suivi', label: 'Suivi de la candidature' }
]

// Onglet actif (info ou suivi) - initialisé depuis l'URL si présent
const getInitialTab = () => {
  const tabFromUrl = route.query.tab
  const validTabs = menuItems.map(item => item.id)
  return validTabs.includes(tabFromUrl) ? tabFromUrl : 'info'
}
const getInitialTabIndex = () => {
  const tab = getInitialTab()
  return menuItems.findIndex(item => item.id === tab)
}
const activeTab = ref(getInitialTab())
const activeTabIndex = ref(getInitialTabIndex())

// ID de la candidature depuis l'URL
const candidatureId = computed(() => route.params.id)

// Nom du candidat depuis les query params ou valeur par défaut
const candidateName = computed(() => route.query.name || 'Thomas DUPUIS')

// Données du candidat (mock - en production, récupérer depuis l'API avec candidatureId)
const candidate = ref({
  name: candidateName.value,
  firstName: candidateName.value.split(' ')[0] || 'Thomas',
  lastName: candidateName.value.split(' ').slice(1).join(' ') || 'DUPUIS',
  photo: '/profiles/profile-1.jpg',
  type: 'Test DISC passé',
  daysAgo: 10,
  source: 'Cooptation',
  email: 'thomas.dupuis@gmail.com',
  phone: '+33 7 83 40 83 25',
  cv: 'CV_TDUPUIS_2026   81,6KB',
  coverLetter: '-',
  address: '1 rue du Petit Cheval',
  postalCode: '44690',
  city: 'LA HAYE FOUASSIERE',
  familyStatus: '-',
  notes: 'Cooptation de Céline BONHOUR',
  discProfile: 'S', // D, I, S ou C
  socialNetworks: 'linkedin.com/in/thomasdupuis',
  link: '-',
})

// Chemin de l'icône DISC selon le profil
const discIconPath = computed(() => {
  const icons = {
    'D': '/icons/icon-disc-red.svg',
    'I': '/icons/icon-disc-yellow.svg',
    'S': '/icons/icon-disc-green.svg',
    'C': '/icons/icon-disc-blue.svg'
  }
  return icons[candidate.value.discProfile] || '/icons/icon-disc-green.svg'
})

// Récupérer les infos de l'offre depuis les query params
const offerTitle = computed(() => route.query.offerTitle || 'Responsable Achats')
const offerId = computed(() => route.query.offerId || '1')

// Breadcrumb items
const breadcrumbItems = computed(() => [
  { label: 'Accueil', to: '/rh' },
  { label: 'Recrutement', to: '/rh/recrutement' },
  { label: offerTitle.value, to: `/rh/recrutement/${offerId.value}` },
  { label: candidate.value.name }
])

// Options de statut dropdown
const statusOptions = [
  { value: 'active', label: 'Candidature active', color: 'green', variant: 'soft', statusColor: 'green' },
  { value: 'pending', label: 'En attente', color: 'orange', variant: 'soft', statusColor: 'orange' },
  { value: 'rejected', label: 'Refusé', color: 'primary', variant: 'soft', statusColor: 'primary' },
]

const selectedStatus = ref('active')

// Données pour l'onglet Suivi
const trackingSteps = [
  { label: 'Entretien RH', active: true },
  { label: 'Entretien technique', active: true },
  { label: 'Offre', active: false }
]
const currentTrackingStep = null // Pas de step "current" unique, on utilise la propriété active de chaque step

// Notes entretien RH
const hrNotes = ref([
  {
    avatar: '/profiles/avatar-1.jpg',
    author: 'Nathalie Leroy',
    date: '4j',
    content: `Très bon candidat, il semble répondre aux critères.
Je valide ce premier entretien.`,
    isLiked: false
  },
  {
    avatar: '/profiles/avatar-4.png',
    author: 'Thomas Lemoine',
    date: '2j',
    content: '@Nathalie, j’ai eu une bonne impression aussi mais ses prétentions salariales sont un peu élevées. Tu ne trouves pas ? ',
    isLiked: false
  },
  {
    avatar: '/profiles/avatar-1.jpg',
    author: 'Nathalie Leroy',
    date: 'À l\'instant',
    content: `@Thomas Nous verrons ça dans un second temps. 
Le retour de l’équipe métier sera peut-être différent 😁`,
    isLiked: false
  }
])

// Notes entretien Technique
const techNotes = ref([
  {
    avatar: '/profiles/profile-7.jpg',
    author: 'Claire Martin',
    date: '1j',
    content: 'Côté technique c’est bon pour moi, j’aimerai lui proposer un second entretien... Je regarde mon agenda et je vous tiens au courant.',
    isLiked: false
  },
  {
    avatar: '/profiles/avatar-1.jpg',
    author: 'Nathalie Leroy',
    date: 'À l\'instant',
    content: '@Claire Ok, merci pour ton retour ',
    isLiked: false
  }
])

// Suggestion IA pour l'offre
const aiSuggestion = ref('Sur la base de l\'entretien RH et technique, je recommande de faire une offre au candidat. Son profil DISC "S" (Stable) correspond bien à un poste de Responsable Achats nécessitant rigueur et méthode. Proposition de salaire recommandée : 52-55K€ brut annuel.')

// Gestion du changement de menu - persiste l'onglet dans l'URL
const handleMenuChange = ({ index, item }) => {
  activeTab.value = item.id
  activeTabIndex.value = index
  // Met à jour l'URL sans recharger la page (replace pour ne pas polluer l'historique)
  router.replace({ query: { ...route.query, tab: item.id } })
}

// Fonction pour formater le contenu des notes (mentions en couleur)
const formatContent = (content) => {
  if (!content) return ''
  
  // 1. Gestion des mentions (ex: @Nathalie)
  let formatted = content.replace(/(@\w+)/g, '<span class="text-primary-500">$1</span>')

  // 2. Gestion des emojis (pour éviter l'opacité du texte parent)
  // On remet la couleur à 100% d'opacité pour les emojis
  formatted = formatted.replace(/(\p{Extended_Pictographic})/gu, '<span class="text-primary-900 inline-block opacity-100">$1</span>')

  // 3. Gestion des retours à la ligne
  // Remplacement simple des sauts de ligne par des <br>
  return formatted.replace(/\n/g, '<br>')
}

// Configuration SEO pour la page
useHead({
  title: `${candidate.value.name} - Candidature - Tholka RH`
})
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
