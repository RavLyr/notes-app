<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NotesApp - Your Ideas, Organized</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-100 dark:bg-gray-900">
    <div class="relative min-h-screen flex flex-col items-center justify-center">
        
        <div class="absolute top-0 right-0 p-6">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/notes') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ms-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                    @endif
                @endauth
            @endif
        </div>

        <main class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                
                <div class="text-center lg:text-left">
                    <div class="flex items-center justify-center lg:justify-start space-x-4">
                        <x-application-logo class="w-16 h-16 text-gray-700 dark:text-gray-300" />
                        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white">
                            NotesApp
                        </h1>
                    </div>

                    <p class="mt-4 text-lg text-gray-600 dark:text-gray-400">
                        A simple and elegant notes application to capture your ideas. Built with the TALL stack.
                    </p>
                    
                    <div class="mt-8 flex items-center justify-center lg:justify-start gap-4">
                        <a href="{{ route('login') }}" class="inline-block bg-blue-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-blue-700 transition">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="inline-block bg-gray-700 text-white font-bold py-3 px-6 rounded-lg hover:bg-gray-800 transition">
                            Register
                        </a>
                    </div>

                    <div class="mt-10">
                        <p class="text-sm text-gray-500">Built with:</p>
                        <div class="flex justify-center lg:justify-start space-x-4 mt-2 text-gray-400">
                           <span>Laravel</span>
                           <span>•</span>
                           <span>Tailwind CSS</span>
                           <span>•</span>
                           <span>Alpine.js</span>
                        </div>
                    </div>
                </div>

                <div class="hidden lg:block">
                    <img src="{{ asset('images/demo-apps.png') }}" alt="NotesApp Screenshot" class="rounded-lg shadow-2xl ring-1 ring-gray-900/10">
                </div>

            </div>
        </main>
        
    </div>
</body>
</html>