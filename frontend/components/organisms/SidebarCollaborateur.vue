<template>
  <!-- Overlay mobile -->
  <div 
    v-if="isOpen" 
    :class="['fixed inset-0 bg-black/50 z-40', wideBreakpoint ? '3xl:hidden' : 'lg:hidden']"
    @click="$emit('close')"
  ></div>
  
  <aside 
    class="sidebar-collaborateur"
    :class="{ 'is-open': isOpen, 'is-static': isStatic, 'wide-breakpoint': wideBreakpoint }"
  >
    <nav class="sidebar-nav">
      <NuxtLink
        v-for="item in menuItems"
        :key="item.id"
        :to="item.route"
        class="menu-link-wrapper"
      >
        <AtomsButton
          variant="menu"
          size="md"
          class="menu-item"
          :class="{ 'is-active': activeItem === item.id }"
        >
          <template #icon-left>
            <component :is="item.icon" :size="20" :stroke-width="1" />
          </template>
          {{ item.label }}
        </AtomsButton>
      </NuxtLink>
    </nav>

    <div class="sidebar-decoration">
      <img src="~/assets/img/decorative-pattern.svg" alt="" />
    </div>
  </aside>
</template>

<script setup>
import { Home, Bookmark, Rocket, MessagesSquare, Users, Briefcase, UserCircle2 } from 'lucide-vue-next'

const props = defineProps({
  activeItem: {
    type: String,
    default: 'accueil'
  },
  isOpen: {
    type: Boolean,
    default: false
  },
  isStatic: {
    type: Boolean,
    default: false
  },
  wideBreakpoint: {
    type: Boolean,
    default: false
  }
})

defineEmits(['close'])

const menuItems = [
  { id: 'accueil', label: 'Accueil', icon: Home, route: '/collaborateur' },
  { id: 'passeport', label: 'Passeport de compétences', icon: Bookmark, route: '/collaborateur/passeport' },
  { id: 'mobilite', label: 'Mobilité & Carrière', icon: Rocket, route: '/collaborateur/mobilite' },
  { id: 'bienetre', label: 'Bien-être & Engagement', icon: MessagesSquare, route: '/collaborateur/bienetre' },
  { id: 'equipe', label: 'Équipe & Management', icon: Users, route: '/collaborateur/equipe' },
  { id: 'formation', label: 'Formation', icon: Briefcase, route: '/collaborateur/formation' },
  { id: 'profil', label: 'Profil', icon: UserCircle2, route: '/collaborateur/profil' }
]
</script>

<style scoped>
.sidebar-collaborateur {
  position: fixed;
  top: 82.73px;
  left: 0;
  width: 300px;
  height: calc(100vh - 82.73px);
  background: #252958;
  display: flex;
  flex-direction: column;
  padding: 32px 20px;
  box-sizing: border-box;
  overflow-y: auto;
  z-index: 50;
  /* Mobile: cachée par défaut, slide depuis la gauche */
  transform: translateX(-100%);
  transition: transform 0.3s ease-in-out;
}

.sidebar-collaborateur.is-static {
  position: relative;
  top: auto;
  height: 800px;
}

/* Desktop: toujours visible */
@media (min-width: 1024px) {
  .sidebar-collaborateur:not(.wide-breakpoint) {
    transform: translateX(0);
  }
}

@media (min-width: 1700px) {
  .sidebar-collaborateur.wide-breakpoint {
    transform: translateX(0);
  }
}

/* Mobile: visible quand ouverte */
.sidebar-collaborateur.is-open {
  transform: translateX(0);
}

.sidebar-nav {
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 20px;
  margin-top: 20px;
}

@media (min-width: 1024px) {
  .sidebar-collaborateur:not(.wide-breakpoint) .sidebar-nav {
    margin-top: 0;
  }
}

@media (min-width: 1700px) {
  .sidebar-collaborateur.wide-breakpoint .sidebar-nav {
    margin-top: 0;
  }
}

.menu-item {
  width: 100%;
  justify-content: flex-start;
  align-items: center;
}

.menu-item.is-active {
  background: rgba(255, 255, 255, 0.15);
}

.menu-link-wrapper {
  text-decoration: none;
  display: block;
}

.sidebar-decoration {
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  display: flex;
  justify-content: flex-start;
  pointer-events: none;
}

.sidebar-decoration img {
  width: auto;
  height: auto;
  display: block;
}
</style>