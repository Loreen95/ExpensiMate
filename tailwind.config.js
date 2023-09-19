/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
      "./resources/**/*.blade.php",
      "./resources/**/*.js",
      "./resources/**/*.vue",
    ],
    theme: {
      extend: {},
    },
    plugins: [],
      content: [
          "./resources/**/*.blade.php",
          "./resources/**/*.js",
          "./resources/**/*.vue",
      ],
      theme: {
          extend: {
              colors: {
                  'text': '#040F0F', // Zwart (Black)
                  'neutral': '#C9CBA3', // Salie (Sage)
                  'primary': '#FFFFFF', // Wit (White)
                  'accent': '#E26D5C', // Bittersweet
                  'secondary': '#4E6E5D', // Hookers Groen (Hooker's Green)
              },
          },
      },
      plugins: []
    }