<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">Projects</h2>
            <a href="{{ route('projects.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm hover:bg-indigo-700">
                New Project
            </a>
        </div>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($projects as $project)
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex justify-between items-start">
                        <h3 class="text-lg font-medium text-gray-900">
                            <a href="{{ route('projects.show', $project) }}" class="hover:text-indigo-600">
                                {{ $project->name }}
                            </a>
                        </h3>
                        @can('update', $project)
                            <div class="flex gap-2 text-sm">
                                <a href="{{ route('projects.edit', $project) }}" class="text-indigo-600 hover:underline">Edit</a>
                                <form method="POST" action="{{ route('projects.destroy', $project) }}" onsubmit="return confirm('Delete this project?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-500 hover:underline">Delete</button>
                                </form>
                            </div>
                        @endcan
                    </div>
                    <p class="mt-2 text-sm text-gray-500 line-clamp-2">{{ $project->description }}</p>
                    <div class="mt-4 flex items-center justify-between text-xs text-gray-400">
                        <span>{{ $project->issues_count }} issues</span>
                        <span>by {{ $project->creator->name }}</span>
                    </div>
                    @if($project->deadline)
                        <p class="mt-1 text-xs text-gray-400">Due: {{ $project->deadline->format('M d, Y') }}</p>
                    @endif
                </div>
            @empty
                <p class="text-gray-500 col-span-3">No projects yet. <a href="{{ route('projects.create') }}" class="text-indigo-600 hover:underline">Create one.</a></p>
            @endforelse
        </div>

        <div class="mt-6">{{ $projects->links() }}</div>
    </div>
</x-app-layout>
