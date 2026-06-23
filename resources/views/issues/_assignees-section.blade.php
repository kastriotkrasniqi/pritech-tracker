<div class="card p-5"
     x-data="assigneeManager({{ $issue->id }}, {{ $issue->assignees->toJson() }}, {{ $allUsers->toJson() }})">

    <div class="flex items-center justify-between mb-4">
        <p class="section-label">Assignees</p>
        <button @click="open = !open"
                class="text-xs text-tr-accent hover:text-tr-accent-h transition-colors font-medium"
                x-text="open ? 'Done' : 'Manage'">
        </button>
    </div>

    <div class="flex flex-wrap gap-2 min-h-[24px]">
        <template x-for="user in currentAssignees" :key="user.id">
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-tr-raised border border-tr-border text-tr-text">
                <span class="w-4 h-4 rounded-full bg-tr-accent/15 border border-tr-accent/25 flex items-center justify-center text-[9px] font-bold text-tr-accent"
                      x-text="user.name.charAt(0).toUpperCase()"></span>
                <span x-text="user.name"></span>
                <button @click="detach(user.id)" class="ml-0.5 hover:text-tr-bad transition-colors text-tr-dim text-base font-light leading-none">&times;</button>
            </span>
        </template>
        <span x-show="currentAssignees.length === 0" class="text-sm text-tr-dim">No assignees.</span>
    </div>

    <div x-show="open" x-cloak
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0 translate-y-1"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="mt-4 pt-4 border-t border-tr-border">
        <p class="text-xs text-tr-dim mb-3">Click to assign / unassign</p>
        <div class="flex flex-wrap gap-2">
            <template x-for="user in allUsers" :key="user.id">
                <button @click="toggle(user)"
                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium transition-all duration-100"
                        :class="isAssigned(user.id)
                            ? 'bg-tr-accent/15 text-tr-accent border border-tr-accent/30'
                            : 'bg-tr-raised text-tr-muted border border-tr-border hover:border-tr-border-s hover:text-tr-text'"
                        x-text="user.name">
                </button>
            </template>
        </div>
    </div>
</div>

@push('scripts')
<script>
function assigneeManager(issueId, initialAssignees, allUsers) {
    return {
        issueId,
        currentAssignees: initialAssignees,
        allUsers: allUsers,
        open: false,

        isAssigned(userId) {
            return this.currentAssignees.some(u => u.id === userId);
        },

        toggle(user) {
            this.isAssigned(user.id) ? this.detach(user.id) : this.attach(user.id);
        },

        attach(userId) {
            axios.post(`/issues/${this.issueId}/users/${userId}`, {}, {
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
            }).then(res => { this.currentAssignees = res.data.assignees; });
        },

        detach(userId) {
            axios.delete(`/issues/${this.issueId}/users/${userId}`, {
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
            }).then(res => { this.currentAssignees = res.data.assignees; });
        }
    }
}
</script>
@endpush
