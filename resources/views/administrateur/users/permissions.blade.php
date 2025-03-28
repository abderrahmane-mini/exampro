@extends('layouts.app')

@section('content')
<x-page-title title="Permissions" subtitle="Gestion des rôles et autorisations" />

<x-alert />

<x-section>
    <table class="w-full table-auto border mt-4">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2">Nom</th>
                <th class="p-2">Email</th>
                <th class="p-2">Rôle actuel</th>
                <th class="p-2">Modifier</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
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
            @endforeach
        </tbody>
    </table></x-section>
@endsection
