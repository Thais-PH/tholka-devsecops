<template>
  <aside class="sidebar-collaborateur">
    <nav class="sidebar-nav">
      <AtomsButton
        v-for="item in menuItems"
        :key="item.id"
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
  { id: 'accueil', label: 'Accueil', icon: Home },
  { id: 'passeport', label: 'Passeport de compétences', icon: Bookmark },
  { id: 'mobilite', label: 'Mobilité & Carrière', icon: Rocket },
  { id: 'bienetre', label: 'Bien-être & Engagement', icon: MessagesSquare },
  { id: 'equipe', label: 'Équipe & Management', icon: Users },
  { id: 'formation', label: 'Formation', icon: Briefcase },
  { id: 'profil', label: 'Profil', icon: UserCircle2 }
]
</script>

<style scoped>
.sidebar-collaborateur {
  width: 300px;
  min-height: 100vh;
  background: #252958;
  display: flex;
  flex-direction: column;
  padding: 32px 20px;
  box-sizing: border-box;
  position: relative;
}

.sidebar-nav {
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 20px;
  overflow-y: auto;
}

.menu-item {
  width: 100%;
  justify-content: flex-start;
  align-items: center;
}

.menu-item.is-active {
  background: rgba(255, 255, 255, 0.15);
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