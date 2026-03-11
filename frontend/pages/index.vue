<script setup>
// L'URL de ton API Drupal
const drupalApiUrl = "http://83.228.218.79/jsonapi/node/article"

// On récupère les données
const { data, pending, error } = await useFetch(drupalApiUrl)

// Le JSON de Drupal met les articles dans une clé "data"
const articles = computed(() => data.value?.data || [])
</script>

<template>
  <main style="max-width: 800px; margin: 0 auto; padding: 40px; font-family: sans-serif;">
    <h1 style="color: #2c3e50; border-bottom: 2px solid #42b983; padding-bottom: 10px;">
      Tholka : Flux Drupal
    </h1>
    
    <div v-if="pending" style="font-style: italic; color: #666;">
      Récupération des données depuis Drupal...
    </div>
    
    <div v-else-if="error" style="background: #fee; color: #c00; padding: 15px; border-radius: 5px;">
      <p><strong>Erreur de connexion :</strong> {{ error.statusMessage || 'Impossible de joindre l\'API' }}</p>
    </div>

    <div v-else>
      <div v-if="articles.length === 0">
        <p>Aucun article trouvé.</p>
      </div>

      <article v-for="article in articles" :key="article.id" style="margin-top: 30px;">
        <h2 style="color: #35495e;">{{ article.attributes.title }}</h2>
        
        <div 
          v-if="article.attributes.body" 
          v-html="article.attributes.body.processed"
          style="line-height: 1.6; color: #444;"
        ></div>
        
        <hr style="border: 0; border-top: 1px solid #eee; margin-top: 20px;" />
      </article>
    </div>
  </main>
</template>