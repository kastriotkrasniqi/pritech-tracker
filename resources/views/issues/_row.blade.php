<tr class="hover:bg-gray-50">
    <td class="px-6 py-4">
        <a href="{{ route('issues.show', $issue) }}" class="text-indigo-600 hover:underline font-medium">
            {{ $issue->title }}
        </a>
    </td>
    <td class="px-6 py-4">
        @php $statusColors = ['open' => 'bg-blue-100 text-blue-800', 'in_progress' => 'bg-yellow-100 text-yellow-800', 'closed' => 'bg-green-100 text-green-800']; @endphp
        <span class="px-2 py-1 rounded-full text-xs {{ $statusColors[$issue->status] }}">
            {{ ucfirst(str_replace('_', ' ', $issue->status)) }}
        </span>
    </td>
    <td class="px-6 py-4">
        @php $priorityColors = ['low' => 'text-gray-500', 'medium' => 'text-yellow-600', 'high' => 'text-red-600']; @endphp
        <span class="text-sm font-medium {{ $priorityColors[$issue->priority] }}">{{ ucfirst($issue->priority) }}</span>
    </td>
    <td class="px-6 py-4">
        <div class="flex flex-wrap gap-1">
            @foreach($issue->tags as $tag)
                <span class="px-2 py-0.5 rounded-full text-xs text-white" style="background-color: {{ $tag->color ?? '#6b7280' }}">
                    {{ $tag->name }}
                </span>
            @endforeach
        </div>
    </td>
    <td class="px-6 py-4 text-sm text-gray-500">
        {{ $issue->due_date?->format('M d, Y') ?? '—' }}
    </td>
    <td class="px-6 py-4 text-right text-sm">
        <a href="{{ route('issues.edit', $issue) }}" class="text-indigo-600 hover:underline mr-3">Edit</a>
        <form method="POST" action="{{ route('issues.destroy', $issue) }}" class="inline" onsubmit="return confirm('Delete?')">
            @csrf @method('DELETE')
            <button class="text-red-500 hover:underline">Delete</button>
        </form>
    </td>
</tr>
