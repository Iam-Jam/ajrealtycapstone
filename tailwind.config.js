/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
      "./resources/**/*.blade.php",
      "./resources/**/*.js",
      "./resources/**/*.vue",
    ],
    theme: {
      extend: {
        colors: {
          primary: {
            DEFAULT: '#052e16',
            dark: '#022c22',
          },
          secondary: {
            DEFAULT: '#1a2e05',
            light: '#365314',
          },
          accent: '#022c22',
        },
        backgroundColor: {
          'form': 'rgba(255, 255, 255, 0.8)', // Increase the opacity for better readability
        },
        textColor: {
          'form': '#333', // Set a darker text color for better contrast
        },
      },
    },


    plugins: [],
  }
