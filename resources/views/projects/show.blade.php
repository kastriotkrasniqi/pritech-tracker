<x-app-layout>
    <x-slot name="header">
        <div class="flex items-start justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <a href="{{ route('projects.index') }}"
                       class="text-xs text-tr-muted hover:text-tr-text transition-colors font-mono">Projects</a>
                    <span class="text-tr-dim text-xs">/</span>
                </div>
                <h1 class="font-bold text-xl text-tr-text">{{ $project->name }}</h1>
                @if($project->description)
                    <p class="text-sm text-tr-muted mt-0.5">{{ $project->description }}</p>
                @endif
            </div>
            <a href="{{ route('projects.issues.create', $project) }}" class="btn-primary shrink-0">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                New Issue
            </a>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Filters --}}
        <div class="card p-4 mb-4">
            <form method="GET" class="flex flex-wrap gap-3 items-end">
                {{-- preserve sort --}}
                @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif
                @if(request('dir'))  <input type="hidden" name="dir"  value="{{ request('dir') }}">  @endif

                <div>
                    <label class="section-label block mb-1.5">Status</label>
                    <select name="status" class="form-field py-1.5 pr-8 text-xs h-8">
                        <option value="">All</option>
                        @foreach(['open', 'in_progress', 'closed'] as $s)
                            <option value="{{ $s }}" @selected(($filters['status'] ?? '') === $s)>
                                {{ ucfirst(str_replace('_', ' ', $s)) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="section-label block mb-1.5">Priority</label>
                    <select name="priority" class="form-field py-1.5 pr-8 text-xs h-8">
                        <option value="">All</option>
                        @foreach(['low', 'medium', 'high'] as $p)
                            <option value="{{ $p }}" @selected(($filters['priority'] ?? '') === $p)>
                                {{ ucfirst($p) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="section-label block mb-1.5">Tag</label>
                    <select name="tag" class="form-field py-1.5 pr-8 text-xs h-8">
                        <option value="">All</option>
                        @foreach($tags as $tag)
                            <option value="{{ $tag->id }}" @selected(($filters['tag'] ?? '') == $tag->id)>
                                {{ $tag->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div x-data="searchIssues('{{ route('projects.show', $project) }}')" class="flex-1 min-w-[180px]">
                    <label class="section-label block mb-1.5">Search</label>
                    <div class="relative">
                        <svg class="absolute left-2.5 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-tr-dim" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/>
                        </svg>
                        <input type="text" x-model="query" @input.debounce.300ms="search"
                            placeholder="Search issues..."
                            class="form-field pl-8 py-1.5 text-xs h-8">
                    </div>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="btn-primary py-1.5 px-3 text-xs h-8">Filter</button>
                    <a href="{{ route('projects.show', $project) }}" class="btn-ghost py-1.5 px-3 text-xs h-8">Reset</a>
                </div>
            </form>
        </div>

        {{-- Issues table --}}
        <div class="card" id="issues-container">
            <table class="min-w-full" id="issues-table">
                <thead>
                    <tr class="border-b border-tr-border bg-tr-raised/60">

                        {{-- Sortable: Title --}}
                        @php
                        function sortUrl($col, $currentSort, $currentDir) {
                            $params = request()->except(['sort', 'dir', 'page']);
                            $newDir = ($currentSort === $col && $currentDir === 'asc') ? 'desc' : 'asc';
                            return '?' . http_build_query(array_merge($params, ['sort' => $col, 'dir' => $newDir]));
                        }
                        @endphp

                        <th class="px-4 py-3 text-left">
                            <a href="{{ sortUrl('title', $sort, $dir) }}"
                               class="inline-flex items-center gap-1 section-label hover:text-tr-text transition-colors">
                                Title
                                @if($sort === 'title')
                                    <svg class="w-3 h-3 {{ $dir === 'asc' ? '' : 'rotate-180' }} transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"/>
                                    </svg>
                                @else
                                    <svg class="w-3 h-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4M8 15l4 4 4-4"/>
                                    </svg>
                                @endif
                            </a>
                        </th>

                        {{-- Sortable: Status --}}
                        <th class="px-4 py-3 text-left">
                            <a href="{{ sortUrl('status', $sort, $dir) }}"
                               class="inline-flex items-center gap-1 section-label hover:text-tr-text transition-colors">
                                Status
                                @if($sort === 'status')
                                    <svg class="w-3 h-3 {{ $dir === 'asc' ? '' : 'rotate-180' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"/>
                                    </svg>
                                @else
                                    <svg class="w-3 h-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4M8 15l4 4 4-4"/>
                                    </svg>
                                @endif
                            </a>
                        </th>

                        {{-- Sortable: Priority --}}
                        <th class="px-4 py-3 text-left">
                            <a href="{{ sortUrl('priority', $sort, $dir) }}"
                               class="inline-flex items-center gap-1 section-label hover:text-tr-text transition-colors">
                                Priority
                                @if($sort === 'priority')
                                    <svg class="w-3 h-3 {{ $dir === 'asc' ? '' : 'rotate-180' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"/>
                                    </svg>
                                @else
                                    <svg class="w-3 h-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4M8 15l4 4 4-4"/>
                                    </svg>
                                @endif
                            </a>
                        </th>

                        <th class="px-4 py-3 text-left section-label">Tags</th>

                        {{-- Sortable: Due --}}
                        <th class="px-4 py-3 text-left hidden sm:table-cell">
                            <a href="{{ sortUrl('due_date', $sort, $dir) }}"
                               class="inline-flex items-center gap-1 section-label hover:text-tr-text transition-colors">
                                Due
                                @if($sort === 'due_date')
                                    <svg class="w-3 h-3 {{ $dir === 'asc' ? '' : 'rotate-180' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"/>
                                    </svg>
                                @else
                                    <svg class="w-3 h-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4M8 15l4 4 4-4"/>
                                    </svg>
                                @endif
                            </a>
                        </th>

                        <th class="w-12 pr-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-tr-border" id="issues-tbody">
                    @forelse($issues as $issue)
                        @include('issues._row', compact('issue'))
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-16 text-center text-tr-muted text-sm">
                                No issues found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>

        <div class="mt-4" id="issues-pagination">{{ $issues->withQueryString()->links() }}</div>
    </div>

    @push('scripts')
    <script>
    function searchIssues(baseUrl) {
        return {
            query: @json($filters['search'] ?? ''),
            search() {
                const params = new URLSearchParams(window.location.search);
                if (this.query) { params.set('search', this.query); }
                else { params.delete('search'); }
                window.location.search = params.toString();
            }
        }
    }
    </script>
    @endpush
</x-app-layout>
