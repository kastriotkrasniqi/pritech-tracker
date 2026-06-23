<x-app-layout>
    <x-slot name="header">
        <h1 class="font-bold text-xl text-tr-text">Tags</h1>
        <p class="text-xs text-tr-muted mt-0.5">Manage labels for your issues</p>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-6 flex items-center gap-3 px-4 py-3 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-700 text-sm animate-fade-in">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- Create form --}}
        <div class="card p-5 mb-6 animate-slide-up">
            <p class="section-label mb-4">New Tag</p>
            <form method="POST" action="{{ route('tags.store') }}"
                  class="flex flex-wrap gap-3 items-end">
                @csrf
                <div class="flex-1 min-w-[200px]">
                    <label class="section-label block mb-1.5">Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                           placeholder="e.g. bug, feature, urgent"
                           class="form-field @error('name') border-red-400 @enderror">
                    @error('name') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="section-label block mb-1.5">Color</label>
                    <input type="color" name="color" value="{{ old('color', '#3ECF8E') }}"
                           class="w-10 h-9 rounded-lg border border-tr-border bg-white cursor-pointer p-0.5">
                    @error('color') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <button type="submit" class="btn-primary">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    Create Tag
                </button>
            </form>
        </div>

        {{-- Pills --}}
        @if($tags->count())
            <div class="flex flex-wrap gap-3 animate-fade-in">
                @foreach($tags as $tag)
                    <div class="group inline-flex items-center gap-2 pl-3 pr-1 py-1.5 rounded-full text-sm font-medium text-white shadow-sm transition-all duration-150 hover:shadow-md hover:scale-105"
                         style="background-color: {{ $tag->color ?? '#94A3B8' }}">

                        <span class="leading-none">{{ $tag->name }}</span>

                        <span class="text-xs opacity-70 leading-none font-normal">
                            {{ $tag->issues_count }}
                        </span>

                        <form method="POST" action="{{ route('tags.destroy', $tag) }}"
                              class="inline-flex"
                              onsubmit="return confirm('Delete tag \'{{ addslashes($tag->name) }}\'?')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="w-5 h-5 rounded-full bg-black/20 hover:bg-black/40 flex items-center justify-center transition-colors duration-100 focus:outline-none"
                                    title="Remove tag">
                                <svg class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">{{ $tags->links() }}</div>
        @else
            <div class="card py-16 text-center animate-fade-in">
                <p class="text-tr-muted text-sm">No tags yet. Create your first one above.</p>
            </div>
        @endif
    </div>
</x-app-layout>
