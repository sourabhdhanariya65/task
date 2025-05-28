<x-app-layout>
    <div class="max-w-2xl mx-auto p-4">
        <h2 class="text-xl font-bold mb-4">Create Project</h2>
<form id="create-project-form" method="POST" action="{{ route('projects.store') }}" class="space-y-4">
    @csrf
            <div>
                <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Name</label>
                <input type="text" name="name" class="w-full border px-3 py-2 rounded" required>
            </div>

            <div>
                <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Description</label>
                <textarea name="description" class="w-full border px-3 py-2 rounded"></textarea>
            </div>
  <button
        type="submit"
        class="inline-flex items-center justify-center bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium transition"
    >
        Save
    </button>

    <a
        href="{{ route('projects.index') }}"
        class="inline-flex items-center justify-center bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md text-sm font-medium transition"
    >
        Cancel
    </a>
        </form>
    </div>
<script>
document.getElementById('create-project-form').addEventListener('submit', function(e) {
    e.preventDefault();

    let form = this;
    let url = form.action;
    let formData = new FormData(form);

    fetch(url, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': form.querySelector('input[name=_token]').value,
            'Accept': 'application/json',
        },
        body: formData,
    })
    .then(async response => {
        let data;
        try {
            data = await response.json();
        } catch (e) {
            alert('Server did not return valid JSON.');
            throw e;
        }

        if (!response.ok) {
            return Promise.reject(data);
        }
        return data;
    })
    .then(data => {
        if (data.redirect_html) {
            // Replace the current body with the new HTML
            document.body.innerHTML = data.redirect_html;
        } else {
            alert('Unexpected response from server.');
        }
    })
    .catch(error => {
        if (error.errors) {
            alert(Object.values(error.errors).flat().join('\n'));
        } else {
            alert('Failed to create project.');
            console.error(error);
        }
    });
});
</script>

</x-app-layout>
