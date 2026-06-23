<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <a href="{{ route('projects.index') }}" class="text-xs text-tr-dim hover:text-tr-muted transition-colors font-mono">Projects</a>
            <span class="text-tr-dim text-xs">/</span>
            <h1 class="font-display font-bold text-xl text-tr-text">New Project</h1>
        </div>
    </x-slot>

    <div class="py-8 max-w-2xl mx-auto px-4 sm:px-6">
        <div class="card p-6 animate-slide-up">
            <form method="POST" action="{{ route('projects.store') }}">
                @csrf
                @include('projects._form')
                <div class="mt-6 flex gap-3 pt-5 border-t border-tr-border">
                    <button type="submit" class="btn-primary">Create Project</button>
                    <a href="{{ route('projects.index') }}" class="btn-ghost">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
