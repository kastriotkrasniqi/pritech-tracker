<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Tags</h2>
    </x-slot>

    <div class="py-8 max-w-3xl mx-auto px-4">
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif

        {{-- Create form --}}
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="text-lg font-medium mb-4">New Tag</h3>
            <form method="POST" action="{{ route('tags.store') }}" class="flex gap-3 items-end">
                @csrf
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="block w-full rounded-md border-gray-300 shadow-sm @error('name') border-red-500 @enderror">
                    @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Color</label>
                    <input type="color" name="color" value="{{ old('color', '#3b82f6') }}"
                        class="h-10 w-16 rounded-md border-gray-300 cursor-pointer">
                    @error('color') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Create</button>
            </form>
        </div>

        {{-- Tag list --}}
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <ul class="divide-y divide-gray-200">
                @forelse($tags as $tag)
                    <li class="flex items-center justify-between px-6 py-3">
                        <div class="flex items-center gap-3">
                            <span class="w-4 h-4 rounded-full inline-block" style="background-color: {{ $tag->color ?? '#6b7280' }}"></span>
                            <span class="font-medium text-gray-900">{{ $tag->name }}</span>
                        </div>
                        <span class="text-sm text-gray-400">{{ $tag->issues_count }} issues</span>
                    </li>
                @empty
                    <li class="px-6 py-8 text-center text-gray-400">No tags yet.</li>
                @endforelse
            </ul>
        </div>

        <div class="mt-4">{{ $tags->links() }}</div>
    </div>
</x-app-layout>
