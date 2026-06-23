import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans:    ['Plus Jakarta Sans', ...defaultTheme.fontFamily.sans],
                display: ['Plus Jakarta Sans', ...defaultTheme.fontFamily.sans],
                mono:    ['JetBrains Mono', ...defaultTheme.fontFamily.mono],
            },
            colors: {
                tr: {
                    base:       '#F8FAFC',
                    surface:    '#FFFFFF',
                    raised:     '#F1F5F9',
                    hover:      '#F0FDF9',
                    border:     '#E2E8F0',
                    'border-s': '#CBD5E1',
                    text:       '#0F172A',
                    muted:      '#64748B',
                    dim:        '#94A3B8',
                    accent:     '#3ECF8E',
                    'accent-h': '#2EBF7E',
                    'accent-d': '#1A7A50',
                    ok:         '#22C55E',
                    bad:        '#EF4444',
                    info:       '#3B82F6',
                    warn:       '#F59E0B',
                },
            },
            keyframes: {
                slideUp: {
                    from: { opacity: '0', transform: 'translateY(8px)' },
                    to:   { opacity: '1', transform: 'translateY(0)' },
                },
                fadeIn: {
                    from: { opacity: '0' },
                    to:   { opacity: '1' },
                },
            },
            animation: {
                'slide-up': 'slideUp 0.35s ease forwards',
                'fade-in':  'fadeIn 0.3s ease forwards',
            },
        },
    },

    plugins: [forms],
};
