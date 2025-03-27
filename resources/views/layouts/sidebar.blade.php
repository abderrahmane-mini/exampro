@php
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
    }
@endphp

<div class="sidebar bg-gray-800 text-white w-64 min-h-screen p-4">
    <div class="user-info mb-6 border-b pb-4">
        <h2 class="text-xl font-bold">{{ Auth::user()->name }}</h2>
        <p class="text-sm text-gray-400">{{ __(ucfirst(Auth::user()->user_type)) }}</p>
    </div>

    @foreach($menu as $section => $items)
        <div class="sidebar-section mb-4">
            @if(isset($items['route']))
                <a href="{{ route($items['route']) }}" 
                   class="text-xs uppercase text-gray-500 mb-2 hover:text-gray-300 block">
                    {{ $section }}
                </a>
            @else
                <h3 class="text-xs uppercase text-gray-500 mb-2">{{ $section }}</h3>
            @endif
            
            @foreach($items as $label => $details)
                @if($label === 'route' || $label === 'icon') @continue @endif
                
                @if(isset($details['route']))
                    <a href="{{ route($details['route']) }}" 
                       class="block py-2 px-3 hover:bg-gray-700 rounded transition {{ request()->routeIs($details['route']) ? 'bg-gray-700' : '' }}">
                        <i class="mr-2 {{ $details['icon'] ?? 'fa-solid fa-circle' }}"></i>
                        {{ $label }}
                    </a>
                @elseif(isset($details['submenu']))
                    <div x-data="{ open: false }" class="mb-2">
                        <button @click="open = !open" class="w-full text-left py-2 px-3 hover:bg-gray-700 rounded flex justify-between items-center">
                            <span>
                                @if(isset($details['icon']))
                                    <i class="mr-2 {{ $details['icon'] }}"></i>
                                @endif
                                {{ $label }}
                            </span>
                            <i x-show="!open" class="fas fa-chevron-right"></i>
                            <i x-show="open" class="fas fa-chevron-down"></i>
                        </button>
                        <div x-show="open" class="pl-4 mt-2">
                            @foreach($details['submenu'] as $subLabel => $subDetails)
                                <a href="{{ route($subDetails['route']) }}" 
                                   class="block py-1 hover:text-gray-300 {{ request()->routeIs($subDetails['route']) ? 'text-blue-400' : '' }}">
                                    {{ $subLabel }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @endforeach

    <div class="sidebar-footer mt-auto border-t pt-4">
        <a href="{{ route('logout') }}" 
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
           class="block py-2 px-3 hover:bg-red-700 rounded">
            <i class="fas fa-sign-out-alt mr-2"></i>
            {{ __('Logout') }}
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>
    </div>
</div>