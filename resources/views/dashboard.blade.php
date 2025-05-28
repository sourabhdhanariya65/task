<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Task Management</h2>
                </div>

                <nav class="flex space-x-4">
                    <a href="{{ route('projects.index') }}"
                       class="px-4 py-2 rounded-lg text-white font-medium transition-all duration-200 
                              {{ request()->routeIs('projects.*') ? 'bg-blue-600' : 'bg-gray-600 hover:bg-blue-500' }}">
                        Projects
                    </a>

                    <a href="{{ route('tasks.index') }}"
                       class="px-4 py-2 rounded-lg text-white font-medium transition-all duration-200 
                              {{ request()->routeIs('tasks.*') ? 'bg-blue-600' : 'bg-gray-600 hover:bg-blue-500' }}">
                        Tasks
                    </a>
                </nav>
            </div>
        </div>
    </div>
</x-app-layout>
