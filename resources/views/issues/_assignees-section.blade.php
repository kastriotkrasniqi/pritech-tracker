<div class="bg-white rounded-lg shadow p-6"
     x-data="assigneeManager({{ $issue->id }}, {{ $issue->assignees->toJson() }}, {{ $allUsers->toJson() }})">

    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-medium text-gray-900">Assignees</h3>
        <button @click="open = !open" class="text-sm text-indigo-600 hover:underline">Manage</button>
    </div>

    <div class="flex flex-wrap gap-2 mb-4">
        <template x-for="user in currentAssignees" :key="user.id">
            <span class="px-3 py-1 rounded-full text-xs bg-indigo-100 text-indigo-800 flex items-center gap-1">
                <span x-text="user.name"></span>
                <button @click="detach(user.id)" class="ml-1 hover:opacity-70 font-bold">&times;</button>
            </span>
        </template>
        <span x-show="currentAssignees.length === 0" class="text-sm text-gray-400">No assignees.</span>
    </div>

    <div x-show="open" x-cloak class="border rounded-md p-3 bg-gray-50">
        <p class="text-xs text-gray-500 mb-2">Click to assign / × to unassign</p>
        <div class="flex flex-wrap gap-2">
            <template x-for="user in allUsers" :key="user.id">
                <button @click="toggle(user)"
                    class="px-3 py-1 rounded-full text-xs transition"
                    :class="isAssigned(user.id) ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'"
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
