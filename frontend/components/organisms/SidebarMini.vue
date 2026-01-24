<template>
  <aside class="sidebar-mini" :class="{ 'is-static': isStatic }">
    <nav class="sidebar-nav">
      <button
        v-for="item in menuItems"
        :key="item.id"
        class="menu-item"
        :class="{ 'is-active': activeItem === item.id }"
        @click="$emit('navigate', item.id)"
      >
        <component :is="item.icon" :size="20" :stroke-width="1" />
      </button>
    </nav>
  </aside>
</template>

<script setup>
import { Home, Users, Search, Rocket, MessagesSquare, Files, Euro, Briefcase, Bookmark, UserCircle2 } from 'lucide-vue-next'

const props = defineProps({
  activeItem: {
    type: String,
    default: 'accueil'
  },
  variant: {
    type: String,
    default: 'rh',
    validator: (value) => ['rh', 'collaborateur'].includes(value)
  },
  isStatic: {
    type: Boolean,
    default: false
  }
})

defineEmits(['navigate'])

const rhMenuItems = [
  { id: 'accueil', icon: Home },
  { id: 'equipe', icon: Users },
  { id: 'recrutement', icon: Search },
  { id: 'mobilite', icon: Rocket },
  { id: 'bienetre', icon: MessagesSquare },
  { id: 'administration', icon: Files },
  { id: 'remuneration', icon: Euro },
  { id: 'formation', icon: Briefcase }
]

const collaborateurMenuItems = [
  { id: 'accueil', icon: Home },
  { id: 'passeport', icon: Bookmark },
  { id: 'mobilite', icon: Rocket },
  { id: 'bienetre', icon: MessagesSquare },
  { id: 'equipe', icon: Users },
  { id: 'formation', icon: Briefcase },
  { id: 'profil', icon: UserCircle2 }
]

const menuItems = computed(() => 
  props.variant === 'rh' ? rhMenuItems : collaborateurMenuItems
)
</script>

<style scoped>
.sidebar-mini {
  width: 92px;
  min-height: 100vh;
  background: #252958;
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 0;
  box-sizing: border-box;
}

.sidebar-nav {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  padding: 32px 20px;
  gap: 20px;
  width: 92px;
}

.menu-item {
  display: flex;
  flex-direction: row;
  align-items: center;
  justify-content: center;
  padding: 8px 16px;
  gap: 4px;
  width: 52px;
  height: 40px;
  background: transparent;
  border: none;
  border-radius: 8px;
  color: #FFFFFF;
  cursor: pointer;
  transition: background 0.2s ease;
  flex: none;
  align-self: stretch;
}

.menu-item:hover {
  background: rgba(255, 255, 255, 0.15);
}

.menu-item.is-active {
  background: rgba(255, 255, 255, 0.15);
}

.sidebar-mini.is-static {
  min-height: 800px;
  height: 800px;
}
</style>