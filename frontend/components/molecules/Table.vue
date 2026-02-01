<template>
  <!-- Table Container avec scroll horizontal si nécessaire -->
  <div class="overflow-x-auto" :class="containerClasses">
    <table :class="tableClasses">
      <!-- Caption optionnel -->
      <caption v-if="caption" :class="captionClasses">
        {{ caption }}
      </caption>

      <!-- Header -->
      <thead v-if="showHeader && columns.length" :class="headerClasses">
        <tr>
          <!-- Colonne de sélection si activée -->
          <th v-if="selectable" :class="headerCellClasses" scope="col">
            <input 
              v-if="selectable === 'checkbox'"
              type="checkbox"
              :checked="allSelected"
              @change="toggleSelectAll"
              class="shrink-0 border-Grey-300 rounded text-primary-500 focus:ring-primary-500"
            />
            <span v-else-if="selectable === 'radio'" class="sr-only">Select</span>
          </th>
          
          <!-- Colonnes de données -->
          <th 
            v-for="(column, index) in columns" 
            :key="index"
            :class="[headerCellClasses, column.headerClass || '', { 'cursor-pointer hover:bg-primary-300': column.sortable !== false && column.type !== 'action' }]"
            scope="col"
            @click="handleSort(column)"
          >
            <div class="flex items-center justify-between">
              <div class="flex items-center" :class="column.headerIcon ? 'gap-2' : ''">
                <span>{{ column.label }}</span>
                <!-- Icône d'aide optionnelle -->
                <button
                  v-if="column.headerIcon"
                  type="button"
                  class="text-primary-500 hover:text-primary-700 transition-colors"
                  @click.stop="$emit('header-icon-click', { column, columnKey: column.key })"
                >
                  <component :is="iconMap[column.headerIcon]" :size="16" :stroke-width="1.5" />
                </button>
              </div>
              <!-- Flèches de tri -->
              <div v-if="column.sortable !== false && column.type !== 'action'" class="flex flex-col ml-2">
                <svg 
                  :class="['w-3 h-3 transition-colors', getSortArrowClass(column.key, 'asc')]"
                  fill="currentColor" 
                  viewBox="0 0 20 20"
                >
                  <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"/>
                </svg>
                <svg 
                  :class="['w-3 h-3 transition-colors', getSortArrowClass(column.key, 'desc')]"
                  fill="currentColor" 
                  viewBox="0 0 20 20"
                >
                  <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
              </div>
            </div>
          </th>
          
          <!-- Colonne d'actions si activée (legacy) -->
          <th v-if="hasLegacyActions" :class="headerCellClasses" scope="col">
            ACTION
          </th>
        </tr>
      </thead>

      <!-- Body -->
      <tbody :class="bodyClasses">
        <tr 
          v-for="(row, rowIndex) in sortedData" 
          :key="rowIndex"
          :class="getRowClasses(rowIndex)"
          @click="onRowClick(row, rowIndex)"
        >
          <!-- Cellule de sélection -->
          <td v-if="selectable" :class="cellClasses">
            <input 
              v-if="selectable === 'checkbox'"
              type="checkbox"
              :checked="isSelected(row)"
              @change="toggleRowSelection(row)"
              @click.stop
              class="shrink-0 border-Grey-300 rounded text-primary-500 focus:ring-primary-500"
            />
            <input 
              v-else-if="selectable === 'radio'"
              type="radio"
              :name="radioGroupName"
              :checked="isSelected(row)"
              @change="selectRow(row)"
              @click.stop
              class="shrink-0 border-Grey-300 text-primary-500 focus:ring-primary-500"
            />
          </td>
          
          <!-- Cellules de données -->
          <td 
            v-for="(column, colIndex) in columns" 
            :key="colIndex"
            :class="[cellClasses, column.cellClass || '', getHighlightClass(row, column)]"
          >
            <!-- Rendu selon le type de colonne -->
            <div v-if="column.type === 'tag'" class="flex justify-start">
              <AtomsTag
                v-if="getNestedValue(row, column.key)"
                :variant="getNestedValue(row, column.key).variant || 'solid'"
                :color="getNestedValue(row, column.key).color || 'primary'"
                :status-color="getNestedValue(row, column.key).statusColor"
                :size="getNestedValue(row, column.key).size || 'md'"
              >
                {{ getNestedValue(row, column.key).text }}
              </AtomsTag>
            </div>

            <div v-else-if="column.type === 'stepper'" class="flex justify-start">
              <MoleculesStepper
                :steps="getNestedValue(row, column.key)"
                :mini="true"
              />
            </div>
            
            <div v-else-if="column.type === 'action'" class="flex justify-start gap-2">
              <template v-for="(action, actionIndex) in getNestedValue(row, column.key)" :key="actionIndex">
                <!-- Bouton icon-only si l'action a un icon -->
                <AtomsButton
                  v-if="action.icon"
                  variant="primary"
                  size="table"
                  :icon-only="true"
                  @click.stop="$emit('action-click', { action: action.action, row, rowIndex })"
                >
                  <template #icon-left>
                    <component :is="iconMap[action.icon]" :size="17" :stroke-width="1.5" />
                  </template>
                </AtomsButton>
                <!-- Bouton texte classique sinon -->
                <AtomsButton
                  v-else
                  variant="secondary"
                  size="sm"
                  @click.stop="action.handler && action.handler(row, rowIndex)"
                  :disabled="action.disabled && action.disabled(row)"
                >
                  {{ action.label }}
                </AtomsButton>
              </template>
            </div>
            
            <!-- Type text par défaut -->
            <div v-else>
              <!-- Slot personnalisé pour la colonne -->
              <slot 
                :name="`cell-${column.key}`" 
                :row="row" 
                :value="getNestedValue(row, column.key)"
                :column="column"
                :index="rowIndex"
              >
                <!-- Affichage par défaut du texte -->
                {{ formatValue(getNestedValue(row, column.key), column) }}
              </slot>
            </div>
          </td>
          
          <!-- Cellule d'actions legacy -->
          <td v-if="hasLegacyActions" :class="cellClasses">
            <slot name="actions" :row="row" :index="rowIndex">
              <!-- Actions par défaut -->
              <AtomsButton
                v-for="action in (actions.length ? actions : defaultActions)" 
                :key="action.key"
                :variant="action.variant || 'secondary'"
                size="sm"
                @click.stop="action.handler(row, rowIndex)"
                :disabled="action.disabled && action.disabled(row)"
              >
                {{ action.label }}
              </AtomsButton>
            </slot>
          </td>
        </tr>
      </tbody>

      <!-- Footer optionnel -->
      <tfoot v-if="showFooter && footerData" :class="footerClasses">
        <tr>
          <td v-if="selectable" :class="footerCellClasses"></td>
          <td 
            v-for="(value, index) in footerData" 
            :key="index"
            :class="footerCellClasses"
          >
            {{ value }}
          </td>
          <td v-if="hasLegacyActions" :class="footerCellClasses"></td>
        </tr>
      </tfoot>
    </table>
  </div>
</template>

<script setup>
import { computed, ref } from 'vue'
import { ChevronRight as LucideChevronRight, HelpCircle as LucideHelpCircle } from 'lucide-vue-next'

// Map des icônes disponibles pour le type action et header
const iconMap = {
  ChevronRight: LucideChevronRight,
  HelpCircle: LucideHelpCircle
}

const props = defineProps({
  // Données et structure
  data: {
    type: Array,
    default: () => []
  },
  columns: {
    type: Array,
    required: true,
    validator: (columns) => {
      const validTypes = ['text', 'tag', 'action']
      return columns.every(col => 
        col.key && col.label && 
        (!col.type || validTypes.includes(col.type))
      )
    }
  },
  
  // Apparence
  variant: {
    type: String,
    default: 'default',
    validator: (v) => ['default', 'striped', 'bordered', 'borderless', 'rounded'].includes(v)
  },
  size: {
    type: String,
    default: 'md',
    validator: (v) => ['sm', 'md', 'lg'].includes(v)
  },
  
  // Comportement
  hoverable: {
    type: Boolean,
    default: false
  },
  selectable: {
    type: [Boolean, String],
    default: false,
    validator: (v) => v === false || ['checkbox', 'radio'].includes(v)
  },
  
  // Header/Footer
  showHeader: {
    type: Boolean,
    default: true
  },
  showFooter: {
    type: Boolean,
    default: false
  },
  footerData: {
    type: Array,
    default: null
  },
  
  // Style personnalisé
  headerStyle: {
    type: String,
    default: 'default',
    validator: (v) => ['default', 'gray', 'divided'].includes(v)
  },
  caption: String,
  
  // Actions
  actions: {
    type: Array,
    default: () => []
  },
  showDefaultActions: {
    type: Boolean,
    default: false
  },
  
  // Sélection
  selectedRows: {
    type: Array,
    default: () => []
  },
  
  // Tri
  sortable: {
    type: Boolean,
    default: true
  },
  defaultSort: {
    type: Object,
    default: null,
    validator: (v) => v === null || (v.key && ['asc', 'desc'].includes(v.order))
  }
})

const emit = defineEmits(['row-click', 'selection-change', 'select-all', 'delete-row', 'sort-change', 'action-click', 'header-icon-click'])

// Génération d'un nom unique pour les radio buttons
const radioGroupName = `table-radio-${Math.random().toString(36).substr(2, 9)}`

// Gestion du tri
const currentSort = ref(props.defaultSort || null)

// Classes de base Preline pour les tables
const baseTableClasses = 'min-w-full'

// Classes selon la variante
const variantClasses = {
  default: '',
  striped: '',
  bordered: 'border border-primary-300',
  borderless: '',
  rounded: 'rounded-lg overflow-hidden'
}

// Classes selon la taille
const sizeClasses = {
  sm: {
    cell: 'px-4 py-2 text-sm',
    header: 'px-4 py-2 text-xs'
  },
  md: {
    cell: 'px-5 py-3 text-sm',
    header: 'px-5 py-3 text-base'
  },
  lg: {
    cell: 'px-6 py-4 text-base',
    header: 'px-6 py-4 text-base'
  }
}

// Classes du header selon le style
const headerStyleClasses = {
  default: 'bg-primary-500/10',
  gray: 'bg-Grey-500',
  divided: 'bg-primary-500/10 divide-x divide-primary-500/10'
}

// Classes calculées
const containerClasses = computed(() => {
  let classes = ['border border-primary-300 rounded-lg overflow-hidden']
  return classes
})

const tableClasses = computed(() => {
  let classes = [baseTableClasses]
  classes.push(variantClasses[props.variant])
  return classes.join(' ')
})

const headerClasses = computed(() => {
  let classes = [headerStyleClasses[props.headerStyle]]
  if (props.headerStyle === 'divided') {
    classes.push('divide-x divide-Grey-300')
  }
  return classes.join(' ')
})

const headerCellClasses = computed(() => {
  let classes = [
    sizeClasses[props.size].header,
    'text-left font-medium text-primary-500 font-roboto'
  ]
  return classes.join(' ')
})

const bodyClasses = computed(() => {
  let classes = ['bg-Light divide-y divide-primary-500/10']
  return classes.join(' ')
})

const cellClasses = computed(() => {
  let classes = [
    sizeClasses[props.size].cell,
    'whitespace-nowrap text-primary-900 font-roboto text-left'
  ]
  return classes.join(' ')
})

const footerClasses = computed(() => {
  return 'bg-Grey-300'
})

const footerCellClasses = computed(() => {
  let classes = [
    sizeClasses[props.size].cell,
    'whitespace-nowrap font-medium text-primary-900 font-roboto'
  ]
  return classes.join(' ')
})

// Gestion des lignes
const getRowClasses = (index) => {
  let classes = []
  
  if (props.hoverable) {
    classes.push('hover:bg-Grey-300 transition-colors duration-200')
  }
  
  if (props.variant === 'striped' && index % 2 === 1) {
    classes.push('bg-Grey-300')
  }
  
  return classes.join(' ')
}

// Gestion de la sélection
const allSelected = computed(() => {
  return props.data.length > 0 && props.selectedRows.length === props.data.length
})

const hasLegacyActions = computed(() => {
  return props.actions.length > 0 || props.showDefaultActions
})

// Actions par défaut
const defaultActions = [
  {
    key: 'delete',
    label: 'Supprimer',
    variant: 'primary',
    handler: (row, index) => {
      emit('delete-row', { row, index })
    }
  }
]

const isSelected = (row) => {
  return props.selectedRows.some(selectedRow => 
    JSON.stringify(selectedRow) === JSON.stringify(row)
  )
}

const toggleSelectAll = () => {
  if (allSelected.value) {
    emit('selection-change', [])
  } else {
    emit('selection-change', [...props.data])
  }
  emit('select-all', !allSelected.value)
}

const toggleRowSelection = (row) => {
  const newSelection = isSelected(row) 
    ? props.selectedRows.filter(selectedRow => 
        JSON.stringify(selectedRow) !== JSON.stringify(row)
      )
    : [...props.selectedRows, row]
  
  emit('selection-change', newSelection)
}

const selectRow = (row) => {
  emit('selection-change', [row])
}

// Utilitaires
const getNestedValue = (obj, path) => {
  return path.split('.').reduce((current, key) => current?.[key], obj)
}

const formatValue = (value, column) => {
  if (column.formatter && typeof column.formatter === 'function') {
    return column.formatter(value)
  }
  return value
}

const getHighlightClass = (row, column) => {
  if (column.highlight && column.highlight(row)) {
    return 'bg-Yellow-300'
  }
  return ''
}

const captionClasses = computed(() => {
  return 'py-2 text-sm text-Grey-500 text-left font-roboto'
})

// Événements
const onRowClick = (row, index) => {
  emit('row-click', { row, index })
}

// Gestion du tri
const sortedData = computed(() => {
  if (!currentSort.value) {
    return props.data
  }
  
  const { key, order } = currentSort.value
  const sorted = [...props.data].sort((a, b) => {
    const aVal = getNestedValue(a, key)
    const bVal = getNestedValue(b, key)
    
    // Gestion des différents types
    if (typeof aVal === 'string' && typeof bVal === 'string') {
      return order === 'asc' 
        ? aVal.localeCompare(bVal, 'fr', { numeric: true })
        : bVal.localeCompare(aVal, 'fr', { numeric: true })
    }
    
    if (typeof aVal === 'number' && typeof bVal === 'number') {
      return order === 'asc' ? aVal - bVal : bVal - aVal
    }
    
    // Gestion des objets (tags par exemple)
    if (aVal && typeof aVal === 'object' && aVal.text) {
      const aText = aVal.text
      const bText = bVal?.text || ''
      return order === 'asc'
        ? aText.localeCompare(bText, 'fr')
        : bText.localeCompare(aText, 'fr')
    }
    
    // Conversion en string par défaut
    const aStr = String(aVal || '')
    const bStr = String(bVal || '')
    return order === 'asc'
      ? aStr.localeCompare(bStr, 'fr')
      : bStr.localeCompare(aStr, 'fr')
  })
  
  return sorted
})

const handleSort = (column) => {
  if (column.sortable === false || column.type === 'action') return
  
  const newOrder = currentSort.value?.key === column.key && currentSort.value?.order === 'asc' 
    ? 'desc' 
    : 'asc'
  
  currentSort.value = { key: column.key, order: newOrder }
  emit('sort-change', currentSort.value)
}

const getSortArrowClass = (columnKey, direction) => {
  const isActive = currentSort.value?.key === columnKey && currentSort.value?.order === direction
  return isActive ? 'text-primary-500' : 'text-Grey-500'
}
</script>

<!--
  Table.vue - Composant de tableau basé sur Preline
  
  Props principales:
  - data: Array des données à afficher
  - columns: Array des définitions de colonnes { key, label, formatter?, cellClass?, headerClass?, highlight? }
  - variant: 'default' | 'striped' | 'bordered' | 'borderless' | 'rounded'
  - selectable: false | 'checkbox' | 'radio'
  - hoverable: Boolean pour activer l'effet hover
  - actions: Array d'actions { key, label, handler, variant?, disabled? }
  
  Slots:
  - cell-{columnKey}: Pour personnaliser l'affichage d'une colonne
  - actions: Pour personnaliser la colonne d'actions
  
  Events:
  - row-click: Émis quand une ligne est cliquée
  - selection-change: Émis quand la sélection change
  - select-all: Émis quand le bouton "tout sélectionner" est utilisé
-->
