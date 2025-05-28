<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Laravel</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
</head>
<body class="antialiased bg-gray-50 dark:bg-gray-900 flex flex-col min-h-screen">

<header class="shadow-md bg-white dark:bg-gray-800">
    <nav class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        <!-- Logo -->
        <a href="{{ url('/') }}" class="flex items-center space-x-2">
            <span class="text-2xl font-bold md:text-3xl bg-gradient-to-r from-pink-500 via-red-500 to-yellow-500 bg-clip-text text-transparent">
                Task Management System
            </span>
        </a>

        <!-- Auth Links -->
        <div class="space-x-4 text-right">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" 
                       class="text-gray-700 dark:text-gray-300 font-semibold hover:text-blue-600 dark:hover:text-blue-400 transition">
                       Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="hover:bg-clip-text hover:text-transparent bg-gradient-to-br from-[#2b68e0] to-[#e710ea] border-solid border-2 border-[#5356e3]  font-bold text-white px-5 py-2 rounded-full">
                       Log in
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="hover:bg-clip-text hover:text-transparent bg-gradient-to-br from-[#2b68e0] to-[#e710ea] border-solid border-2 border-[#5356e3]  font-bold text-white px-5 py-2 rounded-full">
                           Register
                        </a>
                    @endif
                @endauth
            @endif
        </div>
    </nav>
</header>

<!-- Main content area -->
<main class="max-w-7xl mx-auto px-6 py-10 flex-grow">
    <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white mb-6">Welcome to the Task Management System</h1>
    <p class="text-lg text-gray-700 dark:text-gray-300 mb-4">
        Manage your tasks efficiently and stay organized with our easy-to-use system.
    </p>
    <p class="text-gray-600 dark:text-gray-400 mb-8">
        Use the navigation links above to log in or register and start managing your projects and tasks.
    </p>

    <!-- Example feature cards or content -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-2 text-gray-800 dark:text-gray-200">Create Projects</h2>
            <p class="text-gray-600 dark:text-gray-300">Easily create and manage multiple projects to organize your work.</p>
        </div>
        <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-2 text-gray-800 dark:text-gray-200">Track Tasks</h2>
            <p class="text-gray-600 dark:text-gray-300">Keep track of tasks, deadlines, and progress with a simple interface.</p>
        </div>
        <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-2 text-gray-800 dark:text-gray-200">Collaborate</h2>
            <p class="text-gray-600 dark:text-gray-300">Work together with your team seamlessly in real-time.</p>
        </div>
    </div>
</main>

<!-- Footer -->
<footer class="bg-gray-800 dark:bg-gray-900 text-gray-400 dark:text-gray-500 py-6 mt-auto">
    <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center">
        <p class="text-sm">&copy; {{ date('Y') }} Task Management System. All rights reserved.</p>
        <div class="space-x-4 mt-3 md:mt-0">
            <a href="#" class="hover:text-white transition">Privacy Policy</a>
            <a href="#" class="hover:text-white transition">Terms of Service</a>
            <a href="#" class="hover:text-white transition">Contact</a>
        </div>
    </div>
</footer>

<!-- Ionicons scripts -->
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</body>
</html>
