<div class="space-y-5">
    <div>
        <label class="section-label block mb-1.5">Name *</label>
        <input type="text" name="name" value="{{ old('name', $project->name ?? '') }}"
               placeholder="My Project"
               class="form-field @error('name') border-tr-bad/60 @enderror">
        @error('name') <p class="mt-1.5 text-xs text-tr-bad">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="section-label block mb-1.5">Description</label>
        <textarea name="description" rows="4"
                  placeholder="What is this project about?"
                  class="form-field resize-none">{{ old('description', $project->description ?? '') }}</textarea>
        @error('description') <p class="mt-1.5 text-xs text-tr-bad">{{ $message }}</p> @enderror
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="section-label block mb-1.5">Start Date</label>
            <input type="date" name="start_date"
                   value="{{ old('start_date', isset($project) ? $project->start_date?->format('Y-m-d') : '') }}"
                   class="form-field">
            @error('start_date') <p class="mt-1.5 text-xs text-tr-bad">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="section-label block mb-1.5">Deadline</label>
            <input type="date" name="deadline"
                   value="{{ old('deadline', isset($project) ? $project->deadline?->format('Y-m-d') : '') }}"
                   class="form-field">
            @error('deadline') <p class="mt-1.5 text-xs text-tr-bad">{{ $message }}</p> @enderror
        </div>
    </div>
</div>
