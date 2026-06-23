<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'PriTech') }} — Tracker</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>[x-cloak] { display: none !important; }</style>
    </head>
    <body class="font-sans text-tr-text antialiased min-h-screen bg-tr-base flex flex-col justify-center items-center px-4 py-12">

        <div class="mb-8 text-center animate-fade-in">
            <div class="inline-flex items-center gap-2 mb-1">
                <span class="w-8 h-8 rounded-lg bg-tr-accent flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </span>
                <span class="text-xl font-bold tracking-tight text-tr-text">PriTech Tracker</span>
            </div>
        </div>

        <div class="w-full max-w-sm animate-slide-up">
            <div class="bg-white border border-tr-border rounded-2xl px-8 py-8 shadow-sm">
                {{ $slot }}
            </div>
        </div>

        <p class="mt-8 text-xs text-tr-dim animate-fade-in">© {{ date('Y') }} PriTech. All rights reserved.</p>
    </body>
</html>
