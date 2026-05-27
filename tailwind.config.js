import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

// ============================================================
// FILE: tailwind.config.js
// ============================================================
/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
    ],
    theme: {
        extend: {
            colors: {
                'oneto-red': {
                    50:  '#fff5f5',
                    100: '#ffe3e3',
                    500: '#e53e3e',
                    600: '#dc2626',
                    700: '#b91c1c',
                    800: '#991b1b',
                    900: '#7f1d1d',
                },
            },
            fontFamily: {
                sans: ['Poppins', 'sans-serif'],
            },
            animation: {
                'slide-up': 'slideUp 0.3s ease-out',
            },
            keyframes: {
                slideUp: {
                    from: { transform: 'translateY(20px)', opacity: '0' },
                    to:   { transform: 'translateY(0)',    opacity: '1' },
                },
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/line-clamp'),
    ],
};
