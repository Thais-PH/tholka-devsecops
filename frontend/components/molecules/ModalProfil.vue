<script setup lang="ts">
import { X as LucideX } from 'lucide-vue-next';
import { computed } from 'vue';

interface Props {
  variant?: 'small' | 'large';
  isOpen?: boolean;
  profileType?: 'D' | 'I' | 'S' | 'C';
}

const props = withDefaults(defineProps<Props>(), {
  variant: 'small',
  isOpen: false,
  profileType: 'D'
});

const emit = defineEmits(['close']);

const profileData = computed(() => {
  const data = {
    D: {
      title: 'Le profil Rouge',
      icon: '/icons/icon-disc-red.svg',
      description: "Le Dominant est une personne énergique, factuelle et <span class='font-medium'>orientée vers l'action</span>. Il est tenace, <span class='font-medium'>extraverti et se concentre intensément sur l'atteinte de ses objectifs</span>. Son style est direct, parfois perçu comme autoritaire ou agressif.",
      communication: "Soyez <span class='font-medium'>direct et factuel</span>. Allez droit au but, car il apprécie les <span class='font-medium'>décisions rapides</span> et n'a pas besoin d'une multitude de détails pour agir. Évitez de lui imposer une structure trop rigide ou des processus trop longs qui pourraient le freiner dans son élan.",
      tags: ['Confiant', 'Affirmatif', 'Bref'],
      tagColor: 'orange'
    },
    I: {
      title: 'Le profil Jaune',
      icon: '/icons/icon-disc-yellow.svg',
      description: "L'Influent est <span class='font-medium'>sociable, optimiste et solaire</span>. Il accorde une grande importance aux relations personnelles et à la convivialité. Très <span class='font-medium'>éloquent, il sait convaincre les autres</span> tout en restant attaché à un fonctionnement démocratique.",
      communication: "Adoptez une <span class='font-medium'>attitude enthousiaste et chaleureuse</span>. Communiquez de manière claire et ouverte, en mettant l'accent sur la vision d'ensemble et l'aspect humain. Il est <span class='font-medium'>sensible au charisme et apprécie les échanges stimulants</span> qui favorisent la dynamique de groupe.",
      tags: ['Détendu', 'Vivant', 'Dans l\'émotion'],
      tagColor: 'yellow'
    },
    S: {
      title: 'Le profil Vert',
      icon: '/icons/icon-disc-green.svg',
      description: "Le Stable est une <span class='font-medium'>personne fiable, sérieuse et cohérente</span>. Il apprécie la clarté et peut se montrer réservé ou <span class='font-medium'>timide lors d'un premier contact</span>. Il est prêt à s'investir pleinement pour défendre les causes qui lui tiennent à coeur",
      communication: "<span class='font-medium'>Soyez clair et rassurant</span>. Il a besoin de <span class='font-medium'>comprendre</span> la cohérence d'un projet <span class='font-medium'>avant de s'engager</span>. Evitez les changements brusques ou imprévus, car il <span class='font-medium'>préfère les environnements stables</span> et routiniers plutôt que le mouvement perpétuel.",
      tags: ['Clair', 'Rassurant', 'Bienveillant', 'Patient'],
      tagColor: 'green'
    },
    C: {
      title: 'Le profil Bleu',
      icon: '/icons/icon-disc-blue.svg',
      description: "Le Conforme est <span class='font-medium'>réfléchi et analytique</span>. Il n'agit jamais sans avoir mûrement réfléchi et analysé son environnement pour le comprendre. Il peut paraître froid ou indifférent car il <span class='font-medium'>privilégie la réflexion à l'émotion</span>.",
      communication: "Fournissez des <span class='font-medium'>informations précises et détaillées</span> pour nourrir son besoin de compréhension. Ne le brusquez pas et évitez les rapports de force, car il réagit mal à l'autorité directe <span class='font-medium'>Donnez-lui le temps nécessaire pour traiter les données</span> avant d'attendre une réponse ou une action de sa part.",
      tags: ['Sérieux', 'Professionnel', 'Objectif', 'Direct', 'Précis', 'Logique'],
      tagColor: 'secondary'
    }
  };
  return data[props.profileType];
});
</script>

<template>
  <Teleport to="body">
    <Transition 
      enter-active-class="transition ease-out duration-300"
      enter-from-class="opacity-0 slide-y-4"
      enter-to-class="opacity-100 slide-y-0"
      leave-active-class="transition ease-in duration-200"
      leave-from-class="opacity-100 slide-y-0"
      leave-to-class="opacity-0 slide-y-4"
    >
      <div v-if="isOpen" class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/20 backdrop-blur-sm" @click.self="emit('close')">
        <!-- Main Container -->
        <!-- Updated to match Figma 'Pop up' layer -->
        <div 
          class="bg-white rounded-[8px] relative flex flex-col items-center shadow-xl box-border transition-all duration-300 isolate max-h-[90vh] overflow-y-auto"
          :class="[
            'w-[90%] md:w-[732px]',
            'p-[24px] md:p-[40px] gap-[32px] md:gap-[66px]'
          ]"
        >
          <!-- Close Button -->
          <button
            type="button"
            class="absolute top-2.5 right-2.5 flex items-center justify-center w-[38px] h-[38px] rounded-lg hover:bg-Grey-300 transition-colors z-20"
            aria-label="Fermer"
            @click="emit('close')"
          >
            <LucideX :size="16" :stroke-width="1.5" class="text-primary-900" />
          </button>

          <!-- Reveal Section -->
          <div 
            class="flex flex-col items-center gap-[19px] w-full max-w-[652px] flex-none order-1 z-10"
          >
            <!-- Icon Disc -->
            <img :src="profileData.icon" :alt="`${profileData.title}`" class="flex-none order-0 w-[52px] h-[52px]" />

            <!-- Text Wrapper -->
            <!-- Matches Figma 'text' and 'Content' groups -->
            <div 
                class="flex flex-col items-center w-full"
                :class="variant === 'small' ? 'gap-[24px]' : 'gap-[32px]'"
            >
                
                 <!-- Content Group: Title + Paragraphs -->
                 <!-- Note: For Large variant, these are direct children of the text wrapper (gap 32px) -->
                 <!-- For Small variant, they were grouped in a 'Content Group' with gap 10px? 
                      Check previous CSS: Small 'text' gap 24px. Inside 'text': Content(Title), Desc, Comm. 
                      Large CSS: 'text' gap 32px. Items: Title, Desc, Comm, Diagram, Typo.
                 -->

                 <!-- Title -->
                 <h3 class="w-full font-roboto font-medium text-[20px] leading-[160%] text-center text-primary-500">
                    <slot name="title">{{ profileData.title }}</slot>
                 </h3>
                 
                 <!-- Description -->
                 <div class="w-full font-roboto font-normal text-base text-primary-900">
                     <slot name="description" :description="profileData.description">
                        <span class="text-primary-500 font-medium">Qui est-il ?</span><br>
                        <span v-html="profileData.description"></span>
                     </slot>
                 </div>
                 
                 <!-- Communication -->
                 <div class="w-full font-roboto font-normal text-base text-primary-900">
                     <slot name="communication" :communication="profileData.communication">
                        <span class="text-primary-500 font-medium">Comment communiquer avec lui ?</span><br>
                        <span v-html="profileData.communication"></span>
                     </slot>
                 </div>

                 <!-- Soyez Section (Only for Small) -->
                 <div v-if="variant === 'small'" class="flex flex-col items-start gap-[8px] w-full self-stretch">
                    <!-- Title Row -->
                    <div class="flex flex-row items-center gap-[16px] w-full h-[22px]">
                        <span class="font-roboto font-medium text-[16px] leading-[140%] text-primary-500">Soyez :</span>
                    </div>
                    <!-- Tags Row -->
                    <div class="flex flex-row items-start gap-[8px] w-full flex-wrap">
                        <AtomsTag 
                            v-for="(tag, index) in profileData.tags" 
                            :key="index"
                            variant="soft"
                            size="lg"
                            :color="profileData.tagColor"
                            :class="`tag-text-${profileData.tagColor}`"
                        >
                            {{ tag }}
                        </AtomsTag>
                    </div>
                 </div>

                 <!-- Large Variant Extras -->
                 <template v-if="variant === 'large'">
                    <!-- Reading Diagram -->
                    <div class="w-full font-roboto font-normal text-base text-primary-900">
                        <slot name="diagram-info">
                            <span class="text-primary-500 font-medium">Lire le diagramme coloré</span><br><br>
                            Entre <span class="font-medium">0% et 30%</span>, on considérera la dimension comme <span class="font-medium">très difficilement mobilisable</span>. Elle demandera un effort particulier pour être exprimée.<br><br>
                            Entre <span class="font-medium">30% et 50%</span>, c’est une dimension qui <span class="font-medium">n’est pas spontanée</span>, qui demandera aussi un effort mais sans difficulté notable.<br><br>
                            Entre <span class="font-medium">50% et 70%</span>, il s’agit d’une dimension <span class="font-medium">mobilisable très facilement</span>.<br><br>
                            Entre <span class="font-medium">70% et 100%</span>, c’est une dimension qui <span class="font-medium">s’exprime naturellement et sans effort</span>, elle aura d’ailleurs du mal à être refrénée.
                        </slot>
                    </div>

                    <!-- Typologies -->
                    <div class="w-full font-roboto font-normal text-base text-primary-900">
                        <slot name="typology-info">
                            <span class="text-primary-500 font-medium">Les typologies de graphique</span><br><br>
                            <span class="font-medium">Un graphique nivelé</span> (dont les scores des dimensions sont tous autour de 50%) montre une capacité à passer d'un mode à un autre sans trop d’effort, ni difficulté notable. Il s’agit d’un <span class="font-medium">profil naturellement adaptable</span>.<br><br>
                            <span class="font-medium">Un graphique polarisé</span> (avec de grands écarts entre les scores) révèle une <span class="font-medium">capacité forte à se développer</span> dans les dimensions aux scores élevés.
                        </slot>
                    </div>
                 </template>

            </div>
          </div>
        </div>
      </div>
    </Transition>
  </Teleport>
</template>

<style scoped>
/* Override couleur texte des tags selon le profil DISC */
:deep(.tag-text-orange) {
  color: theme('colors.Red-500') !important;
}

:deep(.tag-text-yellow) {
  color: theme('colors.primary-900') !important;
}

:deep(.tag-text-green) {
  color: theme('colors.Green-700') !important;
}

:deep(.tag-text-secondary) {
  color: theme('colors.primary-500') !important;
}
</style>
