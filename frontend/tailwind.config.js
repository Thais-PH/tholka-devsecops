/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./components/**/*.{js,vue,ts}",
    "./layouts/**/*.vue",
    "./pages/**/*.vue",
    "./plugins/**/*.{js,ts}",
    "./app.vue",
    "./error.vue",
  ],
  theme: {
    extend: {
      // A confirmer avec les UX/UI
      colors: {
        'dark-blue': '#252958',
        'neutral-blue': '#009FD6',
        'marine-blue': '#3A3B99',
        "blue": '#029BCF',
        'orange': '#F07F47',
        "yellow": '#FFAD10',
        'green': '#1CAB78',
      },
      
      fontFamily: {
        sans: ['Nunito', 'sans-serif']
      },
    },
  },
  plugins: [],
}