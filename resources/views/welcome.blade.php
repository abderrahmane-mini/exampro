<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Exam Management System') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .login-container {
            max-width: 450px;
            margin: 0 auto;
        }
        .header-title {
            color: #0d6efd;
        }
        .btn-login {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
    </style>
</head>
<body>
    <div class="d-flex flex-column min-vh-100">
        <!-- Header -->
        <header class="py-4 bg-white shadow-sm">
            <div class="container text-center">
                <h1 class="header-title fw-bold">{{ config('app.name', 'Exam Management System') }}</h1>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow-1 d-flex align-items-center py-5">
            <div class="container">
                <div class="login-container p-4 p-md-5 bg-white rounded shadow">
                    <!-- Icon -->
                    <div class="text-center mb-4">
                        <span class="bg-light p-3 rounded-circle d-inline-block">
                            <i class="fas fa-graduation-cap text-primary fs-2"></i>
                        </span>
                    </div>

                    <!-- Welcome Text -->
                    <div class="text-center mb-4">
                        <h2 class="fw-bold">Bienvenue sur la plateforme</h2>
                        <p class="text-muted">Veuillez vous connecter pour accéder à votre tableau de bord</p>
                    </div>

                    <!-- Already logged in? -->
                    @auth
                        <div class="text-center mb-4">
                            <a href="{{ route('dashboard') }}" class="text-decoration-none">
                                Accéder à mon tableau de bord
                            </a>
                        </div>
                    @endauth

                    <!-- Login -->
                    <div class="d-grid gap-3 mb-4">
                        <a href="{{ route('login') }}" class="btn btn-login btn-lg">
                            <i class="fas fa-sign-in-alt me-2"></i>
                            Se connecter
                        </a>
                    </div>

                    <!-- Forgot Password -->
                    <div class="text-center">
                        @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-decoration-none small">
                            Mot de passe oublié ?
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="py-3 bg-white border-top">
            <div class="container text-center text-muted small">
                <p class="mb-1">&copy; {{ date('Y') }} {{ config('app.name', 'Exam Management System') }}. Tous droits réservés.</p>
                <div class="mt-2">
                    <a href="#" class="text-decoration-none text-muted mx-2"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-decoration-none text-muted mx-2"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="text-decoration-none text-muted mx-2"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </footer>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>