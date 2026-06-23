<div class="card p-5" x-data="commentsManager({{ $issue->id }})">
    <p class="section-label mb-5">Comments</p>

    {{-- Add comment form --}}
    <form @submit.prevent="addComment" class="mb-6 space-y-3 pb-5 border-b border-tr-border">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div>
                <label class="section-label block mb-1.5">Your Name *</label>
                <input type="text" x-model="form.author_name"
                    placeholder="Jane Doe"
                    class="form-field"
                    :class="errors.author_name ? 'border-tr-bad/60 focus:border-tr-bad' : ''">
                <p class="mt-1.5 text-xs text-tr-bad" x-show="errors.author_name" x-text="errors.author_name"></p>
            </div>
        </div>
        <div>
            <label class="section-label block mb-1.5">Comment *</label>
            <textarea x-model="form.body" rows="3"
                placeholder="Write a comment..."
                class="form-field resize-none"
                :class="errors.body ? 'border-tr-bad/60 focus:border-tr-bad' : ''"></textarea>
            <p class="mt-1.5 text-xs text-tr-bad" x-show="errors.body" x-text="errors.body"></p>
        </div>
        <button type="submit" :disabled="submitting"
                class="btn-primary disabled:opacity-50 disabled:cursor-not-allowed">
            <svg x-show="!submitting" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
            </svg>
            <span x-text="submitting ? 'Posting...' : 'Post Comment'"></span>
        </button>
    </form>

    {{-- Comments list --}}
    <div class="space-y-4" id="comments-list">
        <template x-for="comment in comments" :key="comment.id">
            <div class="flex gap-3">
                <div class="w-8 h-8 rounded-full bg-tr-raised border border-tr-border flex items-center justify-center text-xs font-semibold text-tr-muted shrink-0 mt-0.5"
                     x-text="comment.author_name.charAt(0).toUpperCase()">
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-baseline gap-2 mb-1">
                        <span class="text-sm font-semibold text-tr-text" x-text="comment.author_name"></span>
                        <span class="text-xs text-tr-dim font-mono" x-text="comment.created_at"></span>
                    </div>
                    <p class="text-sm text-tr-muted leading-relaxed whitespace-pre-wrap" x-text="comment.body"></p>
                </div>
            </div>
        </template>
        <div x-show="comments.length === 0 && !loading" class="py-8 text-center">
            <p class="text-tr-dim text-sm">No comments yet. Be the first!</p>
        </div>
        <div x-show="loading" class="py-4 text-center">
            <div class="inline-flex items-center gap-2 text-xs text-tr-dim">
                <svg class="w-3.5 h-3.5 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                </svg>
                Loading...
            </div>
        </div>
    </div>

    {{-- Load more --}}
    <div class="mt-4 text-center" x-show="hasMore">
        <button @click="loadMore" :disabled="loading"
                class="btn-ghost text-xs py-1.5 px-4 disabled:opacity-50">
            Load more comments
        </button>
    </div>
</div>

@push('scripts')
<script>
function commentsManager(issueId) {
    return {
        issueId,
        comments: [],
        form: { author_name: '', body: '' },
        errors: {},
        submitting: false,
        loading: false,
        currentPage: 1,
        lastPage: 1,

        get hasMore() { return this.currentPage < this.lastPage; },

        init() { this.loadComments(1); },

        loadComments(page) {
            this.loading = true;
            axios.get(`/issues/${this.issueId}/comments?page=${page}`)
                .then(res => {
                    this.comments = page === 1 ? res.data.data : [...this.comments, ...res.data.data];
                    this.currentPage = res.data.current_page;
                    this.lastPage = res.data.last_page;
                })
                .finally(() => { this.loading = false; });
        },

        loadMore() { this.loadComments(this.currentPage + 1); },

        addComment() {
            this.errors = {};
            this.submitting = true;
            axios.post(`/issues/${this.issueId}/comments`, this.form, {
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
            })
            .then(res => {
                this.comments.unshift(res.data);
                this.form = { author_name: '', body: '' };
            })
            .catch(err => {
                if (err.response?.status === 422) {
                    this.errors = err.response.data.errors;
                    Object.keys(this.errors).forEach(k => {
                        if (Array.isArray(this.errors[k])) this.errors[k] = this.errors[k][0];
                    });
                }
            })
            .finally(() => { this.submitting = false; });
        }
    }
}
</script>
@endpush
