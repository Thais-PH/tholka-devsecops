<template>
  <aside class="sidebar-collaborateur">
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
  }
})

const menuItems = [
  { id: 'accueil', label: 'Accueil', icon: Home, route: '/collaborateur' },
  { id: 'passeport', label: 'Passeport de compétences', icon: Bookmark, route: '/collaborateur/passeport' },
  { id: 'mobilite', label: 'Mobilité & Carrière', icon: Rocket, route: '/collaborateur/mobilite' },
  { id: 'bienetre', label: 'Bien-être & Engagement', icon: MessagesSquare, route: '/collaborateur/bienetre' },
  { id: 'equipe', label: 'Équipe & Management', icon: Users, route: '/collaborateur/equipe-management' },
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
  z-index: 40;
}

.sidebar-nav {
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 20px;
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