<x-app-layout>
    <x-slot name="header">
        <h1 class="font-display font-bold text-xl text-tr-text">Dashboard</h1>
        <p class="text-xs text-tr-muted mt-0.5">Welcome back, {{ Auth::user()->name }}</p>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="card p-8 text-center animate-fade-in">
            <div class="w-12 h-12 mx-auto mb-4 rounded-xl bg-tr-accent/10 border border-tr-accent/25 flex items-center justify-center">
                <svg class="w-6 h-6 text-tr-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p class="text-tr-text font-semibold">You're logged in!</p>
            <p class="text-tr-muted text-sm mt-1">Head to <a href="{{ route('projects.index') }}" class="text-tr-accent hover:text-tr-accent-h transition-colors">Projects</a> to get started.</p>
        </div>
    </div>
</x-app-layout>
