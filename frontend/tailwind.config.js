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
        // Brand
        'primary-500': '#3A3B99',
        'secondary-500': '#55C3E9',
        // Brand variants
        'primary-700': '#252958',
        'primary-300': '#EBEBF5',
        'secondary-700': '#137192',
        'secondary-300': '#ECF8FD',
        // Neutral
        'Black': '#0B0B0B',
        'primary-900': '#050D2E',
        'Grey-500': '#AEACAC',
        'Grey-300': '#EFEEEE',
        'Light': '#FFFFFF',
        // Other colors
        'Green-700': '#146E4E',
        'Green-500': '#1CAB78',
        'Green-300': '#E8F7F1',
        'Orange-700': '#B55322',
        'Orange-500': '#F07F47',
        'Orange-300': '#FDF2ED',
        'Yellow-700': '#AF8434',
        'Yellow-500': '#FCC253',
        'Yellow-300': '#FFF6E5',
        // Alert
        'Red-700': '#AA271D',
        'Red-500': '#EB5035',
        // Disc
        'Green-disc': '#45CA24',
        'Blue-disc': '#476EF6',
        'Yellow-disc': '#FFD83B',
        'Red-disc': '#EB4335',
      },

      backgroundImage: {
        'gradient-ia': 'linear-gradient(90deg, #1CAB78 0%, #55C3E9 29.33%, #F07F47 77.88%, #FCC253 96.63%)',
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
  plugins: ['preline/plugin'],
}