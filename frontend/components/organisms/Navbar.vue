<template>
  <header class="navbar" :class="{ static: isStatic }">
    <div class="navbar-container">
      <!-- Bouton Burger / Close (mobile only) -->
      <button 
        class="lg:hidden flex items-center justify-center w-10 h-10 text-primary-500 relative"
        @click="$emit('toggle-sidebar')"
        aria-label="Menu"
      >
        <Transition name="icon-rotate" mode="out-in">
          <LucideX v-if="isSidebarOpen" :size="24" :stroke-width="1.5" key="close" />
          <LucideMenu v-else :size="24" :stroke-width="1.5" key="menu" />
        </Transition>
      </button>

      <!-- Logo -->
      <div class="navbar-logo">
        <img src="~/assets/img/tholka-logo.svg" alt="Tholka" />
      </div>

      <!-- Navigation droite -->
       
      <nav class="navbar-nav">
        <!-- Bouton Accessibilité -->
        <AtomsButton variant="navbar" size="sm" class="hidden md:flex">
          Accessibilité
          <template #icon-right>
            <LucideEye :size="17" :stroke-width="1" class="text-primary-500" />
          </template>
        </AtomsButton>

        <!-- Bouton Réglages (icon-only) -->
        <AtomsButton variant="navbar" size="sm" :icon-only="true" class="hidden sm:flex">
          <template #icon-left>
            <LucideSettings :size="17" :stroke-width="1" class="text-primary-500" />
          </template>
        </AtomsButton>

        <!-- Bouton Profil (icon-only) -->
        <AtomsButton variant="navbar" size="sm" :icon-only="true" class="hidden sm:flex">
          <template #icon-left>
            <LucideUserCog :size="17" :stroke-width="1" class="text-primary-500" />
          </template>
        </AtomsButton>

        <!-- Photo de profil avec dropdown -->
        <div class="relative">
          <!-- Trigger: Avatar -->
          <button 
            type="button" 
            class="navbar-avatar"
            aria-haspopup="menu"
            :aria-expanded="isDropdownOpen"
            aria-label="Menu utilisateur"
            @click="isDropdownOpen = !isDropdownOpen"
          >
            <img 
              src="~/assets/img/rh.svg" 
              alt="Profil utilisateur"
              class="w-full h-full object-cover"
            />
          </button>

          <!-- Overlay pour fermer le dropdown -->
          <div 
            v-if="isDropdownOpen" 
            class="fixed inset-0 z-[55]" 
            @click="isDropdownOpen = false"
          ></div>

          <!-- Dropdown Menu -->
          <Transition
            enter-active-class="transition ease-out duration-200"
            enter-from-class="opacity-0 translate-y-1"
            enter-to-class="opacity-100 translate-y-0"
            leave-active-class="transition ease-in duration-150"
            leave-from-class="opacity-100 translate-y-0"
            leave-to-class="opacity-0 translate-y-1"
          >
            <div 
              v-if="isDropdownOpen"
              class="absolute right-0 top-full mt-2 min-w-48 bg-white shadow-md rounded-lg z-[60]"
              role="menu"
              aria-orientation="vertical"
            >
            <div class="p-1 space-y-0.5">
              <!-- Option Accessibilité (visible uniquement sur mobile/tablette) -->
              <a 
                href="#" 
                class="md:hidden flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-primary-900 hover:bg-primary-300 focus:outline-none"
              >
                <LucideEye :size="17" :stroke-width="1" class="text-primary-500" />
                Accessibilité
              </a>
              
              <!-- Option Réglages (visible uniquement sur mobile) -->
              <a 
                href="#" 
                class="sm:hidden flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-primary-900 hover:bg-primary-300 focus:outline-none"
              >
                <LucideSettings :size="17" :stroke-width="1" class="text-primary-500" />
                Réglages
              </a>
              
              <!-- Option Profil (visible uniquement sur mobile) -->
              <a 
                href="#" 
                class="sm:hidden flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-primary-900 hover:bg-primary-300 focus:outline-none"
              >
                <LucideUserCog :size="17" :stroke-width="1" class="text-primary-500" />
                Profil
              </a>

              <!-- Séparateur visible quand au moins une option mobile est affichée -->
              <div class="sm:hidden border-t border-Grey-300 my-1"></div>

              <!-- Options toujours visibles -->
              <a 
                href="#" 
                class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-primary-900 hover:bg-primary-300 focus:outline-none"
              >
                <LucideUser :size="17" :stroke-width="1" class="text-primary-500" />
                Mon compte
              </a>
              <a 
                href="#" 
                class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-Red-500 hover:bg-Orange-300 focus:outline-none"
                @click="isDropdownOpen = false"
              >
                <LucideLogOut :size="17" :stroke-width="1" class="text-Red-500" />
                Déconnexion
              </a>
            </div>
            </div>
          </Transition>
        </div>
      </nav>
    </div>
  </header>
</template>

<script setup>
import { ref } from 'vue'
import { 
  Menu as LucideMenu, 
  X as LucideX,
  Eye as LucideEye,
  Settings as LucideSettings,
  UserCog as LucideUserCog,
  User as LucideUser,
  LogOut as LucideLogOut
} from 'lucide-vue-next'

// État du dropdown avatar
const isDropdownOpen = ref(false)

const props = defineProps({
  isStatic: {
    type: Boolean,
    default: false
  },
  isSidebarOpen: {
    type: Boolean,
    default: false
  }
})

defineEmits(['toggle-sidebar'])
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

/* Transition fluide burger <-> croix */
.icon-rotate-enter-active,
.icon-rotate-leave-active {
  transition: all 0.2s ease;
}

.icon-rotate-enter-from {
  opacity: 0;
  transform: rotate(-90deg) scale(0.8);
}

.icon-rotate-leave-to {
  opacity: 0;
  transform: rotate(90deg) scale(0.8);
}
</style>