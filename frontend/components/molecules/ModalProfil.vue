<script setup lang="ts">
import { LucideX, LucideZap } from 'lucide-vue-next';

interface Props {
  variant?: 'small' | 'large';
  isOpen?: boolean;
}

withDefaults(defineProps<Props>(), {
  variant: 'small',
  isOpen: false
});

const emit = defineEmits(['close']);
</script>

<template>
  <div v-if="isOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black/20 backdrop-blur-sm" @click.self="emit('close')">
    <div 
      class="bg-Light rounded-[8px] relative flex flex-col items-center shadow-xl box-border transition-all duration-300 isolate overflow-y-auto md:overflow-hidden max-h-[90vh] md:max-h-none"
      :class="[
        variant === 'small' ? 'w-[90%] md:w-[732px] md:h-[470px]' : 'w-[90%] md:w-[732px] md:h-[906px]',
        'p-[24px] gap-[32px] md:p-[40px] md:gap-[66px]'
      ]"
    >
      <!-- Close Button -->
      <!-- Button Icons provided in CSS: right: 10px, top: 10px -->
      <div class="absolute right-[10px] top-[10px] z-0">
        <AtomsButton 
            variant="forms" 
            size="md" 
            :icon-only="true" 
            @click="emit('close')"
            class="!p-0 flex items-center justify-center"
        >
             <LucideX :size="16" :stroke-width="1.5" color="#1F2937" />
        </AtomsButton>
      </div>

      <!-- Reveal Section (Icon + Text) -->
      <!-- Small: height 342px, gap 24px -->
      <!-- Large: height 826px, gap 24px -->
      <div 
        class="flex flex-col items-center gap-[24px] w-full flex-none order-1 self-stretch z-10"
        :class="variant === 'small' ? 'md:h-[342px]' : 'md:h-[826px]'"
      >
        <!-- Static Icon (62x62) -->
        <div class="flex-none order-0 w-[62px] h-[62px] flex items-center justify-center relative">
          <div class="box-border flex flex-row justify-center items-center p-0 w-[62px] h-[62px] bg-Red-500 border-[7px] border-Orange-300 rounded-full">
            <!-- Zap Icon (26x26) -->
             <LucideZap :size="26" :stroke-width="2" color="white" fill="white" class="flex-none order-0 flex-grow-0" />
          </div>
        </div>

        <!-- Text Section -->
        <!-- Small: Gap 24px, Height 256px -->
        <!-- Large: Gap 32px, Height 740px -->
        <div 
          class="flex flex-col items-center w-full flex-none order-1 self-stretch"
          :class="[
            variant === 'small' ? 'gap-[24px] md:h-[256px]' : 'gap-[32px] md:h-[740px]'
          ]"
        >
            <!-- Title -->
            <div class="flex flex-col items-start p-0 gap-[10px] w-full h-auto md:h-[32px] flex-none order-0 self-stretch">
                <h3 class="w-full font-roboto font-medium text-[20px] leading-[160%] text-center text-primary-500 flex-none order-0 self-stretch">
                    <slot name="title">Titre du Profil</slot>
                </h3>
            </div>

            <!-- Description (Shared) -->
            <div class="w-full h-auto md:h-[88px] font-roboto font-medium text-[16px] leading-[140%] text-primary-500 flex-none order-1 self-stretch">
                 <slot name="description">
                    Qui est-il ?<br>
                    Le Dominant est une personne énergique, factuelle et orientée vers l'action. Il est tenace, extraverti et se concentre intensément sur l'atteinte de ses objectifs. Son style est direct, parfois perçu comme autoritaire ou agressif.
                 </slot>
            </div>

            <!-- Communication (Shared) -->
            <div class="w-full h-auto md:h-[88px] font-roboto font-medium text-[16px] leading-[140%] text-primary-500 flex-none order-2 self-stretch">
                 <slot name="communication">
                    Comment communiquer avec lui ?<br>
                    Soyez direct et factuel. Allez droit au but, car il apprécie les décisions rapides et n'a pas besoin d'une multitude de détails pour agir. Évitez de lui imposer une structure trop rigide ou des processus trop longs qui pourraient le freiner dans son élan.
                 </slot>
            </div>

            <!-- Extra content for Large variant -->
            <template v-if="variant === 'large'">
                <!-- Reading Diagram -->
                <div class="w-full h-auto md:h-[240px] font-roboto font-medium text-[16px] leading-[140%] text-primary-500 flex-none order-3 self-stretch">
                    <slot name="diagram-info">
                        Lire le diagramme coloré<br>
                        Entre 0% et 30%, on considérera la dimension comme très difficilement mobilisable. Elle demandera un effort particulier pour être exprimée.<br>
                        Entre 30% et 50%, c’est une dimension qui n’est pas spontanée, qui demandera aussi un effort mais sans difficulté notable.<br>
                        Entre 50% et 70%, il s’agit d’une dimension mobilisable très facilement.<br>
                        Entre 70% et 100%, c’est une dimension qui s’exprime naturellement et sans effort, elle aura d’ailleurs du mal à être refrénée.
                    </slot>
                </div>

                <!-- Typologies -->
                <div class="w-full h-auto md:h-[164px] font-roboto font-medium text-[16px] leading-[140%] text-primary-500 flex-none order-4 self-stretch">
                    <slot name="typology-info">
                        Les typologies de graphique<br>
                        Un graphique nivelé (dont les scores des dimensions sont tous autour de 50%) montre une capacité à passer d'un mode à un autre sans trop d’effort, ni difficulté notable. Il s’agit d’un profil naturellement adaptable.<br>
                        Un graphique polarisé (avec de grands écarts entre les scores) révèle une capacité forte à se développer dans les dimensions aux scores élevés.
                    </slot>
                </div>
            </template>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
/* Ensure fonts are available if not loaded globally */
/* @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap'); */
/* @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap'); */

/* .font-roboto {
  font-family: 'Roboto', sans-serif;
} */
</style>
