import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/**/*.js',
    ],

    theme: {
        extend: {
            colors: {
                brand: {
                    50: '#eef2ff',
                    500: '#6366f1',
                    600: '#4f46e5',
                    700: '#4338ca',
                    fontFamily: {
                        sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                    },
                },    
            },
        },
    },


    plugins: [forms],
    plugins: [require('@tailwindcss/forms')],
};
