<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="font-display font-bold text-xl text-tr-text">Projects</h1>
                <p class="text-xs text-tr-muted mt-0.5">Your active workspaces</p>
            </div>
            <a href="{{ route('projects.create') }}" class="btn-primary">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                New Project
            </a>
        </div>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-6 flex items-center gap-3 px-4 py-3 bg-tr-ok/10 border border-tr-ok/25 rounded-xl text-tr-ok text-sm animate-fade-in">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($projects as $index => $project)
                <div class="card-hover p-5 group cursor-pointer animate-slide-up"
                     onclick="window.location='{{ route('projects.show', $project) }}'">
                    <div class="flex justify-between items-start gap-3 mb-3">
                        <h3 class="font-semibold text-tr-text group-hover:text-tr-accent transition-colors duration-150 leading-snug">
                            {{ $project->name }}
                        </h3>
                        @can('update', $project)
                            <div class="flex gap-3 shrink-0 opacity-0 group-hover:opacity-100 transition-opacity duration-150 text-xs" onclick="event.stopPropagation()">
                                <a href="{{ route('projects.edit', $project) }}"
                                   class="text-tr-muted hover:text-tr-accent-d transition-colors">Edit</a>
                                <form method="POST" action="{{ route('projects.destroy', $project) }}"
                                      onsubmit="return confirm('Delete this project?')">
                                    @csrf @method('DELETE')
                                    <button class="text-tr-muted hover:text-red-600 transition-colors">Delete</button>
                                </form>
                            </div>
                        @endcan
                    </div>

                    <p class="text-sm text-tr-muted line-clamp-2 leading-relaxed">
                        {{ $project->description ?: 'No description.' }}
                    </p>

                    <div class="mt-4 pt-4 border-t border-tr-border flex items-center justify-between">
                        <span class="inline-flex items-center gap-1.5 px-2 py-1 bg-tr-raised rounded-lg text-xs text-tr-muted border border-tr-border">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            {{ $project->issues_count }} issues
                        </span>
                        <div class="flex items-center gap-3 text-xs text-tr-dim font-mono">
                            @if($project->deadline)
                                <span>{{ $project->deadline->format('M d, Y') }}</span>
                            @endif
                            <span>{{ $project->creator->name }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 py-24 text-center animate-fade-in">
                    <div class="w-12 h-12 mx-auto mb-4 rounded-xl bg-tr-raised border border-tr-border flex items-center justify-center text-tr-dim">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                    <p class="text-tr-muted text-sm">No projects yet.</p>
                    <a href="{{ route('projects.create') }}"
                       class="inline-flex mt-3 text-sm text-tr-accent hover:text-tr-accent-h transition-colors">
                        Create your first project →
                    </a>
                </div>
            @endforelse
        </div>

        <div class="mt-6">{{ $projects->links() }}</div>
    </div>
</x-app-layout>
