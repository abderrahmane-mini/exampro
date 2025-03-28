@extends('layouts.app')

@section('content')
<x-page-title title="Créer un utilisateur" subtitle="Ajoutez un nouveau compte utilisateur" />

<x-alert />

<x-section>
    <form action="{{ route('users.store') }}" method="POST" class="space-y-6">
        @csrf

        {{-- Nom --}}
        <div>
            <x-input-label for="name" value="Nom" />
            <x-text-input id="name" name="name" type="text" class="w-full mt-1" required autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-1" />
        </div>

        {{-- Email --}}
        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" name="email" type="email" class="w-full mt-1" required />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        {{-- Mot de passe --}}
        <div>
            <x-input-label for="password" value="Mot de passe" />
            <x-text-input id="password" name="password" type="password" class="w-full mt-1" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        {{-- Confirmation mot de passe --}}
        <div>
            <x-input-label for="password_confirmation" value="Confirmer le mot de passe" />
            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="w-full mt-1" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        {{-- Rôle --}}
        <div>
            <x-input-label for="user_type" value="Rôle" />
            <select id="user_type" name="user_type" class="w-full border-gray-300 mt-1 rounded shadow-sm focus:ring focus:ring-blue-200">
                <option value="administrateur">Administrateur</option>
                <option value="directeur_pedagogique">Directeur Pédagogique</option>
                <option value="enseignant">Enseignant</option>
                <option value="etudiant">Étudiant</option>
            </select>
            <x-input-error :messages="$errors->get('user_type')" class="mt-1" />
        </div>

        <div class="pt-4">
            <x-primary-button>Créer l'utilisateur</x-primary-button>
        </div>
    </form>
</x-section>
@endsection
