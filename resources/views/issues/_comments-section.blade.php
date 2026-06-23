<div class="bg-white rounded-lg shadow p-6" x-data="commentsManager({{ $issue->id }})">
    <h3 class="text-lg font-medium text-gray-900 mb-6">Comments</h3>

    {{-- Add comment form --}}
    <form @submit.prevent="addComment" class="mb-6 space-y-3">
        <div>
            <label class="block text-sm font-medium text-gray-700">Your Name *</label>
            <input type="text" x-model="form.author_name"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                :class="{ 'border-red-500': errors.author_name }">
            <p class="mt-1 text-sm text-red-600" x-show="errors.author_name" x-text="errors.author_name"></p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Comment *</label>
            <textarea x-model="form.body" rows="3"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                :class="{ 'border-red-500': errors.body }"></textarea>
            <p class="mt-1 text-sm text-red-600" x-show="errors.body" x-text="errors.body"></p>
        </div>
        <button type="submit" :disabled="submitting"
            class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 disabled:opacity-50">
            <span x-text="submitting ? 'Posting...' : 'Post Comment'"></span>
        </button>
    </form>

    {{-- Comments list --}}
    <div id="comments-list" class="space-y-4">
        <template x-for="comment in comments" :key="comment.id">
            <div class="border-l-4 border-indigo-200 pl-4">
                <div class="flex justify-between text-sm">
                    <span class="font-medium text-gray-800" x-text="comment.author_name"></span>
                    <span class="text-gray-400" x-text="comment.created_at"></span>
                </div>
                <p class="mt-1 text-gray-700 whitespace-pre-wrap" x-text="comment.body"></p>
            </div>
        </template>
        <p x-show="comments.length === 0 && !loading" class="text-gray-400 text-sm">No comments yet.</p>
        <p x-show="loading" class="text-gray-400 text-sm">Loading...</p>
    </div>

    {{-- Load more --}}
    <div class="mt-4 text-center" x-show="hasMore">
        <button @click="loadMore" :disabled="loading"
            class="px-4 py-2 bg-gray-100 text-gray-600 rounded-md text-sm hover:bg-gray-200 disabled:opacity-50">
            Load more
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

        get hasMore() {
            return this.currentPage < this.lastPage;
        },

        init() {
            this.loadComments(1);
        },

        loadComments(page) {
            this.loading = true;
            axios.get(`/issues/${this.issueId}/comments?page=${page}`)
                .then(res => {
                    if (page === 1) {
                        this.comments = res.data.data;
                    } else {
                        this.comments = [...this.comments, ...res.data.data];
                    }
                    this.currentPage = res.data.current_page;
                    this.lastPage = res.data.last_page;
                })
                .finally(() => { this.loading = false; });
        },

        loadMore() {
            this.loadComments(this.currentPage + 1);
        },

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
                    // Flatten first message per field
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
