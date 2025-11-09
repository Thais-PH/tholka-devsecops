<template>
  <header class="navbar" :class="{ static: isStatic }">
    <div class="navbar-container">
      <!-- Logo -->
      <div class="navbar-logo">
        <img src="~/assets/img/tholka-logo.svg" alt="Tholka" />
      </div>

      <!-- Navigation droite -->
       
      <nav class="navbar-nav">
        <!-- Bouton Accessibilité -->
        <AtomsButton variant="navbar" size="sm">
          Accessibilité
          <template #icon-right>
            <LucideEye :size="17" :stroke-width="1" class="text-secondary-500" />
          </template>
        </AtomsButton>

        <!-- Bouton Réglages (icon-only) -->
        <AtomsButton variant="navbar" size="sm" :icon-only="true">
          <template #icon-left>
            <LucideSettings :size="17" :stroke-width="1" class="text-secondary-500" />
          </template>
        </AtomsButton>

        <!-- Bouton Profil (icon-only) -->
        <AtomsButton variant="navbar" size="sm" :icon-only="true">
          <template #icon-left>
            <LucideUserCog :size="17" :stroke-width="1" class="text-secondary-500" />
          </template>
        </AtomsButton>

        <!-- Photo de profil -->
        <div class="navbar-avatar">
          <img 
            src="~/assets/img/rh.svg" 
            alt="Profil utilisateur"
            class="w-full h-full object-cover"
          />
        </div>
      </nav>
    </div>
  </header>
</template>

<script setup>
const props = defineProps({
  isStatic: {
    type: Boolean,
    default: false
  }
})
</script>

<style scoped>
.navbar {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  z-index: 50;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  padding: 8px 32px;
  height: 82.73px;
  background: #FFFFFF;
  box-shadow: 0px -1px 4px rgba(0, 0, 0, 0.2);
}

.navbar.static {
  position: relative;
}

.navbar-container {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  align-items: center;
  width: 100%;
  max-width: 1664px;
  height: 66.73px;
}

.navbar-logo {
  display: flex;
  flex-direction: row;
  align-items: center;
  width: 110px;
  height: 62px;
}

.navbar-logo img {
  width: 100%;
  height: 100%;
  object-fit: contain;
}

.navbar-nav {
  display: flex;
  flex-direction: row;
  align-items: center;
  gap: 11.82px;
}

.navbar-nav > button:first-child {
  padding-right: 0;
  padding-left: 0;
}

.navbar-avatar {
  display: flex;
  flex-direction: row;
  justify-content: center;
  align-items: center;
  width: 33px;
  height: 32px;
  border-radius: 88px;
  overflow: hidden;
  cursor: pointer;
  transition: transform 0.2s ease;
}

.navbar-avatar:hover {
  transform: scale(1.05);
}
</style>