<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">
                    <a href="{{ route('projects.show', $issue->project) }}" class="hover:underline">{{ $issue->project->name }}</a>
                </p>
                <h2 class="text-xl font-semibold text-gray-800 mt-1">{{ $issue->title }}</h2>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('issues.edit', $issue) }}" class="px-3 py-2 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-700">Edit</a>
                <form method="POST" action="{{ route('issues.destroy', $issue) }}" onsubmit="return confirm('Delete?')">
                    @csrf @method('DELETE')
                    <button class="px-3 py-2 bg-red-600 text-white text-sm rounded-md hover:bg-red-700">Delete</button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        @if(session('success'))
            <div class="p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif

        {{-- Issue Details --}}
        <div class="bg-white rounded-lg shadow p-6 grid grid-cols-3 gap-6">
            <div class="col-span-2">
                <h3 class="text-sm font-medium text-gray-500 mb-2">Description</h3>
                <p class="text-gray-800 whitespace-pre-wrap">{{ $issue->description ?? 'No description.' }}</p>
            </div>
            <div class="space-y-3 text-sm">
                <div>
                    <span class="font-medium text-gray-500">Status:</span>
                    <span class="ml-2">{{ ucfirst(str_replace('_', ' ', $issue->status)) }}</span>
                </div>
                <div>
                    <span class="font-medium text-gray-500">Priority:</span>
                    <span class="ml-2">{{ ucfirst($issue->priority) }}</span>
                </div>
                @if($issue->due_date)
                <div>
                    <span class="font-medium text-gray-500">Due:</span>
                    <span class="ml-2">{{ $issue->due_date->format('M d, Y') }}</span>
                </div>
                @endif
            </div>
        </div>

        {{-- Tags Section (AJAX modal — filled in Task 7) --}}
        @include('issues._tags-section')

        {{-- Assignees Section (AJAX — filled in Task 9) --}}
        @include('issues._assignees-section')

        {{-- Comments Section (AJAX — filled in Task 8) --}}
        @include('issues._comments-section')
    </div>

    @stack('scripts')
</x-app-layout>
