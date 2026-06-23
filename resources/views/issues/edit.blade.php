<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <a href="{{ route('projects.show', $issue->project) }}" class="text-xs text-tr-dim hover:text-tr-muted transition-colors font-mono">{{ $issue->project->name }}</a>
            <span class="text-tr-dim text-xs">/</span>
            <a href="{{ route('issues.show', $issue) }}" class="text-xs text-tr-dim hover:text-tr-muted transition-colors font-mono truncate max-w-xs">{{ $issue->title }}</a>
            <span class="text-tr-dim text-xs">/</span>
            <h1 class="font-display font-bold text-xl text-tr-text">Edit</h1>
        </div>
    </x-slot>

    <div class="py-8 max-w-2xl mx-auto px-4 sm:px-6">
        <div class="card p-6 animate-slide-up">
            <form method="POST" action="{{ route('issues.update', $issue) }}">
                @csrf @method('PUT')
                @include('issues._form')
                <div class="mt-6 flex gap-3 pt-5 border-t border-tr-border">
                    <button type="submit" class="btn-primary">Save Changes</button>
                    <a href="{{ route('issues.show', $issue) }}" class="btn-ghost">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
