<template>
  <div class="flex flex-col w-full min-h-screen bg-secondary-300">
    <OrganismsNavbar />
    <div class="flex w-full" style="margin-top: 82.73px;">
      <OrganismsSidebarCollaborateur active-item="test-disc" />
      <div class="flex flex-col items-start p-[32px] gap-[20px] flex-1" style="margin-left: 300px;">
        <!-- Grid 2x2 avec proportions -->
        <div class="grid gap-[20px] w-full" style="grid-template-columns: 2fr 1fr;">
          <!-- Haut Gauche: Image DISC -->
          <div class="flex items-center justify-center bg-white rounded-lg" style="height: 500px; padding: 27px 142px;">
            <img src="~/assets/img/disc-s.svg" alt="DISC Profile" class="w-full h-full object-contain" />
          </div>

          <!-- Haut Droite: Profil DISC + BarChart + Date -->
          <div class="flex flex-col bg-white rounded-lg" style="height: 500px; padding: 0 23px;">
            <h5 class="text-h5 font-sans text-primary-500 pt-[16px]">Profil DISC</h5>
            <div class="flex-1 flex items-center justify-start pl-0">
              <MoleculesBarChart :series="discPercentages" :labels="['D', 'I', 'S', 'C']" />
            </div>
            <p class="font-roboto text-sm pb-[16px] text-center" style="color: #050D2E;">Date du test : {{ testDate }}</p>
          </div>

          <!-- Bas Gauche: Comportement -->
          <div class="flex flex-col bg-white rounded-lg" style="height: 299px; padding: 0 20px;">
            <h4 class="text-h4 font-sans text-primary-500 pt-[24px]">Comportement à adopter avec les autres :</h4>
            <p class="font-roboto text-sm mt-[12px]" style="color: #050D2E;">Description du comportement à venir</p>
            <h6 class="text-h6 font-sans text-primary-500 mt-[16px]">Points forts</h6>
            <div class="flex gap-2 flex-wrap mt-[8px]">
              <span class="px-3 py-1 rounded-[20px] text-sm font-roboto" :style="{ backgroundColor: tagBgColor, color: tagTextColor }">Tag 1</span>
              <span class="px-3 py-1 rounded-[20px] text-sm font-roboto" :style="{ backgroundColor: tagBgColor, color: tagTextColor }">Tag 2</span>
              <span class="px-3 py-1 rounded-[20px] text-sm font-roboto" :style="{ backgroundColor: tagBgColor, color: tagTextColor }">Tag 3</span>
            </div>
            <h6 class="text-h6 font-sans text-primary-500 mt-[16px]">Points à travailler</h6>
            <div class="flex gap-2 flex-wrap mt-[8px]">
              <span class="px-3 py-1 rounded-[20px] text-sm font-roboto" :style="{ backgroundColor: tagBgColor, color: tagTextColor }">Tag 4</span>
              <span class="px-3 py-1 rounded-[20px] text-sm font-roboto" :style="{ backgroundColor: tagBgColor, color: tagTextColor }">Tag 5</span>
            </div>
          </div>

          <!-- Bas Droite: Profil Summary -->
          <div class="flex flex-col text-white rounded-lg" style="height: 299px; padding: 0 20px;" :style="{ backgroundColor: profileCardBgColor }">
            <h4 class="text-h4 font-sans pt-[24px]">{{ profileType }}</h4>
            <p class="font-roboto text-sm mt-[12px]">Description du profil à venir</p>
            <a href="#" class="font-roboto text-base mt-auto pb-[24px] hover:underline">Voir mon passeport de compétences ></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const answers = ref<string[]>([])

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
    D: '#EB5035', // Red/Orange
    I: '#FFD83B', // Yellow
    S: '#45CA24', // Green
    C: '#476EF6'  // Blue
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
