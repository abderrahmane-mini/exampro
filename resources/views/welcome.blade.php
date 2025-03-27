<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .btn-primary {
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .btn-secondary {
            transition: all 0.3s ease;
        }
        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <!-- Header -->
        <header class="w-full py-4 bg-white shadow-sm">
            <div class="container mx-auto px-6 text-center">
                <h1 class="text-3xl font-bold text-blue-600">Exam Management System</h1>
            </div>
        </header>

        <!-- Main Content -->
        <main class="w-full flex-1 flex items-center justify-center">
            <div class="w-full sm:max-w-md px-6 py-8 bg-white shadow-lg rounded-lg">
                <div class="flex justify-center mb-8">
                    <x-application-logo class="w-32 h-32 text-blue-500" />
                </div>

                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold text-gray-800">Welcome to Our Platform</h2>
                    <p class="mt-2 text-gray-600">Please login to access your dashboard</p>
                </div>

                <div class="space-y-4">
                    <!-- Login Button -->
                    <a href="{{ route('login') }}" 
                       class="btn-primary w-full flex items-center justify-center px-4 py-3 bg-blue-600 border border-transparent rounded-lg font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Login
                    </a>

                    <!-- Register Button (if registration is open) -->
                    @if (Route::has('register'))
                    <a href="{{ route('register') }}" 
                       class="btn-secondary w-full flex items-center justify-center px-4 py-3 bg-gray-100 border border-transparent rounded-lg font-semibold text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition">
                        <i class="fas fa-user-plus mr-2"></i>
                        Register
                    </a>
                    @endif
                </div>

                <!-- Additional Links -->
                <div class="mt-6 text-center text-sm text-gray-500">
                    @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-blue-500 hover:text-blue-700">
                        Forgot your password?
                    </a>
                    @endif
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="w-full py-4 bg-white shadow-inner">
            <div class="container mx-auto px-6 text-center text-gray-500 text-sm">
                &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.
            </div>
        </footer>
    </div>
</body>
</html>