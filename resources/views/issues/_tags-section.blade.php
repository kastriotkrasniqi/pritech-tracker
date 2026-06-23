<div class="bg-white rounded-lg shadow p-6"
     x-data="tagManager({{ $issue->id }}, {{ $issue->tags->toJson() }}, {{ $allTags->toJson() }})">

    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-medium text-gray-900">Tags</h3>
        <button @click="open = !open" class="text-sm text-indigo-600 hover:underline">Manage Tags</button>
    </div>

    {{-- Current tags --}}
    <div class="flex flex-wrap gap-2 mb-4">
        <template x-for="tag in currentTags" :key="tag.id">
            <span class="px-2 py-1 rounded-full text-xs text-white flex items-center gap-1"
                  :style="'background-color: ' + (tag.color || '#6b7280')">
                <span x-text="tag.name"></span>
                <button @click="detach(tag.id)" class="ml-1 hover:opacity-70 font-bold">&times;</button>
            </span>
        </template>
        <span x-show="currentTags.length === 0" class="text-sm text-gray-400">No tags attached.</span>
    </div>

    {{-- Tag picker --}}
    <div x-show="open" x-cloak class="border rounded-md p-3 bg-gray-50">
        <p class="text-xs text-gray-500 mb-2">Click to attach / click &times; to detach</p>
        <div class="flex flex-wrap gap-2">
            <template x-for="tag in allTags" :key="tag.id">
                <button @click="toggle(tag)"
                    class="px-2 py-1 rounded-full text-xs text-white opacity-50 hover:opacity-100 transition"
                    :class="{ 'opacity-100': isAttached(tag.id) }"
                    :style="'background-color: ' + (tag.color || '#6b7280')"
                    x-text="tag.name">
                </button>
            </template>
        </div>
    </div>

    <div x-show="error" class="mt-2 text-sm text-red-600" x-text="error"></div>
</div>

@push('scripts')
<script>
function tagManager(issueId, initialTags, allTags) {
    return {
        issueId,
        currentTags: initialTags,
        allTags: allTags,
        open: false,
        error: '',

        isAttached(tagId) {
            return this.currentTags.some(t => t.id === tagId);
        },

        toggle(tag) {
            if (this.isAttached(tag.id)) {
                this.detach(tag.id);
            } else {
                this.attach(tag.id);
            }
        },

        attach(tagId) {
            axios.post(`/issues/${this.issueId}/tags/${tagId}`, {}, {
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
            })
            .then(res => { this.currentTags = res.data.tags; this.error = ''; })
            .catch(() => { this.error = 'Failed to attach tag.'; });
        },

        detach(tagId) {
            axios.delete(`/issues/${this.issueId}/tags/${tagId}`, {
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
            })
            .then(res => { this.currentTags = res.data.tags; this.error = ''; })
            .catch(() => { this.error = 'Failed to detach tag.'; });
        }
    }
}
</script>
@endpush
