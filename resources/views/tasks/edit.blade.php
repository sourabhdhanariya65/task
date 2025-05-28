<x-app-layout>
    <div class="max-w-2xl mx-auto p-6">
        <h2 class="text-2xl font-semibold mb-6 text-gray-800 dark:text-white">Edit Task</h2>
        <!-- Success Message -->
        <div id="successMessage" class="hidden text-green-700 bg-green-100 border border-green-300 p-3 rounded mb-4"></div>
        <form id="editTaskForm" method="POST" action="{{ route('tasks.update', $task) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Project -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Project</label>
                <select name="project_id" class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 dark:bg-gray-700 dark:text-white" required>
                    @foreach ($projects as $project)
                        <option value="{{ $project->id }}" {{ $task->project_id == $project->id ? 'selected' : '' }}>
                            {{ $project->name }}
                        </option>
                    @endforeach
                </select>
                <p class="text-red-600 text-sm mt-1 error" id="error_project_id"></p>
            </div>

            <!-- Title -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Title</label>
                <input type="text" name="title" value="{{ $task->title }}" class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 dark:bg-gray-700 dark:text-white" required>
                <p class="text-red-600 text-sm mt-1 error" id="error_title"></p>
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                <textarea name="description" class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 dark:bg-gray-700 dark:text-white" rows="4">{{ $task->description }}</textarea>
                <p class="text-red-600 text-sm mt-1 error" id="error_description"></p>
            </div>

            <!-- Due Date -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Due Date</label>
                <input type="date" name="due_date" value="{{ $task->due_date ? $task->due_date->format('Y-m-d') : '' }}" class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 dark:bg-gray-700 dark:text-white">
                <p class="text-red-600 text-sm mt-1 error" id="error_due_date"></p>
            </div>

            <!-- Buttons -->
            <div class="flex gap-4 mt-6">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-md text-sm font-medium transition">
                    Update Task
                </button>
                <a href="{{ route('projects.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-md text-sm font-medium transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('editTaskForm').addEventListener('submit', function (e) {
            e.preventDefault();

            document.querySelectorAll('.error').forEach(el => el.textContent = '');
            const successBox = document.getElementById('successMessage');
            successBox.classList.add('hidden');
            successBox.textContent = '';

            const form = e.target;
            const url = form.action;
            const formData = new FormData(form);
            formData.append('_method', 'PUT');

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                body: formData,
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw err; });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    successBox.textContent = 'Task updated successfully!';
                    successBox.classList.remove('hidden');
                    setTimeout(() => successBox.classList.add('hidden'), 3000);
                }
            })
            .catch(errorData => {
                if (errorData.errors) {
                    for (const key in errorData.errors) {
                        let el = document.getElementById('error_' + key);
                        if (el) el.textContent = errorData.errors[key][0];
                    }
                } else {
                    alert('Something went wrong. Please try again.');
                }
            });
        });
    </script>
</x-app-layout>
