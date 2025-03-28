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

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="//unpkg.com/alpinejs" defer></script>

    <!-- Tailwind & App -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')

    <style>
        /* Sidebar responsiveness */
        @media (max-width: 767px) {
            .sidebar-desktop {
                display: none;
            }
        }

        @media (min-width: 768px) {
            .mobile-nav {
                display: none;
            }
        }

        .sidebar-transition {
            transition: all 0.3s ease;
        }

        .content-area {
            transition: margin-left 0.3s ease;
            width: 100%;
        }

        .main-content-container {
            margin-left: 0;
        }

        @media (min-width: 768px) {
            .main-content-container {
                margin-left: 16rem;
            }
        }

        .sidebar-desktop {
            position: fixed;
            height: 100vh;
            z-index: 10;
        }

        .navbar-offset {
            padding-top: 4rem; /* Adjust based on navbar height */
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-100">
    <!-- Mobile Navigation (Breeze) -->
    <div class="mobile-nav">
        @include('layouts.navigation')
    </div>

    <div class="min-h-screen flex">
        <!-- Sidebar (Desktop) -->
        @auth
            <div class="sidebar-desktop">
                @include('layouts.sidebar')
            </div>
        @endauth

        <!-- Main Content Area -->
        <div class="content-area main-content-container w-full">
            <!-- Top Navbar -->
            @auth
                @include('layouts.navbar')
            @endauth

            <!-- Page Heading (Optional) -->
            @if (isset($header))
                <header class="bg-white shadow mt-16">
                    <div class="max-w-full mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="p-6 mt-16">
                @hasSection('content')
                    @yield('content')
                @else
                    {{ $slot }}
                @endif
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
            }

            const mobileLinks = document.querySelectorAll('#mobile-menu a');
            mobileLinks.forEach(link => {
                link.addEventListener('click', () => {
                    if (mobileMenu) {
                        mobileMenu.classList.add('hidden');
                    }
                });
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
