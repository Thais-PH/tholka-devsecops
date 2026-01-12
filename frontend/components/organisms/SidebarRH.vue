<template>
  <div>
    <!-- Overlay mobile -->
    <div
      v-if="isOpen"
      class="fixed inset-0 bg-black/50 z-40 lg:hidden"
      @click="$emit('close')"
    ></div>

    <aside
      class="sidebar-rh"
      :class="{ 'is-open': isOpen }"
    >
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
  </div>
</template>

<script setup>
import { Home, Users, Search, Rocket, MessagesSquare, Files, Euro, Briefcase } from 'lucide-vue-next'

const props = defineProps({
  activeItem: {
    type: String,
    default: 'accueil'
  },
  isOpen: {
    type: Boolean,
    default: false
  }
})

defineEmits(['close'])

const menuItems = [
  { id: 'accueil', label: 'Accueil', icon: Home },
  { id: 'equipe', label: 'Équipe & Management', icon: Users },
  { id: 'recrutement', label: 'Recrutement', icon: Search },
  { id: 'mobilite', label: 'Mobilité & Carrière', icon: Rocket },
  { id: 'bienetre', label: 'Bien-être & Engagement', icon: MessagesSquare },
  { id: 'administration', label: 'Administration', icon: Files },
  { id: 'remuneration', label: 'Rémunération', icon: Euro },
  { id: 'formation', label: 'Formation', icon: Briefcase }
]
</script>

<style scoped>
.sidebar-rh {
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

/* Desktop: toujours visible */
@media (min-width: 1024px) {
  .sidebar-rh {
    transform: translateX(0);
  }
}

/* Mobile: visible quand ouverte */
.sidebar-rh.is-open {
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
  .sidebar-nav {
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