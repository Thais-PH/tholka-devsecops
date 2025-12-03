<template>
  <!-- 🎯 CORRECTION: Conteneur parent sans hauteur fixe -->
  <div class="flex flex-col relative">
    <!-- Éditeur principal avec hauteur fixe -->
    <div 
      class="bg-white border border-gray-200 rounded-xl overflow-hidden dark:bg-neutral-800 dark:border-neutral-700"
      :style="{ width: customWidth, height: customHeight }"
    >
      <div :id="editorId" class="flex flex-col h-full">
        <!-- Toolbar du haut -->
        <div class="sticky top-0 bg-white flex align-middle gap-x-0.5 border-b border-gray-200 p-2 dark:bg-neutral-900 dark:border-neutral-700 flex-shrink-0">
          <!-- Bold -->
          <button 
            class="inline-flex justify-center items-center text-sm font-semibold rounded border border-transparent hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700" 
            style="width: 33px; height: 25px;"
            type="button" 
            title="Gras"
            @click="toggleFormat('bold')"
            :class="{ 'bg-gray-200': activeFormats?.bold }"
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
            :class="{ 'bg-gray-200': activeFormats?.italic }"
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
            :class="{ 'bg-gray-200': activeFormats?.underline }"
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
            :class="{ 'bg-gray-200': activeFormats?.strikethrough }"
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
            :class="{ 'bg-gray-200': activeFormats?.code }"
          >
            <LucideCode2 :size="17" :stroke-width="1" class="text-Grey-500" />
          </button>

        </div>

        <!-- Editor Field - Hauteur fixe de 172px -->
        <ClientOnly>
          <div 
            ref="editorElement"
            class="overflow-auto p-3 outline-none editor-content"
            style="height: 172px;"
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
              class="bg-white overflow-auto p-3 bg-gray-50 flex items-center justify-center"
              style="height: 172px;"
            >
              <span class="text-gray-500">Chargement...</span>
            </div>
          </template>
        </ClientOnly>

        <!-- Toolbar du bas -->
        <div class="bg-white flex justify-between items-center p-2 dark:bg-neutral-900 flex-shrink-0">
          
          <!-- Icônes à gauche -->
          <div class="flex align-middle gap-x-0.5">
            <!-- Pièce jointe -->
            <button 
              class="inline-flex justify-center items-center text-sm font-semibold rounded border border-transparent hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700" 
              style="width: 33px; height: 25px;"
              type="button" 
              title="Pièce jointe"
              @click="handleAttachment"
            >
              <LucidePaperclip :size="17" :stroke-width="1" class="text-Grey-500" />
            </button>

            <!-- Input file caché pour la pièce jointe -->
            <input
              ref="fileInput"
              type="file"
              multiple
              accept="image/*,video/*,audio/*,.pdf,.doc,.docx,.txt,.zip,.rar"
              style="display: none"
              @change="handleFileSelect"
            />

            <!-- Emoji -->
            <button 
              ref="emojiButton"
              class="inline-flex justify-center items-center text-sm font-semibold rounded border border-transparent hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700" 
              style="width: 33px; height: 25px;"
              type="button" 
              title="Emoji"
              @click="toggleEmojiPicker"
              :class="{ 'bg-gray-200': showEmojiPicker }"
            >
              <LucideSmile :size="17" :stroke-width="1" class="text-Grey-500" />
            </button>

            <!-- Poubelle -->
            <button 
              class="inline-flex justify-center items-center text-sm font-semibold rounded border border-transparent hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700" 
              style="width: 33px; height: 25px;"
              type="button" 
              title="Effacer tout"
              @click="handleClear"
            >
              <LucideTrash2 :size="17" :stroke-width="1" class="text-Grey-500" />
            </button>
          </div>

          <!-- Envoi -->
          <button 
            class="inline-flex justify-center items-center text-sm font-semibold rounded border border-transparent hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700" 
            style="width: 33px; height: 25px;"
            type="button"
            title="Envoyer le message"
            @click="handleSend"
            :disabled="isContentEmpty && attachedFiles.length === 0"
          >
            <LucideNavigation :size="17" :stroke-width="1" class="text-Grey-500" />
          </button>

        </div>
      </div>
    </div>

    <!-- Emoji picker -->
    <div
      v-if="showEmojiPicker && emojiPickerPosition"
      ref="emojiPickerContainer"
      class="absolute z-[9999] bg-white rounded-lg shadow-lg border border-gray-200 dark:bg-neutral-800 dark:border-neutral-700"
      :style="{
        left: emojiPickerPosition.left + 'px',
        bottom: emojiPickerPosition.bottom + 'px'
      }"
      style="box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);"
    >
      <ClientOnly>
        <NuxtEmojiPicker
          :hide-search="false"
          theme="light"
          :display-recent="true"
          @select="onSelectEmoji"
        />
        <template #fallback>
          <div class="p-4 text-center text-gray-500">
            <span>Chargement...</span>
          </div>
        </template>
      </ClientOnly>
    </div>

    <!-- Zone des fichiers attachés -->
    <div 
      v-if="attachedFiles.length > 0" 
      class="border-l border-r border-b border-gray-200 rounded-b-xl p-3 bg-gray-50 dark:bg-neutral-800 dark:border-neutral-700"
      :style="{ width: customWidth }"
    >
      <div class="flex flex-wrap gap-2 overflow-hidden">
        <div
          v-for="(file, index) in attachedFiles"
          :key="`file-${index}-${file.name}`"
          class="flex items-center gap-2 bg-white dark:bg-neutral-700 rounded-lg px-3 py-2 border border-gray-200 dark:border-neutral-600 min-w-0 flex-shrink-0"
        >
          <!-- Icônes selon le type de fichier -->
          <LucideImage 
            v-if="isImageFile(file)"
            :size="16"
            :stroke-width="1"
            class="text-Grey-500 flex-shrink-0"
          />
          <LucideVideo 
            v-else-if="isVideoFile(file)"
            :size="16"
            :stroke-width="1"
            class="text-Grey-500 flex-shrink-0"
          />
          <LucideMusic 
            v-else-if="isAudioFile(file)"
            :size="16"
            :stroke-width="1"
            class="text-Grey-500 flex-shrink-0"
          />
          <LucideFileText 
            v-else-if="isDocumentFile(file)"
            :size="16"
            :stroke-width="1"
            class="text-Grey-500 flex-shrink-0"
          />
          <LucideArchive 
            v-else-if="isArchiveFile(file)"
            :size="16"
            :stroke-width="1"
            class="text-Grey-500 flex-shrink-0"
          />
          <LucidePaperclip 
            v-else
            :size="16"
            :stroke-width="1"
            class="text-Grey-500 flex-shrink-0"
          />

          <!-- Nom du fichier -->
          <span class="text-sm text-gray-700 dark:text-gray-200 truncate max-w-[120px]" :title="file.name">
            {{ file.name }}
          </span>
          
          <!-- Taille du fichier -->
          <span class="text-xs text-Grey-500 whitespace-nowrap">
            {{ formatFileSize(file.size) }}
          </span>
          
          <!-- Bouton supprimer -->
          <button
            @click="removeFile(index)"
            class="text-Red-500 hover:text-Red-700 p-1 rounded hover:bg-Red-50 flex-shrink-0"
            title="Supprimer le fichier"
          >
            <LucideX :size="14" :stroke-width="1" />
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, nextTick, watch, computed, onUnmounted } from 'vue'

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
    default: '10rem'
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

// Initialisation des variables
const fileInput = ref(null)
const attachedFiles = ref([])
const editorId = ref(`simple-editor-${Date.now()}`)
const editorElement = ref(null)
const editorReady = ref(false)
const lastAction = ref('none')

// 🎯 VARIABLES POUR LES EMOJIS
const showEmojiPicker = ref(false)
const emojiPickerContainer = ref(null)
const emojiButton = ref(null)
const emojiPickerPosition = ref(null)

// Initialisation avec valeurs par défaut pour éviter l'erreur SSR
const activeFormats = ref({
  bold: false,
  italic: false,
  underline: false,
  strikethrough: false,
  code: false
})

let isUpdating = false

const emit = defineEmits(['update:modelValue', 'send', 'attachment', 'emoji', 'clear'])

const isContentEmpty = computed(() => {
  if (!editorElement.value) return attachedFiles.value.length === 0
  const textContent = editorElement.value.textContent || ''
  return textContent.trim() === '' && attachedFiles.value.length === 0
})

// Fonctions pour identifier les types de fichiers
const isImageFile = (file) => {
  return file.type.startsWith('image/')
}

const isVideoFile = (file) => {
  return file.type.startsWith('video/')
}

const isAudioFile = (file) => {
  return file.type.startsWith('audio/')
}

const isDocumentFile = (file) => {
  return file.type.includes('word') || 
         file.type.includes('document') || 
         file.type.includes('text') ||
         file.name.endsWith('.doc') ||
         file.name.endsWith('.docx') ||
         file.name.endsWith('.txt')
}

const isArchiveFile = (file) => {
  return file.type.includes('zip') || 
         file.type.includes('rar') ||
         file.name.endsWith('.zip') ||
         file.name.endsWith('.rar')
}

// Gestion de la pièce jointe - ouvre le sélecteur de fichiers
const handleAttachment = () => {
  if (fileInput.value) {
    fileInput.value.click()
  }
}

// Gestion de la sélection de fichiers
const handleFileSelect = (event) => {
  const files = Array.from(event.target.files || [])
  
  if (files.length > 0) {
    attachedFiles.value.push(...files)
    
    emit('attachment', files)
    
    if (fileInput.value) {
      fileInput.value.value = ''
    }
  }
}

// Supprimer un fichier de la liste
const removeFile = (index) => {
  attachedFiles.value.splice(index, 1)
}

// Formater la taille du fichier
const formatFileSize = (bytes) => {
  if (bytes === 0) return '0 B'
  
  const k = 1024
  const sizes = ['B', 'KB', 'MB', 'GB']
  const i = Math.floor(Math.log(bytes) / Math.log(k))
  
  return parseFloat((bytes / Math.pow(k, i)).toFixed(1)) + ' ' + sizes[i]
}

// Toggle emojis
const toggleEmojiPicker = () => {
  showEmojiPicker.value = !showEmojiPicker.value
  
  if (showEmojiPicker.value) {
    // Calculer la position quand on ouvre le picker
    nextTick(() => {
      emojiPickerPosition.value = calculateEmojiPickerPosition()
    })
  } else {
    emojiPickerPosition.value = null
  }
}

const onSelectEmoji = (emoji) => {
  if (!editorElement.value || !isBrowser) return

  try {
    editorElement.value.focus()
    
    // Insérer l'emoji à la position du curseur
    insertEmojiAtCursor(emoji.i) // emoji.i contient l'emoji unicode
    
    // Fermer le picker après sélection
    showEmojiPicker.value = false
    
    // Émettre l'événement
    emit('emoji', emoji)
  } catch (error) {
    console.error('Erreur lors de la sélection emoji:', error)
  }
}

const insertEmojiAtCursor = (emojiText) => {
  if (!editorElement.value || !isBrowser) return

  try {
    const selection = window.getSelection()
    let range

    if (selection.rangeCount > 0) {
      range = selection.getRangeAt(0)
    } else {
      range = document.createRange()
      range.selectNodeContents(editorElement.value)
      range.collapse(false)
    }

    // Supprimer la sélection actuelle
    range.deleteContents()

    // Créer un noeud texte avec l'emoji
    const emojiNode = document.createTextNode(emojiText + ' ')
    range.insertNode(emojiNode)

    // Positionner le curseur après l'emoji
    range.setStartAfter(emojiNode)
    range.collapse(true)

    selection.removeAllRanges()
    selection.addRange(range)

    // Déclencher l'événement input
    handleInput()
  } catch (error) {
    console.error('Erreur lors de l\'insertion de l\'emoji:', error)
    
    // Fallback: ajouter à la fin
    const currentContent = editorElement.value.innerHTML || ''
    editorElement.value.innerHTML = currentContent + emojiText + ' '
    handleInput()
  }
}

// Fermer le picker d'emoji en cliquant dehors
const handleClickOutside = (event) => {
  if (showEmojiPicker.value && 
      emojiPickerContainer.value && 
      !emojiPickerContainer.value.contains(event.target) &&
      !emojiButton.value?.contains(event.target)) {
    showEmojiPicker.value = false
    emojiPickerPosition.value = null
  }
}

// Gestion de la poubelle
const handleClear = () => {
  if (confirm('Êtes-vous sûr de vouloir effacer tout le contenu et les fichiers attachés ?')) {
    clearContent()
    attachedFiles.value = []
    emit('clear')
  }
}

// Gestion de l'envoi
const handleSend = () => {
  const hasContent = editorElement.value && editorElement.value.textContent?.trim()
  const hasFiles = attachedFiles.value.length > 0
  
  if (hasContent || hasFiles) {
    const content = getContent()
    const files = [...attachedFiles.value]
    
    emit('send', { content, files })
  }
}

// Vérification client-side pour les fonctions DOM
const isBrowser = process.client

// Gestion des événements pour fermer le picker
onMounted(() => {
  if (isBrowser) {
    document.addEventListener('click', handleClickOutside)
    window.addEventListener('resize', handleResize)
    window.addEventListener('scroll', handleScroll, true)
  }

  nextTick(() => {
    setTimeout(() => {
      if (editorElement.value) {
        editorReady.value = true

        if (props.modelValue) {
          editorElement.value.innerHTML = props.modelValue
        }

        setupLinkHandlers()
      }
    }, 100)
  })
})

onUnmounted(() => {
  if (isBrowser) {
    document.removeEventListener('click', handleClickOutside)
    window.removeEventListener('resize', handleResize)
    window.removeEventListener('scroll', handleScroll, true)
  }
})

const setupLinkHandlers = () => {
  if (!editorElement.value || !isBrowser) return

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

  attachLinkHandlers()
}

const attachLinkHandlers = () => {
  if (!editorElement.value || !isBrowser) return

  const links = editorElement.value.querySelectorAll('a')
  links.forEach(link => {
    link.removeEventListener('click', handleLinkClick)
    link.addEventListener('click', handleLinkClick)
    link.style.cursor = 'pointer'
  })
}

const handleLinkClick = (event) => {
  event.preventDefault()
  event.stopPropagation()

  const href = event.target.href || event.target.getAttribute('href')

  if (href) {
    if (confirm(`Ouvrir le lien : ${href} ?`)) {
      window.open(href, '_blank', 'noopener,noreferrer')
    }
  }
}

const handleInput = () => {
  if (!isUpdating && editorElement.value) {
    const content = editorElement.value.innerHTML
    emit('update:modelValue', content)
    updateActiveFormats()

    setTimeout(() => {
      attachLinkHandlers()
    }, 100)
  }
}

// Protection contre les erreurs SSR
const updateActiveFormats = () => {
  if (!editorReady.value || !isBrowser) return

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

const toggleFormat = (format) => {
  if (!editorReady.value || !isBrowser) return

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

const wrapWithCode = () => {
  if (!isBrowser) return false
  
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

    range.setStartAfter(codeElement)
    range.collapse(true)
    selection.removeAllRanges()
    selection.addRange(range)

    return true
  }
  return false
}

const insertLink = () => {
  if (!editorReady.value || !isBrowser) return

  const url = prompt('Entrez l\'URL:', 'https://')
  if (!url) return

  const selection = window.getSelection()
  const selectedText = selection.toString()
  const linkText = selectedText || url

  const linkHtml = `<a href="${url}" class="text-blue-600 underline hover:text-blue-800 cursor-pointer" title="${url}">${linkText}</a>`

  if (selectedText) {
    document.execCommand('insertHTML', false, linkHtml)
  } else {
    editorElement.value.focus()
    document.execCommand('insertHTML', false, linkHtml + '&nbsp;')
  }

  handleInput()
  lastAction.value = `link (${new Date().toLocaleTimeString()})`
  
  setTimeout(() => {
    attachLinkHandlers()
  }, 100)
}

const insertList = (type) => {
  if (!editorReady.value || !isBrowser) return

  editorElement.value.focus()

  const command = type === 'ol' ? 'insertOrderedList' : 'insertUnorderedList'
  const success = document.execCommand(command, false, null)

  if (success) {
    handleInput()
    lastAction.value = `${type} (${new Date().toLocaleTimeString()})`
  }
}

const insertBlockquote = () => {
  if (!editorReady.value || !isBrowser) return

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

const onFocus = () => {
  updateActiveFormats()
}

const onBlur = () => {
  // Keep formats state when losing focus
}

watch(() => props.modelValue, (newValue) => {
  if (!isUpdating && editorElement.value && newValue !== editorElement.value.innerHTML) {
    isUpdating = true
    editorElement.value.innerHTML = newValue

    setTimeout(() => {
      attachLinkHandlers()
      isUpdating = false
    }, 100)
  }
})

const getContent = () => {
  return editorElement.value ? editorElement.value.innerHTML : ''
}

const setContent = (content) => {
  if (editorElement.value) {
    editorElement.value.innerHTML = content
    updateActiveFormats()
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

const getAttachedFiles = () => {
  return [...attachedFiles.value]
}

const clearAttachedFiles = () => {
  attachedFiles.value = []
}

// Position du picker
const calculateEmojiPickerPosition = () => {
  if (!emojiButton.value) return null
  
  const buttonRect = emojiButton.value.getBoundingClientRect()
  const editorRect = emojiButton.value.closest('.flex.flex-col.relative').getBoundingClientRect()
  
  // Position relative au conteneur parent de l'éditeur
  const relativeLeft = buttonRect.left - editorRect.left
  const relativeBottom = editorRect.bottom - buttonRect.top + 8 // 8px d'espacement
  
  return {
    left: relativeLeft,
    bottom: relativeBottom
  }
}

// Recalcule de la position si la fenêtre change
const handleResize = () => {
  if (showEmojiPicker.value) {
    emojiPickerPosition.value = calculateEmojiPickerPosition()
  }
}

const handleScroll = () => {
  if (showEmojiPicker.value) {
    emojiPickerPosition.value = calculateEmojiPickerPosition()
  }
}

defineExpose({
  getContent,
  setContent,
  clearContent,
  getAttachedFiles,
  clearAttachedFiles
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