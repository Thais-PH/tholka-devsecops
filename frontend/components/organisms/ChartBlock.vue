<template>
  <div class="flex flex-col gap-[16px] w-[423px] h-[288px] bg-white rounded-lg shadow-sm p-6 overflow-hidden">
    <!-- Header -->
    <div class="flex justify-between items-center w-full">
      <h5 class="text-h5 text-primary-500">Collaborateurs</h5>
      <img src="@/assets/icons/users-round.svg" alt="Collaborateurs" class="flex-shrink-0" style="width: 20px; height: 20px; filter: invert(45%) sepia(72%) saturate(1071%) hue-rotate(5deg) brightness(102%) contrast(103%);"/>
    </div>

    <!-- Main Content - Horizontal Layout -->
    <div class="flex gap-4 flex-1 overflow-hidden">
      <!-- Left: Stats Section -->
      <div class="flex flex-col gap-4 justify-center flex-shrink-0">
        <!-- Statistiques -->
        <div class="bg-Light rounded-lg p-4 w-[150px]">
          <!-- Départs -->
          <div class="flex items-center gap-3 mb-3">
            <AtomsTag 
              variant="soft" 
              color="orange" 
              size="md"
              status-color="orange"
            >
              Départs
            </AtomsTag>
            <span class="text-sm font-semibold text-primary-900">{{ departures }}</span>
          </div>
          
          <!-- Arrivées -->
          <div class="flex items-center gap-3 mb-3">
            <AtomsTag 
              variant="soft" 
              color="secondary" 
              size="md"
              status-color="secondary"
            >
              Arrivées
            </AtomsTag>
            <span class="text-sm font-semibold text-primary-900">{{ arrivals }}</span>
          </div>
          
          <!-- En poste -->
          <div class="flex items-center gap-3">
            <AtomsTag 
              variant="soft" 
              color="green" 
              size="md"
              status-color="green"
            >
              En poste
            </AtomsTag>
            <span class="text-sm font-semibold text-primary-900">{{ inPosition }}</span>
          </div>
        </div>
      </div>

      <!-- Right: Doughnut Chart -->
      <div class="flex items-center justify-center flex-1 overflow-hidden">
        <div style="transform: scale(1); transform-origin: center;">
          <MoleculesDoughnutChart
            :series="chartSeries"
            :labels="chartLabels"
            :colors="chartColors"
            :center-value="totalCollaborateurs"
            :center-label="'Collaborateurs'"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'

// Statistiques RH
const departures = ref(8)
const arrivals = ref(12)
const inPosition = ref(50)

// Mock data pour le doughnut chart
const chartSeries = ref([12, 8, 50])
const chartLabels = ref(['Arrivées', 'Départs', 'En poste'])
const chartColors = ref(['#55C3E9', '#F07F47', '#1CAB78']) // [secondary/cyan, orange, green]
const totalCollaborateurs = ref(70)
</script>
