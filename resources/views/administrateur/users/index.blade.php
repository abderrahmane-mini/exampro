@extends('layouts.app')

@section('content')
<x-page-title title="Gestion des utilisateurs" subtitle="Liste des comptes créés" />

<x-alert />

<x-section>
    <!-- 🔍 Role Filter -->
    <form method="GET" action="{{ route('users.manage') }}" class="mb-4 flex items-center space-x-4">
        <div>
            <label for="role" class="mr-2 font-medium text-gray-700">Filtrer par rôle :</label>
            <select name="role" id="role" onchange="this.form.submit()" class="border px-3 py-1 rounded shadow-sm text-sm">
                <option value="">Tous</option>
                <option value="administrateur" {{ request('role') == 'administrateur' ? 'selected' : '' }}>Administrateur</option>
                <option value="directeur_pedagogique" {{ request('role') == 'directeur_pedagogique' ? 'selected' : '' }}>Directeur Pédagogique</option>
                <option value="enseignant" {{ request('role') == 'enseignant' ? 'selected' : '' }}>Enseignant</option>
                <option value="etudiant" {{ request('role') == 'etudiant' ? 'selected' : '' }}>Étudiant</option>
            </select>
        </div>
        <a href="{{ route('users.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
            + Créer un utilisateur
        </a>
    </form>

    <!-- 📋 User Table -->
    @if($users->count())
        <div class="overflow-x-auto">
            <table class="w-full table-auto border border-gray-200">
                <thead class="bg-gray-100 text-left">
                    <tr>
                        <th class="p-2">Nom</th>
                        <th class="p-2">Email</th>
                        <th class="p-2">Rôle</th>
                        <th class="p-2 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-2">{{ $user->name }}</td>
                        <td class="p-2">{{ $user->email }}</td>
                        <td class="p-2 capitalize">{{ str_replace('_', ' ', $user->user_type) }}</td>
                        <td class="p-2 text-center space-x-2">
                            <a href="{{ route('users.show', $user->id) }}" class="text-gray-600 hover:underline">Voir</a>
                            <a href="{{ route('users.edit', $user->id) }}" class="text-blue-500 hover:underline">Modifier</a>
                            <form action="{{ route('users.delete', $user->id) }}" method="POST" class="inline-block"
                                  onsubmit="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- 🔄 Pagination -->
        <div class="mt-6">
            {{ $users->links() }}
        </div>


        
    @else
        <x-empty-state message="Aucun utilisateur trouvé." />
    @endif
</x-section>
@endsection
