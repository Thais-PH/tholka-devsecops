<template>
  <div class="p-8">
    <h1 class="text-3xl font-bold mb-4">Liste des Annonces</h1>
    
    <div v-if="pending" class="text-gray-500">
      Chargement des annonces...
    </div>
    
    <div v-else-if="error" class="text-red-500">
      Erreur lors du chargement des annonces : {{ error.message }}
    </div>
    
    <ul v-else-if="data && data.data" class="list-disc pl-5">
      <li v-for="annonce in data.data" :key="annonce.id">
        {{ annonce.attributes.title }}
      </li>
    </ul>

    <div v-else>
      Aucune annonce trouvée.
    </div>
  </div>
</template>

<script setup>
// URL de notre API Drupal (remarquez http://localhost:8080)
const drupalApiUrl = 'http://localhost:8080/jsonapi/node/page';

// On utilise useFetch, l'outil de Nuxt pour faire des appels API
// Il gère automatiquement le chargement (pending), les erreurs (error), et les données (data)
const { data, pending, error } = await useFetch(drupalApiUrl, {
  server: false, // Important : on fait l'appel côté client pour que le CORS soit testé
});
</script>