<div class="card p-5"
     x-data="tagManager({{ $issue->id }}, {{ $issue->tags->toJson() }}, {{ $allTags->toJson() }})">

    <div class="flex items-center justify-between mb-4">
        <p class="section-label">Tags</p>
        <button @click="open = !open"
                class="text-xs text-tr-accent hover:text-tr-accent-h transition-colors font-medium"
                x-text="open ? 'Done' : 'Manage'">
        </button>
    </div>

    <div class="flex flex-wrap gap-2 min-h-[24px]">
        <template x-for="tag in currentTags" :key="tag.id">
            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium text-white/90"
                  :style="'background-color: ' + (tag.color || '#3a4460')">
                <span x-text="tag.name"></span>
                <button @click="detach(tag.id)" class="ml-0.5 hover:opacity-70 leading-none text-base font-light">&times;</button>
            </span>
        </template>
        <span x-show="currentTags.length === 0" class="text-sm text-tr-dim">No tags attached.</span>
    </div>

    <div x-show="open" x-cloak
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0 translate-y-1"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="mt-4 pt-4 border-t border-tr-border">
        <p class="text-xs text-tr-dim mb-3">Click to toggle tags</p>
        <div class="flex flex-wrap gap-2">
            <template x-for="tag in allTags" :key="tag.id">
                <button @click="toggle(tag)"
                        class="px-2.5 py-1 rounded-full text-xs font-medium text-white/90 transition-all duration-100"
                        :class="isAttached(tag.id) ? 'opacity-100 ring-2 ring-white/20' : 'opacity-40 hover:opacity-70'"
                        :style="'background-color: ' + (tag.color || '#3a4460')"
                        x-text="tag.name">
                </button>
            </template>
            <span x-show="allTags.length === 0" class="text-sm text-tr-dim">No tags available. <a href="{{ route('tags.index') }}" class="text-tr-accent hover:text-tr-accent-h">Create some →</a></span>
        </div>
    </div>

    <p x-show="error" class="mt-3 text-xs text-tr-bad" x-text="error"></p>
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
            this.isAttached(tag.id) ? this.detach(tag.id) : this.attach(tag.id);
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
