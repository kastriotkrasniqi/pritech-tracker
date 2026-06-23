@php
$statusBadge = [
    'open'        => 'badge-open',
    'in_progress' => 'badge-in_progress',
    'closed'      => 'badge-closed',
][$issue->status] ?? 'badge-open';

$priorityConfig = [
    'low'    => ['color' => 'text-tr-muted',  'dot' => 'bg-tr-dim',    'label' => 'Low'],
    'medium' => ['color' => 'text-amber-600', 'dot' => 'bg-amber-400', 'label' => 'Medium'],
    'high'   => ['color' => 'text-red-600',   'dot' => 'bg-red-500',   'label' => 'High'],
][$issue->priority] ?? ['color' => 'text-tr-muted', 'dot' => 'bg-tr-dim', 'label' => ucfirst($issue->priority)];

$rowUrl = route('issues.show', $issue);
@endphp

<tr class="group hover:bg-tr-hover transition-colors duration-100 cursor-pointer relative"
    x-data="{ menuOpen: false }"
    @click.self="window.location='{{ $rowUrl }}'">

    {{-- Title --}}
    <td class="px-4 py-3.5" @click="window.location='{{ $rowUrl }}'">
        <span class="font-medium text-tr-text group-hover:text-tr-accent-d transition-colors text-sm">
            {{ $issue->title }}
        </span>
    </td>

    {{-- Status --}}
    <td class="px-4 py-3.5" @click="window.location='{{ $rowUrl }}'">
        <span class="{{ $statusBadge }}">
            <span class="w-1.5 h-1.5 rounded-full bg-current inline-block"></span>
            {{ ucfirst(str_replace('_', ' ', $issue->status)) }}
        </span>
    </td>

    {{-- Priority --}}
    <td class="px-4 py-3.5" @click="window.location='{{ $rowUrl }}'">
        <span class="inline-flex items-center gap-1.5 text-xs font-medium {{ $priorityConfig['color'] }}">
            <span class="w-1.5 h-1.5 rounded-full {{ $priorityConfig['dot'] }}"></span>
            {{ $priorityConfig['label'] }}
        </span>
    </td>

    {{-- Tags --}}
    <td class="px-4 py-3.5" @click="window.location='{{ $rowUrl }}'">
        <div class="flex flex-wrap gap-1">
            @foreach($issue->tags as $tag)
                <span class="px-2 py-0.5 rounded-full text-xs font-medium text-white"
                      style="background-color: {{ $tag->color ?? '#94A3B8' }}">
                    {{ $tag->name }}
                </span>
            @endforeach
        </div>
    </td>

    {{-- Due date --}}
    <td class="px-4 py-3.5 hidden sm:table-cell" @click="window.location='{{ $rowUrl }}'">
        @if($issue->due_date)
            <span class="font-mono text-xs text-tr-muted">{{ $issue->due_date->format('M d, Y') }}</span>
        @else
            <span class="text-tr-dim text-xs">—</span>
        @endif
    </td>

    {{-- Kebab menu --}}
    <td class="w-12 pr-3 py-3.5 text-right" @click.stop>
        <div class="relative" @click.outside="menuOpen = false">
            <button @click="menuOpen = !menuOpen"
                    class="w-7 h-7 rounded-lg flex items-center justify-center text-tr-dim
                           opacity-0 group-hover:opacity-100 hover:bg-tr-border hover:text-tr-muted
                           transition-all duration-100 focus:outline-none focus:opacity-100"
                    :class="{ 'opacity-100 bg-tr-border text-tr-muted': menuOpen }">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                    <circle cx="12" cy="5"  r="1.5"/>
                    <circle cx="12" cy="12" r="1.5"/>
                    <circle cx="12" cy="19" r="1.5"/>
                </svg>
            </button>

            <div x-show="menuOpen" x-cloak
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-1"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 translate-y-1"
                 class="absolute right-0 top-full mt-1 w-36 bg-white border border-tr-border rounded-xl shadow-lg z-20 py-1 overflow-hidden">

                <a href="{{ route('issues.edit', $issue) }}"
                   class="flex items-center gap-2 px-3 py-2 text-sm text-tr-muted hover:text-tr-text hover:bg-tr-raised transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit
                </a>

                <div class="border-t border-tr-border my-1"></div>

                <form method="POST" action="{{ route('issues.destroy', $issue) }}"
                      onsubmit="return confirm('Delete this issue?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="flex items-center gap-2 w-full px-3 py-2 text-sm text-red-500 hover:text-red-600 hover:bg-red-50 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </td>
</tr>
