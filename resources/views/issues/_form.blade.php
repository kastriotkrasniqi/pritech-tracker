<div class="space-y-5">
    <div>
        <label class="section-label block mb-1.5">Title *</label>
        <input type="text" name="title" value="{{ old('title', $issue->title ?? '') }}"
               placeholder="Brief, descriptive title"
               class="form-field @error('title') border-tr-bad/60 @enderror">
        @error('title') <p class="mt-1.5 text-xs text-tr-bad">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="section-label block mb-1.5">Description</label>
        <textarea name="description" rows="5"
                  placeholder="Describe the issue in detail..."
                  class="form-field resize-none">{{ old('description', $issue->description ?? '') }}</textarea>
        @error('description') <p class="mt-1.5 text-xs text-tr-bad">{{ $message }}</p> @enderror
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="section-label block mb-1.5">Status *</label>
            <select name="status" class="form-field">
                @foreach(['open', 'in_progress', 'closed'] as $s)
                    <option value="{{ $s }}" @selected(old('status', $issue->status ?? 'open') === $s)>
                        {{ ucfirst(str_replace('_', ' ', $s)) }}
                    </option>
                @endforeach
            </select>
            @error('status') <p class="mt-1.5 text-xs text-tr-bad">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="section-label block mb-1.5">Priority *</label>
            <select name="priority" class="form-field">
                @foreach(['low', 'medium', 'high'] as $p)
                    <option value="{{ $p }}" @selected(old('priority', $issue->priority ?? 'medium') === $p)>
                        {{ ucfirst($p) }}
                    </option>
                @endforeach
            </select>
            @error('priority') <p class="mt-1.5 text-xs text-tr-bad">{{ $message }}</p> @enderror
        </div>
    </div>

    <div>
        <label class="section-label block mb-1.5">Due Date</label>
        <input type="date" name="due_date"
               value="{{ old('due_date', isset($issue) ? $issue->due_date?->format('Y-m-d') : '') }}"
               class="form-field">
        @error('due_date') <p class="mt-1.5 text-xs text-tr-bad">{{ $message }}</p> @enderror
    </div>
</div>
