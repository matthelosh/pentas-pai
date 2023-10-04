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
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            screens: {
                print: {raw: 'print'},
                screen: { raw: 'screen'},
                'sm': '640px',
                'md': '768px',
                'lg': '1024px',
                'xl': '1440px',
            }
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
