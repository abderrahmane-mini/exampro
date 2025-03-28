@php
    $user = auth()->user();
@endphp

<nav x-data="{ open: false, profileMenu: false }" class="fixed top-0 left-64 right-0 bg-white shadow-md z-40">
    <div class="flex items-center justify-between px-6 py-3">
        <!-- Left Side: Page Title or Search -->
        <div class="flex items-center space-x-4">
            <h1 class="text-xl font-semibold text-gray-800">
                {{ ucfirst(request()->segment(1)) ?? 'ExamPro' }}
            </h1>
        </div>

        <!-- Right Side -->
        <div class="flex items-center space-x-4">
            <!-- Notification Icon -->
            <div x-data="{ dropdownOpen: false }" class="relative">
                <button @click="dropdownOpen = !dropdownOpen" class="relative focus:outline-none">
                    <i class="fas fa-bell text-gray-600 text-xl"></i>
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs w-4 h-4 flex items-center justify-center rounded-full">2</span>
                </button>

                <div x-show="dropdownOpen" @click.away="dropdownOpen = false"
                     class="absolute right-0 mt-2 w-72 bg-white border border-gray-200 shadow-lg rounded-lg overflow-hidden z-50"
                     x-transition>
                    <div class="p-4 border-b font-semibold">Notifications</div>
                    <ul class="max-h-60 overflow-y-auto text-sm text-gray-700 divide-y">
                        <li class="px-4 py-2">Nouvel examen planifié</li>
                        <li class="px-4 py-2">Date limite de saisie des notes</li>
                    </ul>
                </div>
            </div>

            <!-- Profile Dropdown -->
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="flex items-center space-x-2 bg-gray-100 hover:bg-gray-200 px-3 py-2 rounded-full">
                    <div class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center uppercase">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <span class="hidden md:inline text-sm font-medium text-gray-700">{{ $user->name }}</span>
                    <i class="fas fa-chevron-down text-xs text-gray-600"></i>
                </button>

                <div x-show="open" @click.away="open = false"
                     class="absolute right-0 mt-2 w-56 bg-white border border-gray-200 rounded-lg shadow-lg z-50"
                     x-transition>
                    <div class="px-4 py-3 border-b">
                        <p class="font-semibold">{{ $user->name }}</p>
                        <p class="text-xs text-gray-500">{{ $user->email }}</p>
                    </div>
                    <div class="py-2 text-sm text-gray-700">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 hover:bg-gray-100">
                            <i class="fas fa-user mr-2"></i> Profil
                        </a>
                        <a href="{{ route('logout') }}" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                           class="block px-4 py-2 hover:bg-red-50 text-red-600">
                            <i class="fas fa-sign-out-alt mr-2"></i> Déconnexion
                        </a>
                        <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
