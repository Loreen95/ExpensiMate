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
                'black': '#0D1B2A',
                'oxford': '#1B263B',
                'blue': '#415A77',
                'silver': '#778DA9',
                'platinum': '#E0E1DD',
                'white': '#FFFFFF'

                  // 'black': '#040F0F', // Zwart (Black)
                  // 'sage': '#C9CBA3', // Salie (Sage)
                  // 'white': '#FFFFFF', // Wit (White)
                  // 'bittsweet': '#E26D5C', // Bittersweet
                  // 'hookgreen': '#4E6E5D', // Hookers Groen (Hooker's Green)
                  // 'blue' : '#ADD9F4',
                  // 'trueblue' : '#476C9B',
                  // 'munsell' : '#468C98',
              },
          },
      },
      plugins: []
    }