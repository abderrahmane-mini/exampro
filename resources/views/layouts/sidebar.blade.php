@php
    use Illuminate\Support\Facades\Auth;
    $user = auth()->user();
    $menu = [];

    switch ($user->user_type) {
        case 'directeur_pedagogique':
            $menu = (new \App\Http\Controllers\DirecteurPedagogiqueController())->getMenu();
            break;
        case 'enseignant':
            $menu = (new \App\Http\Controllers\EnseignantController())->getMenu();
            break;
        case 'etudiant':
            $menu = (new \App\Http\Controllers\EtudiantController())->getMenu();
            break;
        case 'administrateur':
            $menu = (new \App\Http\Controllers\AdministrateurController())->getMenu();
            break;
        default:
            $menu = []; // Fallback empty menu
    }
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Enhanced Sidebar</title>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div x-data="{ open: true }" class="fixed left-0 top-0 bottom-0 bg-gradient-to-b from-gray-900 to-gray-800 text-white transition-all duration-500 ease-in-out shadow-2xl" 
         :class="open ? 'w-64' : 'w-20 overflow-hidden'">
        <!-- Logo Section -->
        <div class="flex items-center justify-between p-4 border-b border-gray-700">
            <div class="flex items-center space-x-2">
                <img src="{{ asset('images/school-logo.png') }}" alt="Logo" class="h-10 w-10 rounded-full shadow-md">
                <span x-show="open" x-transition class="text-xl font-bold text-white tracking-wider">ESRMI</span>
            </div>
            <button @click="open = !open" class="text-gray-400 hover:text-white focus:outline-none transition transform hover:rotate-90">
                <i class="fas" :class="open ? 'fa-chevron-left' : 'fa-bars'"></i>
            </button>
        </div>

        <!-- User Info -->
        <div x-show="open" x-transition class="p-4 border-b border-gray-700 flex items-center space-x-3">
            <div class="w-12 h-12 bg-gray-700 rounded-full flex items-center justify-center text-2xl text-white uppercase">
                {{ substr($user->name, 0, 1) }}
            </div>
            <div>
                <h2 class="text-md font-bold">{{ $user->name }}</h2>
                <p class="text-xs text-gray-400">{{ ucfirst($user->user_type) }}</p>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto py-4 px-2 h-[calc(100vh-250px)] overflow-y-scroll custom-scrollbar">
            @foreach($menu as $section => $items)
                @if(isset($items['route']))
                    <!-- Top-Level Clickable Links -->
                    <a href="{{ route($items['route']) }}"
                       class="flex items-center space-x-3 px-4 py-2.5 rounded-lg hover:bg-gray-700 hover:bg-opacity-50 transition-all duration-300 group {{ request()->routeIs($items['route']) ? 'bg-blue-600 bg-opacity-20 text-blue-300' : '' }}">
                        <i class="text-xl opacity-80 group-hover:opacity-100 transition-opacity duration-300 {{ $items['icon'] ?? 'fas fa-dot-circle' }}"></i>
                        <span x-show="open" x-transition>{{ $section }}</span>
                    </a>
                @else
                    <!-- Section Header -->
                    <h3 x-show="open" x-transition class="text-xs uppercase text-gray-400 px-4 mt-4 mb-2">{{ $section }}</h3>

                    @foreach($items as $label => $details)
                        @if(in_array($label, ['route', 'icon'])) @continue @endif

                        @if(isset($details['route']))
                            <a href="{{ route($details['route']) }}"
                               class="flex items-center space-x-3 px-4 py-2.5 rounded-lg hover:bg-gray-700 hover:bg-opacity-50 transition-all duration-300 group {{ request()->routeIs($details['route']) ? 'bg-blue-600 bg-opacity-20 text-blue-300' : '' }}">
                                <i class="text-xl opacity-80 group-hover:opacity-100 transition-opacity duration-300 {{ $details['icon'] ?? 'fas fa-circle' }}"></i>
                                <span x-show="open" x-transition>{{ $label }}</span>
                            </a>
                        @elseif(isset($details['submenu']))
                            <div x-data="{ openSub: false }" class="mb-2">
                                <button @click="openSub = !openSub"
                                        class="w-full flex items-center justify-between px-4 py-2.5 rounded-lg hover:bg-gray-700 hover:bg-opacity-50 transition-all duration-300 group">
                                    <div class="flex items-center space-x-3">
                                        <i class="text-xl opacity-80 group-hover:opacity-100 transition-opacity duration-300 {{ $details['icon'] ?? 'fas fa-caret-down' }}"></i>
                                        <span x-show="open" x-transition>{{ $label }}</span>
                                    </div>
                                    <i x-show="open" class="fas transition-transform" 
                                       :class="openSub ? 'fa-chevron-down' : 'fa-chevron-right'"></i>
                                </button>
                                <div x-show="openSub" x-transition.scale.origin.top class="bg-gray-800 bg-opacity-50 rounded-lg shadow-inner mt-1 space-y-1 px-6 py-2">
                                    @foreach($details['submenu'] as $subLabel => $subDetails)
                                        <a href="{{ route($subDetails['route']) }}"
                                           class="block text-sm text-gray-300 hover:text-white hover:bg-gray-700 rounded px-3 py-1.5 transition-all duration-200 {{ request()->routeIs($subDetails['route']) ? 'text-blue-400 font-medium' : '' }}">
                                            {{ $subLabel }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </nav>

        <!-- Footer -->
        <div class="sidebar-footer mt-auto border-t border-gray-700 p-4">
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="flex items-center space-x-3 px-4 py-2.5 text-red-400 hover:text-red-600 hover:bg-gray-700 rounded-lg transition-all duration-300">
                <i class="fas fa-sign-out-alt"></i>
                <span x-show="open" x-transition>{{ __('Logout') }}</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </div>

        <style>
            .custom-scrollbar::-webkit-scrollbar {
                width: 8px;
            }
            .custom-scrollbar::-webkit-scrollbar-track {
                background: rgba(255, 255, 255, 0.1);
                border-radius: 10px;
            }
            .custom-scrollbar::-webkit-scrollbar-thumb {
                background: rgba(255, 255, 255, 0.3);
                border-radius: 10px;
            }
            .custom-scrollbar::-webkit-scrollbar-thumb:hover {
                background: rgba(255, 255, 255, 0.5);
            }
        </style>
    </div>
</body>
</html>