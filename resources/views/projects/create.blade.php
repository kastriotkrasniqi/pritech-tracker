<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">New Project</h2>
    </x-slot>

    <div class="py-8 max-w-2xl mx-auto px-4">
        <div class="bg-white rounded-lg shadow p-6">
            <form method="POST" action="{{ route('projects.store') }}">
                @csrf
                @include('projects._form')
                <div class="mt-6 flex gap-3">
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Create Project</button>
                    <a href="{{ route('projects.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
