<x-app-layout>
    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex flex-wrap gap-2 mb-6 items-center justify-between">
            <form id="filter-form" method="GET" action="{{ route('tasks.index') }}" class="flex flex-wrap gap-3">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search task title..."
                    class="px-4 py-2 rounded border border-gray-300 dark:bg-gray-700 dark:text-white w-56"
                />
                <select
                    name="status"
                    onchange="this.form.submit()"
                    class="px-4 py-2 rounded border border-gray-300 dark:bg-gray-700 dark:text-white"
                >
                    <option value="">All</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                </select>

                <button type="submit" class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition">
                    Filter
                </button>
            </form>

            <a href="{{ route('tasks.create') }}" class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition">
                + New Task
            </a>
        </div>
<div id="message-box" class="hidden mb-4 text-green-700 bg-green-100 border border-green-300 p-4 rounded"></div>
        <div class="bg-white dark:bg-gray-900 rounded-lg shadow overflow-x-auto">
            <table class="min-w-full text-sm text-gray-900 dark:text-white divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-100 dark:bg-gray-800 text-left text-gray-700 dark:text-gray-300 uppercase">
                    <tr>
                        <th class="px-6 py-3">#</th>
                        <th class="px-6 py-3">Project</th>
                        <th class="px-6 py-3">Title</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Due Date</th>
                        <th class="px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse ($tasks as $task)
                        <tr class="hover:bg-blue-50 dark:hover:bg-blue-900 transition">
                            <td class="px-6 py-4">{{ $task->id }}</td>
                            <td class="px-6 py-4">{{ $task->project->name }}</td>
                            <td class="px-6 py-4">{{ $task->title }}</td>
                            <td class="px-6 py-4">
                                <button
                                    class="status-toggle text-white px-3 py-1 rounded-full text-xs font-semibold 
                                    {{ $task->status === 'completed' ? 'bg-green-600' : 'bg-yellow-500' }}"
                                    data-id="{{ $task->id }}">
                                    {{ ucfirst($task->status) }}
                                </button>
                            </td>
                            <td class="px-6 py-4">{{ \Carbon\Carbon::parse($task->due_date)->format('d M Y') }}</td>
                            <td class="px-6 py-4 space-x-2">
                                <a href="{{ route('tasks.edit', $task) }}" class="text-blue-600 hover:underline">Edit</a>
                                <button class="text-red-600 hover:underline delete-task" data-id="{{ $task->id }}">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr id="no-tasks-row">
                            <td colspan="6" class="text-center px-6 py-4 text-gray-500 dark:text-gray-400">
                                No tasks found.
                            </td>
                        </tr>
                    @endforelse
                    
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Toggle task status
        document.querySelectorAll('.status-toggle').forEach(button => {
            button.addEventListener('click', async function () {
                const id = this.dataset.id;
                const btn = this;

                try {
                    const response = await fetch(`/tasks/${id}/toggle`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        },
                    });

                    const result = await response.json();
                    if (result.success) {
                        btn.textContent = result.new_status.charAt(0).toUpperCase() + result.new_status.slice(1);
                        btn.classList.toggle('bg-yellow-500');
                        btn.classList.toggle('bg-green-600');
                    } else {
                        alert('Failed to toggle status.');
                    }
                } catch (error) {
                    console.error(error);
                    alert('Error updating status.');
                }
            });
        });

        // Delete task
        document.querySelectorAll('.delete-task').forEach(button => {
            button.addEventListener('click', function () {
                const taskId = this.dataset.id;
                if (!confirm('Are you sure you want to delete this task?')) return;

                fetch(`/tasks/${taskId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                    body: new URLSearchParams({ _method: 'DELETE' }),
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        this.closest('tr').remove();
                    } else {
                        alert('Failed to delete task.');
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Error deleting task.');
                });
            });
        });
    </script>
</x-app-layout>
