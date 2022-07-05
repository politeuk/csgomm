const { colors } = require('tailwindcss/defaultTheme');
const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
        },
        colors: {
            transparent: 'transparent',
            current: 'currentColor',
            'black': '#000',
            'dark': '#151624',
            'secondary': '#25283b',
            'primary': '#9ba2ba',
            'accent': '#2b49ff',
            'white': '#fff',
            'green': {
                50: '#F0FDF4',
                100: '#DCFCE7',
                200: '#BBF7D0',
                300: '#86EFAC',
                400: '#4ADE80',
                500: '#22C55E',
                600: '#16A34A',
                700: '#15803D',
                800: '#166534',
                900: '#14532D',
            },
            'orange': {
                50: '#FFFBEB',
                100: '#FEF3C7',
                200: '#FDE68A',
                300: '#FCD34D',
                400: '#FBBF24',
                500: '#F59E0B',
                600: '#D97706',
                700: '#B45309',
                800: '#92400E',
                900: '#78350F',
            },
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
