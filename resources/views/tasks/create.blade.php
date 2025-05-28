<x-app-layout>
    <div class="max-w-2xl mx-auto mt-10 p-6 bg-white dark:bg-gray-800 rounded shadow">
        <form id="taskForm" method="POST" action="{{ route('tasks.store') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Project</label>
                <select name="project_id" class="w-full border px-3 py-2 rounded" required>
                    <option value="">Select a project</option>
                    @foreach ($projects as $project)
                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                    @endforeach
                </select>
                <p class="text-red-600 text-sm mt-1 error" id="error_project_id"></p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                <input type="text" name="title" class="w-full border px-3 py-2 rounded" required>
                <p class="text-red-600 text-sm mt-1 error" id="error_title"></p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                <textarea name="description" rows="4" class="w-full border px-3 py-2 rounded"></textarea>
                <p class="text-red-600 text-sm mt-1 error" id="error_description"></p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Due Date</label>
                <input type="date" name="due_date" class="w-full border px-3 py-2 rounded">
                <p class="text-red-600 text-sm mt-1 error" id="error_due_date"></p>
            </div>

            <div>
                <button type="submit" id="submitBtn" class="inline-flex items-center justify-center bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium transition">
                    Create Task
                </button>
     
    <a
        href="{{ route('tasks.index') }}"
        class="inline-flex items-center justify-center bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md text-sm font-medium transition"
    >
        Cancel
    </a>
            </div>

            <div id="successMessage" class="text-green-600 mt-4"></div>
        </form>
    </div>

    <script>
   document.getElementById('taskForm').addEventListener('submit', function(e) {
    e.preventDefault();

    document.querySelectorAll('.error').forEach(el => el.textContent = '');
    document.getElementById('successMessage').textContent = '';

    let form = e.target;
    let url = form.action;
    let formData = new FormData(form);

    fetch(url, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => { throw err; });
        }
        return response.json();
    })
    .then(data => {
        if(data.redirect_html) {
                   document.body.innerHTML = data.redirect_html;
        }
    })
    .catch(errorData => {
        if (errorData.errors) {
            for (const key in errorData.errors) {
                let errorElem = document.getElementById('error_' + key);
                if (errorElem) {
                    errorElem.textContent = errorData.errors[key][0];
                }
            }
        } else {
            alert('Something went wrong. Please try again.');
        }
    });
});

    </script>
</x-app-layout>
