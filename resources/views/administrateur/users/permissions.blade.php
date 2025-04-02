@extends('layouts.app')

@section('content')
<x-page-title title="Permissions" subtitle="Gestion des rôles et autorisations" />

<x-alert />

<x-section>
    <!-- 🔍 Filter and Sort Form -->
    <form method="GET" action="{{ route('users.permissions') }}" class="flex flex-wrap items-center gap-4 mb-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Recherche par nom ou email"
               class="border px-3 py-2 rounded text-sm w-64" />

        <select name="role" class="border rounded px-3 py-2 text-sm">
            <option value="">Tous les rôles</option>
            @foreach(['administrateur', 'directeur_pedagogique', 'enseignant', 'etudiant'] as $role)
                <option value="{{ $role }}" {{ request('role') === $role ? 'selected' : '' }}>
                    {{ ucfirst(str_replace('_', ' ', $role)) }}
                </option>
            @endforeach
        </select>

        <select name="per_page" class="border rounded px-3 py-2 text-sm">
            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 par page</option>
            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 par page</option>
            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 par page</option>
            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 par page</option>
        </select>

        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded text-sm">
            Filtrer
        </button>
    </form>

    <!-- 📋 Table -->
    <table class="w-full table-auto border mt-4">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2 text-left">
                    <a href="{{ route('users.permissions', ['sort' => 'name', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'] + request()->except(['sort', 'direction', 'page'])) }}">
                        Nom
                        @if(request('sort') === 'name')
                            <i class="fas fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                        @endif
                    </a>
                </th>
                <th class="p-2 text-left">
                    <a href="{{ route('users.permissions', ['sort' => 'email', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'] + request()->except(['sort', 'direction', 'page'])) }}">
                        Email
                        @if(request('sort') === 'email')
                            <i class="fas fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                        @endif
                    </a>
                </th>
                <th class="p-2 text-left">Rôle actuel</th>
                <th class="p-2 text-left">Modifier</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr class="border-b">
                    <td class="p-2">{{ $user->name }}</td>
                    <td class="p-2">{{ $user->email }}</td>
                    <td class="p-2 capitalize">{{ str_replace('_', ' ', $user->user_type) }}</td>
                    <td class="p-2">
                        <form action="{{ route('users.permissions.update', $user->id) }}" method="POST" class="flex items-center space-x-2">
                            @csrf
                            @method('PATCH')
                            <select name="user_type" class="border rounded px-2 py-1 text-sm">
                                @foreach(['administrateur', 'directeur_pedagogique', 'enseignant', 'etudiant'] as $role)
                                    <option value="{{ $role }}" {{ $user->user_type === $role ? 'selected' : '' }}>
                                        {{ ucfirst(str_replace('_', ' ', $role)) }}
                                    </option>
                                @endforeach
                            </select>
                            <x-primary-button class="text-sm">Valider</x-primary-button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center py-4 text-gray-500">Aucun utilisateur trouvé.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Enhanced Pagination -->
    <div class="mt-6 flex items-center justify-between">
        <div class="text-sm text-gray-600">
            Affichage de {{ $users->firstItem() ?? 0 }} à {{ $users->lastItem() ?? 0 }} sur {{ $users->total() }} utilisateurs
        </div>

        
        
        <div class="pagination-links">
            {{ $users->appends(request()->except('page'))->links() }}
        </div>
    </div>
</x-section>
@endsection