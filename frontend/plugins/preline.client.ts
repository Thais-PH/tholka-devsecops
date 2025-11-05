export default defineNuxtPlugin(() => {
  if (import.meta.client) {
    import('preline/preline')
  }
})