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
                // Light Mode Emerald (Vibrant, Clear) - for Navbar etc.
                'emerald-light': {
                    DEFAULT: '#10b981', // Standard Tailwind Emerald 500
                    50: '#ecfdf5',
                    100: '#d1fae5',
                    200: '#a7f3d0',
                    300: '#6ee7b7',
                    400: '#34d399',
                    500: '#10b981',
                    600: '#059669',
                    700: '#047857',
                    800: '#065f46',
                    900: '#064e3b',
                    950: '#022c22',
                },
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
                // Emerald Dark - Mapped to User Requested Variables
                'emerald-dark': {
                    DEFAULT: 'var(--primary-black)', // #000000
                    50: 'var(--gray25)',             // #F9FAFB (Text/Lightest)
                    100: '#f5f5f5',
                    200: '#e5e5e5',
                    300: '#d4d4d4',
                    400: '#a3a3a3',
                    500: 'var(--gray900)',           // #171717 (Cards/Surfaces)
                    600: '#262626',
                    700: '#171717',
                    800: 'var(--primary-black)',     // #000000 (Backgrounds)
                    900: '#000000',
                    950: '#000000',
                },
            },
        },
    },

    plugins: [forms, typography],
};
