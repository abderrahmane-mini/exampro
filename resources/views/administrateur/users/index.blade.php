@extends('layouts.app')

@section('content')
<x-page-title title="Gestion des utilisateurs" subtitle="Liste des comptes créés" />

<x-alert />

<x-section>
    <a href="{{ route('users.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">Créer un nouvel utilisateur</a>

    @if($users->count())
        <table class="w-full table-auto">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="p-2">Nom</th>
                    <th class="p-2">Email</th>
                    <th class="p-2">Rôle</th>
                    <th class="p-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr class="border-b">
                    <td class="p-2">{{ $user->name }}</td>
                    <td class="p-2">{{ $user->email }}</td>
                    <td class="p-2 capitalize">{{ $user->user_type }}</td>
                    <td class="p-2">
                        <a href="{{ route('users.edit', $user->id) }}" class="text-blue-500 hover:underline">Modifier</a>
                        <a href="#" class="text-red-500">Supprimer</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <x-empty-state message="Aucun utilisateur trouvé." />
    @endif
</x-section>
@endsection
