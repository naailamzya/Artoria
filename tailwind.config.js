import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.blade.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', 'Figtree', ...defaultTheme.fontFamily.sans],
                display: ['Space Grotesk', 'Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'artoria': {
                    50: '#fff1f2',
                    100: '#ffe1e4',
                    200: '#ffc7ce',
                    300: '#ffa0ab',
                    400: '#ff6b7d',
                    500: '#ff2b4f', // Primary neon red
                    600: '#f01742',
                    700: '#ca0c35',
                    800: '#a70d30',
                    900: '#8b0f2d',
                    950: '#4d0414',
                },
            },
            backgroundImage: {
                'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
                'gradient-conic': 'conic-gradient(from 180deg at 50% 50%, var(--tw-gradient-stops))',
                'gradient-red-black': 'linear-gradient(135deg, #ff2b4f 0%, #1a0610 100%)',
                'gradient-dark': 'linear-gradient(180deg, #0a0a0a 0%, #1a0610 100%)',
            },
            boxShadow: {
                'neon-red': '0 0 20px rgba(255, 43, 79, 0.5)',
                'neon-red-lg': '0 0 40px rgba(255, 43, 79, 0.6)',
                'glass': '0 8px 32px 0 rgba(31, 38, 135, 0.37)',
            },
            animation: {
                'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                'float': 'float 6s ease-in-out infinite',
                'glow': 'glow 2s ease-in-out infinite alternate',
            },
            keyframes: {
                float: {
                    '0%, 100%': { transform: 'translateY(0px)' },
                    '50%': { transform: 'translateY(-20px)' },
                },
                glow: {
                    '0%': { boxShadow: '0 0 5px rgba(255, 43, 79, 0.5)' },
                    '100%': { boxShadow: '0 0 20px rgba(255, 43, 79, 0.8)' },
                },
            },
        },
    },

    plugins: [forms],
};