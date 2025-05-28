<x-app-layout>
    <div class="max-w-6xl mx-auto px-4 py-10">
<div id="message-box" class="hidden mb-4 text-green-700 bg-green-100 border border-green-300 p-4 rounded"></div>


        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Projects</h1>
            <a href="{{ route('projects.create') }}" class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition">
                + Add Project
                
            </a>
        </div>

        <div class="bg-white dark:bg-gray-900 shadow rounded-xl overflow-hidden">
            <table class="min-w-full text-sm text-gray-800 dark:text-gray-100">
              <thead class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
    <tr>
        <th class="px-6 py-4 text-left">#</th>
        <th class="px-6 py-4 text-left">Name</th>
        <th class="px-6 py-4 text-left">Tasks</th>
        <th class="px-6 py-4 text-left">Completed (%)</th>
        <th class="px-6 py-4 text-left">Actions</th>
    </tr>
</thead>

                <tbody>
                  @forelse($projects as $index => $project)
    <tr data-id="{{ $project->id }}" class="{{ $loop->even ? 'bg-gray-100 dark:bg-gray-800' : 'bg-white dark:bg-gray-900' }} hover:bg-blue-50 dark:hover:bg-blue-950 transition">
        <td class="px-6 py-4">{{ $loop->iteration }}</td>
        <td class="px-6 py-4 font-semibold">{{ $project->name }}</td>
        <td class="px-6 py-4">{{ $project->tasks_count }}</td>
        <td class="px-6 py-4">
            <div class="w-full bg-gray-300 dark:bg-gray-700 rounded-full h-4 overflow-hidden">
                <div class="bg-green-500 h-full transition-all" style="width: {{ $project->completion_rate }}%"></div>
            </div>
            <span class="text-xs ml-2">{{ $project->completion_rate }}%</span>
        </td>
        <td class="px-6 py-4 space-x-2">
            <a href="{{ route('projects.edit', $project) }}" class="text-blue-600 hover:underline">Edit</a>
            <button class="text-red-600 hover:underline delete-project-btn" data-id="{{ $project->id }}">Delete</button>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="5" class="text-center py-6 text-gray-500 dark:text-gray-400">
            No projects found.
        </td>
    </tr>
@endforelse
</tbody>
            </table>
        </div>
    </div>

    <script>
        document.querySelectorAll('.delete-project-btn').forEach(button => {
            button.addEventListener('click', function () {
                if (!confirm('Are you sure you want to delete this project?')) return;

                const id = this.dataset.id;

                fetch(`/projects/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                })
                .then(res => res.json())
.then(data => {
    if (data.success) {
        document.querySelector(`tr[data-id="${id}"]`)?.remove();

        const msgBox = document.getElementById('message-box');
        msgBox.textContent = 'Project deleted successfully!';
        msgBox.classList.remove('hidden');

      
        setTimeout(() => {
            msgBox.classList.add('hidden');
            msgBox.textContent = '';
        }, 3000);
    } else {
        alert('Failed to delete project.');
    }
})
                .catch(() => alert('Error deleting project.'));
            });
        });
    </script>
</x-app-layout>
