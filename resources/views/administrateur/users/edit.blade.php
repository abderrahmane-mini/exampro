@extends('layouts.app')

@section('content')
<x-page-title title="Modifier l'utilisateur" subtitle="Mettez à jour les informations du compte" />

<x-alert />

<x-section>
    <form action="{{ route('users.update', $user->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PATCH')

        {{-- Nom --}}
        <div>
            <x-input-label for="name" value="Nom" />
            <x-text-input id="name" name="name" type="text" class="w-full mt-1" required value="{{ old('name', $user->name) }}" />
            <x-input-error :messages="$errors->get('name')" class="mt-1" />
        </div>

        {{-- Email --}}
        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" name="email" type="email" class="w-full mt-1" required value="{{ old('email', $user->email) }}" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        {{-- Rôle --}}
        <div>
            <x-input-label for="user_type" value="Rôle" />
            <select id="user_type" name="user_type" class="w-full border-gray-300 mt-1 rounded shadow-sm">
                @foreach(['administrateur', 'directeur_pedagogique', 'enseignant', 'etudiant'] as $role)
                    <option value="{{ $role }}" {{ old('user_type', $user->user_type) === $role ? 'selected' : '' }}>
                        {{ ucfirst(str_replace('_', ' ', $role)) }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('user_type')" class="mt-1" />
        </div>

        <div class="pt-4">
            <x-primary-button>Mettre à jour</x-primary-button>
        </div>
    </form>
</x-section>
@endsection
