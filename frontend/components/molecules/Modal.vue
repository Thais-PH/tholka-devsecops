<template>
  <!-- Modal Vue (sans plugin Preline) -->
  <Teleport to="body">
    <div 
      v-show="isOpen"
      class="fixed inset-0 z-50 flex items-center justify-center"
      role="dialog"
      tabindex="-1"
      aria-labelledby="modal-title"
      aria-modal="true"
    >
      <!-- Backdrop -->
      <div 
        class="absolute inset-0 bg-Black bg-opacity-50 transition-opacity"
        @click="closeModal"
      ></div>
      
      <!-- Modal Dialog -->
      <div 
        class="relative transform transition-all duration-300 ease-in-out sm:max-w-lg sm:w-full m-3"
        :class="{ 'scale-100 opacity-100': isOpen, 'scale-95 opacity-0': !isOpen }"
      >
        <!-- Modal Content -->
        <div class="bg-Light border border-Grey-300 rounded-xl shadow-lg">
          <!-- Modal Body -->
          <div class="p-8 text-center">
            <!-- Icon -->
            <div class="mb-6 flex justify-center">
              <img 
                src="~/assets/icons/icon-modal.svg" 
                alt="Icon"
                class="w-16 h-16"
              />
            </div>
            
            <!-- Titre principal -->
            <h3 
              id="modal-title"
              class="mb-4"
              style="font-family: 'Roboto', sans-serif; font-weight: 500; font-size: 20px; color: #3A3B99; line-height: 1.2;"
            >
              {{ title }}
            </h3>
            
            <!-- Texte description -->
            <p 
              class="mb-6"
              style="font-family: 'Roboto', sans-serif; font-weight: 400; font-size: 14px; color: #050D2E;"
            >
              {{ message }}
            </p>
            
            <!-- Bouton primaire -->
            <button
              type="button"
              class="py-3 px-6 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-Light hover:opacity-90 disabled:opacity-50 disabled:pointer-events-none transition-opacity"
              style="background-color: #3A3B99;"
              @click="closeModal"
            >
              {{ buttonText }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </Teleport>
</template>

<script setup>
const props = defineProps({
  // Contrôle d'affichage
  isOpen: {
    type: Boolean,
    default: false
  },
  // Contenu de la modale
  title: {
    type: String,
    required: true
  },
  message: {
    type: String,
    required: true
  },
  buttonText: {
    type: String,
    default: 'OK'
  }
})

const emit = defineEmits(['close'])

const closeModal = () => {
  emit('close')
}
</script>