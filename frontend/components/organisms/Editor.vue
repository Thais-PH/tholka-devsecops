<template>
  <div 
    class="bg-white border border-gray-200 rounded-xl overflow-hidden dark:bg-neutral-800 dark:border-neutral-700"
    :style="{ width: customWidth, height: customHeight }"
  >
    <div :id="editorId" class="flex flex-col h-full">
      <!-- Toolbar -->
      <div class="sticky top-0 bg-white flex align-middle gap-x-0.5 border-b border-gray-200 p-2 dark:bg-neutral-900 dark:border-neutral-700 flex-shrink-0">
        <!-- Bold -->
        <button 
          class="inline-flex justify-center items-center text-sm font-semibold rounded border border-transparent hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700" 
          style="width: 33px; height: 25px;"
          type="button" 
          title="Gras"
          @click="toggleFormat('bold')"
          :class="{ 'bg-gray-200': activeFormats.bold }"
        >
          <LucideBold :size="17" :stroke-width="1" class="text-Grey-500" />
        </button>

        <!-- Italic -->
        <button 
          class="inline-flex justify-center items-center text-sm font-semibold rounded border border-transparent hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700" 
          style="width: 33px; height: 25px;"
          type="button" 
          title="Italique"
          @click="toggleFormat('italic')"
          :class="{ 'bg-gray-200': activeFormats.italic }"
        >
          <LucideItalic :size="17" :stroke-width="1" class="text-Grey-500" />
        </button>

        <!-- Underline -->
        <button 
          class="inline-flex justify-center items-center text-sm font-semibold rounded border border-transparent hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700" 
          style="width: 33px; height: 25px;"
          type="button" 
          title="Souligné"
          @click="toggleFormat('underline')"
          :class="{ 'bg-gray-200': activeFormats.underline }"
        >
          <LucideUnderline :size="17" :stroke-width="1" class="text-Grey-500" />
        </button>

        <!-- Strike -->
        <button 
          class="inline-flex justify-center items-center text-sm font-semibold rounded border border-transparent hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700" 
          style="width: 33px; height: 25px;"
          type="button" 
          title="Barré"
          @click="toggleFormat('strikethrough')"
          :class="{ 'bg-gray-200': activeFormats.strikethrough }"
        >
          <LucideStrikethrough :size="17" :stroke-width="1" class="text-Grey-500" />
        </button>

        <!-- Link -->
        <button 
          class="inline-flex justify-center items-center text-sm font-semibold rounded border border-transparent hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700" 
          style="width: 33px; height: 25px;"
          type="button" 
          title="Lien"
          @click="insertLink"
        >
          <LucideLink :size="17" :stroke-width="1" class="text-Grey-500" />
        </button>

        <!-- Ordered List -->
        <button 
          class="inline-flex justify-center items-center text-sm font-semibold rounded border border-transparent hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700" 
          style="width: 33px; height: 25px;"
          type="button" 
          title="Liste numérotée"
          @click="insertList('ol')"
        >
          <LucideListOrdered :size="17" :stroke-width="1" class="text-Grey-500" />
        </button>

        <!-- Unordered List -->
        <button 
          class="inline-flex justify-center items-center text-sm font-semibold rounded border border-transparent hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700" 
          style="width: 33px; height: 25px;"
          type="button" 
          title="Liste à puces"
          @click="insertList('ul')"
        >
          <LucideList :size="17" :stroke-width="1" class="text-Grey-500" />
        </button>

        <!-- Blockquote -->
        <button 
          class="inline-flex justify-center items-center text-sm font-semibold rounded border border-transparent hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700" 
          style="width: 33px; height: 25px;"
          type="button" 
          title="Citation"
          @click="insertBlockquote"
        >
          <LucideTextQuote :size="17" :stroke-width="1" class="text-Grey-500" />
        </button>

        <!-- Code -->
        <button 
          class="inline-flex justify-center items-center text-sm font-semibold rounded border border-transparent hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700" 
          style="width: 33px; height: 25px;"
          type="button" 
          title="Code"
          @click="toggleFormat('code')"
          :class="{ 'bg-gray-200': activeFormats.code }"
        >
          <LucideCode2 :size="17" :stroke-width="1" class="text-Grey-500" />
        </button>

      </div>

      <!-- Editor Field -->
      <ClientOnly>
        <div 
          ref="editorElement"
          class="flex-1 overflow-auto p-3 outline-none editor-content"
          contenteditable="true"
          @input="handleInput"
          @keyup="updateActiveFormats"
          @mouseup="updateActiveFormats"
          @focus="onFocus"
          @blur="onBlur"
          :data-placeholder="placeholder"
        ></div>
        <template #fallback>
          <div 
            class="flex-1 overflow-auto p-3 bg-gray-50 flex items-center justify-center"
          >
            <span class="text-gray-500">Chargement de l'éditeur...</span>
          </div>
        </template>
      </ClientOnly>

    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, nextTick, watch, computed } from 'vue'

const props = defineProps({
  modelValue: {
    type: String,
    default: ''
  },
  placeholder: {
    type: String,
    default: 'Type your message'
  },
  width: {
    type: [String, Number],
    default: '100%'
  },
  height: {
    type: [String, Number],
    default: '10rem' // 160px par défaut
  }
})

const customWidth = computed(() => {
  if (typeof props.width === 'number') {
    return `${props.width}px`
  }
  return props.width
})

const customHeight = computed(() => {
  if (typeof props.height === 'number') {
    return `${props.height}px`
  }
  return props.height
})

const emit = defineEmits(['update:modelValue'])

const editorId = ref(`simple-editor-${Date.now()}`)
const editorElement = ref(null)
const editorReady = ref(false)
const lastAction = ref('none')
const activeFormats = ref({
  bold: false,
  italic: false,
  underline: false,
  strikethrough: false,
  code: false
})

let isUpdating = false

onMounted(async () => {
  await nextTick()
  setTimeout(() => {
    if (editorElement.value) {
      editorReady.value = true

      // Définition du contenu initial
      if (props.modelValue) {
        editorElement.value.innerHTML = props.modelValue
      }

      setupLinkHandlers()
    }
  }, 100)
})

// Fonction pour gérer les clics sur les liens
const setupLinkHandlers = () => {
  if (!editorElement.value) return

  // Observation des mutations pour détecter les nouveaux liens ajoutés
  const observer = new MutationObserver((mutations) => {
    mutations.forEach((mutation) => {
      if (mutation.type === 'childList') {
        attachLinkHandlers()
      }
    })
  })

  observer.observe(editorElement.value, {
    childList: true,
    subtree: true
  })

  // Attache des handlers aux liens existants
  attachLinkHandlers()
}

// Fonction pour attacher les event listeners aux liens
const attachLinkHandlers = () => {
  if (!editorElement.value) return

  const links = editorElement.value.querySelectorAll('a')
  links.forEach(link => {
    // Supprimer l'ancien event listener s'il existe
    link.removeEventListener('click', handleLinkClick)

    // Ajouter le nouvel event listener
    link.addEventListener('click', handleLinkClick)

    // Ajouter les styles pour indiquer que c'est cliquable
    link.style.cursor = 'pointer'
  })
}

// Gestionnaire de clic pour les liens
const handleLinkClick = (event) => {
  event.preventDefault()
  event.stopPropagation()

  const href = event.target.href || event.target.getAttribute('href')

  if (href) {
    // Demander confirmation avant d'ouvrir le lien
    if (confirm(`Ouvrir le lien : ${href} ?`)) {
      window.open(href, '_blank', 'noopener,noreferrer')
    }
  }
}

// Gestion des entrées
const handleInput = () => {
  if (!isUpdating && editorElement.value) {
    const content = editorElement.value.innerHTML
    emit('update:modelValue', content)
    updateActiveFormats()

    // Re-attacher les handlers après modification du contenu
    setTimeout(() => {
      attachLinkHandlers()
    }, 100)
  }
}

// Mise à jour des formats actifs
const updateActiveFormats = () => {
  if (!editorReady.value) return

  try {
    const selection = window.getSelection()
    if (selection.rangeCount > 0) {
      activeFormats.value = {
        bold: document.queryCommandState('bold'),
        italic: document.queryCommandState('italic'),
        underline: document.queryCommandState('underline'),
        strikethrough: document.queryCommandState('strikeThrough'),
        code: false
      }
    }
  } catch (error) {
    console.warn('Could not update active formats:', error)
  }
}

// Toggle format
const toggleFormat = (format) => {
  if (!editorReady.value) return

  lastAction.value = `${format} (${new Date().toLocaleTimeString()})`

  try {
    editorElement.value.focus()

    let success = false

    switch (format) {
      case 'bold':
        success = document.execCommand('bold', false, null)
        break
      case 'italic':
        success = document.execCommand('italic', false, null)
        break
      case 'underline':
        success = document.execCommand('underline', false, null)
        break
      case 'strikethrough':
        success = document.execCommand('strikeThrough', false, null)
        break
      case 'code':
        success = wrapWithCode()
        break
    }

    if (success) {
      handleInput()
      updateActiveFormats()
    } else {
      console.warn(`${format} command failed`)
    }
  } catch (error) {
    console.error(`Error applying ${format}:`, error)
  }
}

// Wrapper pour le code
const wrapWithCode = () => {
  const selection = window.getSelection()
  if (selection.rangeCount === 0) return false

  const range = selection.getRangeAt(0)
  const selectedText = range.toString()

  if (selectedText) {
    const codeElement = document.createElement('code')
    codeElement.className = 'bg-gray-100 px-1 py-0.5 rounded text-sm font-mono'
    codeElement.textContent = selectedText

    range.deleteContents()
    range.insertNode(codeElement)

    // Déplacer le curseur après l'élément code
    range.setStartAfter(codeElement)
    range.collapse(true)
    selection.removeAllRanges()
    selection.addRange(range)

    return true
  }
  return false
}

// Insérer un lien
const insertLink = () => {
  if (!editorReady.value) return

  const url = prompt('Entrez l\'URL:', 'https://')
  if (!url) return

  const selection = window.getSelection()
  const selectedText = selection.toString()
  const linkText = selectedText || url

  // Lien sans event handler inline (géré par JS)
  const linkHtml = `<a href="${url}" class="text-blue-600 underline hover:text-blue-800 cursor-pointer" title="${url}">${linkText}</a>`

  if (selectedText) {
    document.execCommand('insertHTML', false, linkHtml)
  } else {
    editorElement.value.focus()
    document.execCommand('insertHTML', false, linkHtml + '&nbsp;')
  }

  handleInput()
  lastAction.value = `link (${new Date().toLocaleTimeString()})`
  
  // Attacher le handler au nouveau lien
  setTimeout(() => {
    attachLinkHandlers()
  }, 100)
}

// Insérer une liste
const insertList = (type) => {
  if (!editorReady.value) return

  editorElement.value.focus()

  const command = type === 'ol' ? 'insertOrderedList' : 'insertUnorderedList'
  const success = document.execCommand(command, false, null)

  if (success) {
    handleInput()
    lastAction.value = `${type} (${new Date().toLocaleTimeString()})`
  }
}

// Insérer blockquote
const insertBlockquote = () => {
  if (!editorReady.value) return

  const selection = window.getSelection()
  const selectedText = selection.toString() || 'Citation'

  const blockquoteHtml = `<blockquote class="border-l-4 border-gray-300 pl-4 italic text-gray-600">${selectedText}</blockquote><p><br></p>`

  editorElement.value.focus()

  if (selectedText !== 'Citation') {
    document.execCommand('insertHTML', false, blockquoteHtml)
  } else {
    document.execCommand('insertHTML', false, blockquoteHtml)
  }

  handleInput()
  lastAction.value = `blockquote (${new Date().toLocaleTimeString()})`
}

// Events
const onFocus = () => {
  updateActiveFormats()
}

const onBlur = () => {
  // Keep formats state when losing focus
}

// Watch pour les changements externes
watch(() => props.modelValue, (newValue) => {
  if (!isUpdating && editorElement.value && newValue !== editorElement.value.innerHTML) {
    isUpdating = true
    editorElement.value.innerHTML = newValue

    // Re-attacher les handlers après changement externe
    setTimeout(() => {
      attachLinkHandlers()
      isUpdating = false
    }, 100)
  }
})

// Méthodes exposées
const getContent = () => {
  return editorElement.value ? editorElement.value.innerHTML : ''
}

const setContent = (content) => {
  if (editorElement.value) {
    isUpdating = true
    editorElement.value.innerHTML = content
    emit('update:modelValue', content)

    setTimeout(() => {
      attachLinkHandlers()
      isUpdating = false
    }, 100)
  }
}

const clearContent = () => {
  if (editorElement.value) {
    isUpdating = true
    editorElement.value.innerHTML = ''
    emit('update:modelValue', '')
    nextTick(() => {
      isUpdating = false
    })
  }
}

defineExpose({
  getContent,
  setContent,
  clearContent
})
</script>

<style scoped>
[contenteditable]:empty::before {
  content: attr(data-placeholder);
  color: #AEACAC;
  pointer-events: none;
  font-weight: 400 !important;
  font-family: 'Roboto', sans-serif !important;
  font-size: 16px !important;
}

[contenteditable]:focus {
  outline: none;
}

.editor-content {
  position: relative;
  font-size: 16px !important;
}

:deep(p) {
  font-size: 16px !important;
  font-weight: 400 !important;
  line-height: 1.5 !important;
  margin: 0.5rem 0 !important;
}

:deep(strong) {
  font-weight: bold;
}

:deep(em) {
  font-style: italic;
}

:deep(u) {
  text-decoration: underline;
}

:deep(s) {
  text-decoration: line-through;
}

:deep(code) {
  background-color: #f3f4f6 !important;
  color: #1f2937 !important;
  padding: 0.125rem 0.25rem !important;
  border-radius: 0.25rem !important;
  font-family: 'Courier New', monospace !important;
  font-size: 16px !important;
}

:deep(ul) {
  list-style-type: disc !important;
  list-style-position: inside !important;
  padding-left: 1.5rem !important;
  margin: 0.5rem 0 !important;
  font-size: 16px !important;
}

:deep(ol) {
  list-style-type: decimal !important;
  list-style-position: inside !important;
  padding-left: 1.5rem !important;
  margin: 0.5rem 0 !important;
  font-size: 16px !important;
}

:deep(li) {
  margin: 0.25rem 0 !important;
  line-height: 1.5 !important;
  font-weight: 400 !important;
  font-family: 'Roboto', sans-serif !important;
  font-size: 16px !important;
}

:deep(blockquote) {
  border-left: 4px solid #d1d5db !important;
  margin: 1rem 0 !important;
  padding-left: 1rem !important;
  color: #6b7280 !important;
  font-style: italic !important;
  font-size: 16px !important;
}

:deep(a) {
  color: #3b82f6 !important;
  text-decoration: underline !important;
  cursor: pointer !important;
  transition: color 0.2s ease !important;
  pointer-events: auto !important;
  font-size: inherit !important;
}

:deep(a:hover) {
  color: #1d4ed8 !important;
  text-decoration: none !important;
}

:deep(a:focus) {
  outline: 2px solid #3b82f6 !important;
  outline-offset: 2px !important;
  border-radius: 2px !important;
}

:deep(a::after) {
  content: " 🔗" !important;
  font-size: 12px !important;
  opacity: 0.6 !important;
  margin-left: 2px !important;
}

:deep(a) {
  user-select: text !important;
}

:deep(ul li),
:deep(ol li) {
  font-weight: 400 !important;
  font-family: 'Roboto', sans-serif !important;
  font-size: 16px !important;
}

:deep(ul li strong),
:deep(ol li strong),
:deep(ul li b),
:deep(ol li b) {
  font-weight: bold !important;
  font-size: 16px !important;
}

:deep(ul li em),
:deep(ol li em),
:deep(ul li i),
:deep(ol li i) {
  font-style: italic !important;
  font-size: 16px !important;
}

[contenteditable] {
  font-size: 16px !important;
  font-family: 'Roboto', sans-serif !important;
  line-height: 1.5 !important;
}

:deep(strong),
:deep(b) {
  font-size: inherit !important;
}

:deep(em),
:deep(i) {
  font-size: inherit !important;
}

:deep(u) {
  font-size: inherit !important;
}

:deep(s) {
  font-size: inherit !important;
}
</style>