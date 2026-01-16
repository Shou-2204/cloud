import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Ivory tones (warm white for light mode)
                ivory: {
                    50: '#FFFEFB',
                    100: '#FFFDF7',
                    200: '#FFFBF0',
                    300: '#FFF8E7',
                    400: '#FFF5DE',
                    500: '#FFF2D5',
                    DEFAULT: '#FFFBF5',
                },
                // Deep emerald for dark mode backgrounds
                'emerald-dark': {
                    DEFAULT: '#0f3d2e',
                    50: '#1a5c45',
                    100: '#17503c',
                    200: '#144534',
                    300: '#123a2c',
                    400: '#0f3d2e',
                    500: '#0c3226',
                    600: '#0a281e',
                    700: '#081f17',
                    800: '#05150f',
                    900: '#030b08',
                    950: '#010503',
                },
            },
        },
    },

    plugins: [forms, typography],
};
