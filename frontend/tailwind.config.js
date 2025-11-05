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
        sans: ['Nunito', 'sans-serif'],
        roboto: ['Roboto', 'sans-serif'],
      },

      fontSize: {
        // Textes - Roboto
        'xs': ['12px', { lineHeight: '1.125rem', fontWeight: '400' }],
        'sm': ['14px', { lineHeight: '1.313rem', fontWeight: '400' }],
        'base': ['16px', { lineHeight: '1.5rem', fontWeight: '400' }],
        'lg': ['20px', { lineHeight: '1.875rem', fontWeight: '500' }],

        // Titres - Nunito
        'h5': ['24px', { lineHeight: '2.25rem', fontWeight: '700' }],
        'h4': ['28px', { lineHeight: '2.625rem', fontWeight: '700' }],
        'h3': ['32px', { lineHeight: '3rem', fontWeight: '700' }],
        'h2': ['40px', { lineHeight: '3.75rem', fontWeight: '700' }],
        'h1': ['48px', { lineHeight: '4.5rem', fontWeight: '700' }],
      },
    },
  },
  plugins: [],
}