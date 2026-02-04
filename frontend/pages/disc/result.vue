<template>
  <div class="flex flex-col w-full min-h-screen bg-secondary-300">
    <OrganismsNavbar :is-sidebar-open="isSidebarOpen" @toggle-sidebar="isSidebarOpen = !isSidebarOpen" />
    <div class="flex w-full" style="margin-top: 82.73px;">
      <OrganismsSidebarCollaborateur active-item="test-disc" :is-open="isSidebarOpen" @close="isSidebarOpen = false" />

      <div class="flex flex-col items-start p-4 lg:p-[32px] gap-[20px] flex-1 lg:ml-[300px] w-full">
        <!-- Grid Responsive -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-[20px] w-full">

          <!-- Haut Gauche: Image DISC -->
          <div class="xl:col-span-2 flex items-center justify-center bg-white rounded-lg h-[300px] lg:h-full lg:min-h-[400px] p-4 lg:px-[142px] lg:py-[27px]">
            <img :src="discImage" alt="DISC Profile" class="w-full h-full object-contain" />
          </div>

          <!-- Haut Droite: Profil DISC + BarChart + Date -->
          <div class="col-span-1 flex flex-col bg-white rounded-lg h-auto lg:h-full min-h-[400px] p-4 lg:px-[23px] lg:py-0">
            <div class="flex flex-row justify-between items-center w-full pt-[16px]">
              <h5 class="text-h5 font-sans text-primary-500">Profil DISC</h5>
              <LucideBarChart4 :size="24" :stroke-width="1" class="text-Orange-500" />
            </div>
            <div class="flex-1 flex items-center justify-center w-full min-h-[350px] mt-[20px]">
              <MoleculesBarChart :series="discPercentages" :labels="['D', 'I', 'S', 'C']" />
            </div>
            <p class="font-roboto font-normal italic text-[24px] leading-normal text-center text-primary-700 pb-[16px] mt-[30px]">Date du test : {{ testDate }}</p>
          </div>

          <!-- Bas Gauche: Comportement -->
          <div class="xl:col-span-2 flex flex-col bg-white rounded-lg h-auto min-h-[299px] p-4 lg:px-[20px]">
            <h4 class="text-h4 font-sans text-primary-500 pt-[24px]">Son comportement avec les autres :</h4>
            <p class="font-roboto text-sm mt-[12px]" style="color: #050D2E;">{{ activeProfileContent.behavior }}</p>
            <h6 class="text-[18px] font-bold font-sans text-primary-500 mt-[16px]">Pour communiquer avec un profil {{ profileType }}, soyez :</h6>
            <div class="flex gap-2 flex-wrap mt-[8px]">
              <span v-for="(tag, index) in activeProfileContent.strengths" :key="index" class="px-3 py-1 rounded-[20px] text-sm font-roboto" :style="{ backgroundColor: tagBgColor, color: tagTextColor }">{{ tag }}</span>
            </div>
          </div>

          <!-- Bas Droite: Profil Summary -->
          <div class="col-span-1 flex flex-col text-white rounded-lg h-auto min-h-[299px] p-4 lg:px-[20px]" :style="{ backgroundColor: profileCardBgColor }">
            <h4 class="text-h4 font-sans pt-[24px]">{{ profileType }}</h4>
            <p class="font-roboto text-sm mt-[12px]">{{ activeProfileContent.summary }}</p>
            <AtomsButton
              class="mt-[10px]"
              variant="tertiary"
              size="lg"
              justify="start"
              :on-white="true"
              @click="router.push('/collaborateur/passeport')"
            >
              Voir mon passeport de compétences
              <template #icon-right>
                <LucideChevronRight :size="24" :stroke-width="1" />
              </template>
            </AtomsButton>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'
// Images DISC
import discD from '~/assets/img/disc-d.jpg'
import discI from '~/assets/img/disc-i.jpg'
import discS from '~/assets/img/disc-s.jpg'
import discSvg from '~/assets/img/disc-s.svg'

const router = useRouter()
const answers = ref<string[]>([])
const isSidebarOpen = ref(false)

const discCounts = computed(() => {
  const counts = { D: 0, I: 0, S: 0, C: 0 }
  answers.value.forEach((answer) => {
    if (answer && answer in counts) {
      counts[answer as keyof typeof counts]++
    }
  })

  const total = answers.value.length
  return {
    D: total > 0 ? Math.round((counts.D / total) * 100) : 0,
    I: total > 0 ? Math.round((counts.I / total) * 100) : 0,
    S: total > 0 ? Math.round((counts.S / total) * 100) : 0,
    C: total > 0 ? Math.round((counts.C / total) * 100) : 0
  }
})

const discPercentages = computed(() => [
  discCounts.value.D,
  discCounts.value.I,
  discCounts.value.S,
  discCounts.value.C
])

// Déterminer le profil dominant
const dominantProfile = computed(() => {
  const profiles = ['D', 'I', 'S', 'C']
  let maxValue = 0
  let maxProfile = 'D'

  profiles.forEach(profile => {
    const value = discCounts.value[profile as keyof typeof discCounts.value]
    if (value > maxValue) {
      maxValue = value
      maxProfile = profile
    }
  })

  return maxProfile
})

// Image selon le profil
const discImage = computed(() => {
  const images: { [key: string]: string } = {
    D: discD,
    I: discI,
    S: discSvg,
    C: discS
  }
  return images[dominantProfile.value] || discSvg
})

// Couleur et type de profil
const profileType = computed(() => {
  const profileNames: { [key: string]: string } = {
    D: 'Dominance',
    I: 'Influence',
    S: 'Stabilité',
    C: 'Conformité'
  }
  return profileNames[dominantProfile.value] || 'Profil'
})

const profileCardBgColor = computed(() => {
  const colorMap: { [key: string]: string } = {
    D: '#AA271D', // Red 700
    I: '#FCC253', // Yellow 500
    S: '#1CAB78', // Green 500
    C: '#476EF6'  // Blue Disc
  }
  return colorMap[dominantProfile.value] || '#476EF6'
})

const tagBgColor = computed(() => {
  const colorMap: { [key: string]: string } = {
    D: '#FEEAE5', // soft orange
    I: '#FEF9E7', // soft yellow
    S: '#E8F5E0', // soft green
    C: '#EDF4FF'  // soft blue
  }
  return colorMap[dominantProfile.value] || '#EBEBF5'
})

const tagTextColor = computed(() => {
  const colorMap: { [key: string]: string } = {
    D: '#EB5035', // orange-500
    I: '#FFD83B', // yellow-500
    S: '#45CA24', // green-500
    C: '#476EF6'  // Blue-disc
  }
  return colorMap[dominantProfile.value] || '#3A3B99'
})

const testDate = computed(() => {
  const today = new Date()
  const day = String(today.getDate()).padStart(2, '0')
  const month = String(today.getMonth() + 1).padStart(2, '0')
  const year = String(today.getFullYear()).slice(-2)
  return `${day}/${month}/${year}`
})

const profilesContent = {
  D: {
    behavior: "Allez droit au but, car il apprécie les décisions rapides et n'a pas besoin d'une multitude de détails pour agir. Evitez de lui imposer une structure trop rigide ou des processus trop longs qui pourraient le freiner dans son élan",
    strengths: ["Confiant", "Affirmatif", "Bref"],
    summary: "Le Dominant est une personne énergique, factuelle et orientée vers l'action. Il est tenace, extraverti et se concentre intensément sur l'atteinte des ses objectifs. Son style est direct, parfois perçu comme autoritaire ou agressif."
  },
  I: {
    behavior: "Communiquez de manière claire et ouverte, en mettant l'accent sur la vision d'ensemble et l'aspect humain. Il est sensible au charisme et apprécie les échanges qui favorisent la dynamique de groupe.",
    strengths: ["Détendu", "Vivant", "Dans l'émotion"],
    summary: "L'Influent est sociable, optimiste et solaire. Il accore une grande importance aux relations personnelles et à la convivialité. Très éloquent, il sait convaincre les autres tout en restant attaché à un fonctionnement démocratique"
  },
  S: {
    behavior: "Il a besoin de comprendre la cohérence d'un projet avant de s'engager. Evitez les changements brusques ou imprévus, car il préfère les environnements stables et routiniers plutôt que le mouvement perpétuel.",
    strengths: ["Clair", "Rassurant", "Bienveillant", "Patient"],
    summary: "Le Stable est une personne fiable, sérieuse et cohérente. Il apprécie la clarté et peut se montrer réservé ou timide lors d'un premier contact. Il est prêt à s'investir pleinement pour défendre les causes qui lui tiennent à coeur"
  },
  C: {
    behavior: "Fournissez des informations précises et détaillées pour nourrir son besoin de compréhension. Ne le brusquez pas et évitez les rapports de force, car il réagit mal à l'autorité directe. Donnez-lui le temps nécessaire pour traiter les données avant d'attendre une réponse ou une action de sa part.",
    strengths: ["Sérieux", "Professionnel", "Objectif", "Direct", "Organisé", "Précis", "Logique"],
    summary: "Le Conforme est réfléchi et analytique. Il n'agit jamais sans avoir mûrement réfléchi et analysé son environnement pour le comprendre. Il peut paraître froid ou indifférent car il privilégie la réflexion à l'émotion."
  }
}

const activeProfileContent = computed(() => {
  return profilesContent[dominantProfile.value] || profilesContent.D
})

onMounted(() => {
  // On vérifie d'abord localStorage, puis sessionStorage pour la rétrocompatibilité
  const storedAnswers = localStorage.getItem('discAnswers') || sessionStorage.getItem('discAnswers')

  if (storedAnswers) {
    try {
      const parsed = JSON.parse(storedAnswers)
      // Vérification basique que ce n'est pas un tableau vide
      if (Array.isArray(parsed) && parsed.length > 0) {
        answers.value = parsed
      } else {
        router.push('/disc')
      }
    } catch (e) {
      console.error('Erreur en parsant les réponses du test DISC', e)
      router.push('/disc') // Redirection en cas d'erreur de parsing
    }
  } else {
    router.push('/disc')
  }
})
</script>
