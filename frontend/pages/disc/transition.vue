<template>
  <div class="flex items-center justify-center w-full min-h-screen bg-secondary-300">
    <video
      ref="videoElement"
      class="w-auto h-auto max-w-full max-h-screen"
      autoplay
      @ended="handleVideoEnded"
    >
      <source :src="videoSource" type="video/mp4" />
      Votre navigateur ne supporte pas la lecture vidéo.
    </video>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const videoElement = ref<HTMLVideoElement | null>(null)
const answers = ref<string[]>([])

// Calcul du profil dominant
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

// Mapping des vidéos selon le profil dominant
const videoSource = computed(() => {
  const videoMap: { [key: string]: string } = {
    D: new URL('~/assets/videos/reveal rouge.mp4', import.meta.url).href,    // Dominance - Red
    I: new URL('~/assets/videos/reveal jaune.mp4', import.meta.url).href,    // Influence - Yellow
    S: new URL('~/assets/videos/reveal vert.mp4', import.meta.url).href,     // Stabilité - Green
    C: new URL('~/assets/videos/reveal bleu.mp4', import.meta.url).href      // Conformité - Blue
  }
  console.log('Profil dominant:', dominantProfile.value, 'Vidéo:', videoMap[dominantProfile.value])
  return videoMap[dominantProfile.value] || new URL('~/assets/videos/reveal bleu.mp4', import.meta.url).href
})

const handleVideoEnded = () => {
  console.log('Vidéo terminée, redirection vers résultats')
  router.push('/disc/result')
}

onMounted(() => {
  const storedAnswers = sessionStorage.getItem('discAnswers')
  console.log('Réponses stockées:', storedAnswers)
  if (storedAnswers) {
    try {
      answers.value = JSON.parse(storedAnswers)
      console.log('Réponses parsées:', answers.value)
      // Force la lecture de la vidéo
      setTimeout(() => {
        if (videoElement.value) {
          videoElement.value.play().catch(err => {
            console.error('Erreur lors de la lecture vidéo:', err)
          })
        }
      }, 100)
    } catch (e) {
      console.error('Erreur en parsant les réponses du test DISC', e)
      router.push('/disc')
    }
  } else {
    console.log('Aucune réponse trouvée, redirection vers le test')
    router.push('/disc')
  }
})
</script>
