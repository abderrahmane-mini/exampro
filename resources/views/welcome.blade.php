<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Exam Management System') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .btn-primary, .btn-secondary {
            transition: all 0.3s ease;
        }
        .btn-primary:hover, .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">

        <!-- Header -->
        <header class="w-full py-4 bg-white shadow-sm">
            <div class="container mx-auto px-6 text-center">
                <h1 class="text-3xl font-bold text-blue-600">{{ config('app.name', 'Exam Management System') }}</h1>
            </div>
        </header>

        <!-- Main Content -->
        <main class="w-full flex-1 flex items-center justify-center">
            <div class="w-full sm:max-w-md px-6 py-8 bg-white shadow-lg rounded-lg">

                <!-- Logo -->
                <div class="flex justify-center mb-8">
                    <x-application-logo class="w-32 h-32 text-blue-500" />
                </div>

                <!-- Welcome Text -->
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold text-gray-800">Bienvenue sur la plateforme</h2>
                    <p class="mt-2 text-gray-600">Veuillez vous connecter pour accéder à votre tableau de bord</p>
                </div>

                <!-- Already logged in? -->
                @auth
                    <div class="text-center mb-4">
                        <a href="{{ route('dashboard') }}" class="text-sm text-blue-600 hover:underline">
                            Accéder à mon tableau de bord
                        </a>
                    </div>
                @endauth

                <!-- Login / Register -->
                <div class="space-y-4">
                    <a href="{{ route('login') }}" 
                       class="btn-primary w-full flex items-center justify-center px-4 py-3 bg-blue-600 border border-transparent rounded-lg font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Se connecter
                    </a>

                    @if (Route::has('register'))
                    <a href="{{ route('register') }}" 
                       class="btn-secondary w-full flex items-center justify-center px-4 py-3 bg-gray-100 border border-transparent rounded-lg font-semibold text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        <i class="fas fa-user-plus mr-2"></i>
                        S’inscrire
                    </a>
                    @endif
                </div>

                <!-- Forgot Password -->
                <div class="mt-6 text-center text-sm text-gray-500">
                    @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-blue-500 hover:text-blue-700">
                        Mot de passe oublié ?
                    </a>
                    @endif
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="w-full py-4 bg-white shadow-inner">
            <div class="container mx-auto px-6 text-center text-gray-500 text-sm">
                &copy; {{ date('Y') }} {{ config('app.name', 'Exam Management System') }}. Tous droits réservés.
            </div>
        </footer>
    </div>
</body>
</html>
