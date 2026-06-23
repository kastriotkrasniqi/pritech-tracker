<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-800">{{ $project->name }}</h2>
                <p class="text-sm text-gray-500 mt-1">{{ $project->description }}</p>
            </div>
            <a href="{{ route('projects.issues.create', $project) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm hover:bg-indigo-700">
                New Issue
            </a>
        </div>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Filters + Search --}}
        <div class="bg-white rounded-lg shadow p-4 mb-6">
            <form method="GET" class="flex flex-wrap gap-3 items-end">
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Status</label>
                    <select name="status" class="rounded-md border-gray-300 text-sm">
                        <option value="">All</option>
                        @foreach(['open', 'in_progress', 'closed'] as $s)
                            <option value="{{ $s }}" @selected(($filters['status'] ?? '') === $s)>{{ ucfirst(str_replace('_', ' ', $s)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Priority</label>
                    <select name="priority" class="rounded-md border-gray-300 text-sm">
                        <option value="">All</option>
                        @foreach(['low', 'medium', 'high'] as $p)
                            <option value="{{ $p }}" @selected(($filters['priority'] ?? '') === $p)>{{ ucfirst($p) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Tag</label>
                    <select name="tag" class="rounded-md border-gray-300 text-sm">
                        <option value="">All</option>
                        @foreach($tags as $tag)
                            <option value="{{ $tag->id }}" @selected(($filters['tag'] ?? '') == $tag->id)>{{ $tag->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Search with debounce (Alpine.js) --}}
                <div x-data="searchIssues('{{ route('projects.show', $project) }}')" class="flex-1 min-w-48">
                    <label class="block text-xs font-medium text-gray-600 mb-1">Search</label>
                    <input type="text" x-model="query" @input.debounce.300ms="search"
                        placeholder="Search issues..."
                        class="block w-full rounded-md border-gray-300 text-sm">
                </div>

                <button type="submit" class="px-3 py-2 bg-gray-700 text-white text-sm rounded-md hover:bg-gray-800">Filter</button>
                <a href="{{ route('projects.show', $project) }}" class="px-3 py-2 bg-gray-100 text-gray-600 text-sm rounded-md hover:bg-gray-200">Reset</a>
            </form>
        </div>

        {{-- Issues Table --}}
        <div class="bg-white rounded-lg shadow overflow-hidden" id="issues-container">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Priority</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tags</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Due</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200" id="issues-tbody">
                    @forelse($issues as $issue)
                        @include('issues._row', compact('issue'))
                    @empty
                        <tr><td colspan="6" class="px-6 py-8 text-center text-gray-400">No issues found.</td></tr>
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
            query: '{{ $filters["search"] ?? "" }}',
            search() {
                const url = new URL(baseUrl);
                const params = new URLSearchParams(window.location.search);
                if (this.query) {
                    params.set('search', this.query);
                } else {
                    params.delete('search');
                }
                window.location.search = params.toString();
            }
        }
    }
    </script>
    @endpush
</x-app-layout>
