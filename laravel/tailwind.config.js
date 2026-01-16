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
                // Emerald Dark - NOW MAPPED TO SLATE/ZINC for a Premium Dark Mode
                'emerald-dark': {
                    DEFAULT: '#020617', // Slate 950 (Main Background)
                    50: '#f8fafc',
                    100: '#f1f5f9',
                    200: '#e2e8f0',
                    300: '#cbd5e1',
                    400: '#94a3b8',
                    500: '#1e293b', // Slate 800 (Cards/Panels)
                    600: '#334155', // Slate 700 (Borders/Secondary)
                    700: '#475569',
                    800: '#1e293b',
                    900: '#0f172a',
                    950: '#020617',
                },
            },
        },
    },

    plugins: [forms, typography],
};
