<x-app-layout>
    <x-slot name="header">
        <div class="flex items-start justify-between gap-4">
            <div class="min-w-0">
                <div class="flex items-center gap-2 mb-1">
                    <a href="{{ route('projects.index') }}"
                       class="text-xs text-tr-dim hover:text-tr-muted transition-colors font-mono">Projects</a>
                    <span class="text-tr-dim text-xs">/</span>
                    <a href="{{ route('projects.show', $issue->project) }}"
                       class="text-xs text-tr-dim hover:text-tr-muted transition-colors font-mono truncate">
                        {{ $issue->project->name }}
                    </a>
                    <span class="text-tr-dim text-xs">/</span>
                </div>
                <h1 class="font-display font-bold text-xl text-tr-text leading-snug">{{ $issue->title }}</h1>
            </div>
            <div class="flex gap-2 shrink-0">
                <a href="{{ route('issues.edit', $issue) }}" class="btn-ghost text-xs py-1.5 px-3">Edit</a>
                <form method="POST" action="{{ route('issues.destroy', $issue) }}"
                      onsubmit="return confirm('Delete this issue?')">
                    @csrf @method('DELETE')
                    <button class="btn-danger text-xs py-1.5 px-3">Delete</button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
        @if(session('success'))
            <div class="flex items-center gap-3 px-4 py-3 bg-tr-ok/10 border border-tr-ok/25 rounded-xl text-tr-ok text-sm animate-fade-in">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- Issue details card --}}
        @php
        $statusBadge = ['open' => 'badge-open', 'in_progress' => 'badge-in_progress', 'closed' => 'badge-closed'][$issue->status] ?? 'badge-open';
        $priorityColor = ['low' => 'text-tr-muted', 'medium' => 'text-amber-600', 'high' => 'text-red-600'][$issue->priority] ?? 'text-tr-muted';
        $priorityDot = ['low' => 'bg-tr-dim', 'medium' => 'bg-amber-400', 'high' => 'bg-red-500'][$issue->priority] ?? 'bg-tr-dim';
        @endphp

        <div class="card">
            <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2">
                    <p class="section-label mb-3">Description</p>
                    <p class="text-tr-text text-sm leading-relaxed whitespace-pre-wrap">{{ trim($issue->description) ?: 'No description provided.' }}</p>
                </div>
                <div class="space-y-4 md:border-l md:border-tr-border md:pl-6">
                    <div>
                        <p class="section-label mb-1.5">Status</p>
                        <span class="{{ $statusBadge }}">
                            <span class="w-1.5 h-1.5 rounded-full bg-current inline-block"></span>
                            {{ ucfirst(str_replace('_', ' ', $issue->status)) }}
                        </span>
                    </div>
                    <div>
                        <p class="section-label mb-1.5">Priority</p>
                        <span class="inline-flex items-center gap-1.5 text-sm font-medium {{ $priorityColor }}">
                            <span class="w-2 h-2 rounded-full {{ $priorityDot }}"></span>
                            {{ ucfirst($issue->priority) }}
                        </span>
                    </div>
                    @if($issue->due_date)
                    <div>
                        <p class="section-label mb-1.5">Due Date</p>
                        <span class="font-mono text-sm text-tr-text">{{ $issue->due_date->format('M d, Y') }}</span>
                    </div>
                    @endif
                    <div>
                        <p class="section-label mb-1.5">Project</p>
                        <a href="{{ route('projects.show', $issue->project) }}"
                           class="text-sm text-tr-muted hover:text-tr-accent transition-colors">
                            {{ $issue->project->name }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        @include('issues._tags-section')
        @include('issues._assignees-section')
        @include('issues._comments-section')
    </div>

    @stack('scripts')
</x-app-layout>
