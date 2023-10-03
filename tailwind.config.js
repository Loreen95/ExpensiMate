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
                'white': '#FFFFFF',
            },
        },
    },
    plugins: []
}