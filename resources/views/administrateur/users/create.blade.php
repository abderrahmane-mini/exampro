@extends('layouts.app')

@section('content')
<x-page-title title="Créer un utilisateur" subtitle="Ajoutez un nouveau compte utilisateur" />

<x-alert />

<x-section>
    <form action="{{ route('users.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="name" value="Nom" />
            <x-text-input id="name" name="name" type="text" required class="w-full" />
        </div>

        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" name="email" type="email" required class="w-full" />
        </div>

        <div>
            <x-input-label for="password" value="Mot de passe" />
            <x-text-input id="password" name="password" type="password" required class="w-full" />
        </div>

        <div>
            <x-input-label for="user_type" value="Rôle" />
            <select id="user_type" name="user_type" class="w-full border-gray-300 rounded">
                <option value="administrateur">Administrateur</option>
                <option value="directeur_pedagogique">Directeur Pédagogique</option>
                <option value="enseignant">Enseignant</option>
                <option value="etudiant">Étudiant</option>
            </select>
        </div>

        <x-primary-button>Créer</x-primary-button>
    </form>
</x-section>
@endsection
