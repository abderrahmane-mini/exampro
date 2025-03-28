@extends('layouts.app')

@section('content')
<x-page-title title="Ajouter un étudiant" subtitle="Créer un nouveau compte étudiant" />

<x-alert />

<x-section>
    <form action="{{ route('students.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="name" value="Nom" />
            <x-text-input id="name" name="name" type="text" required class="w-full" />
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" name="email" type="email" required class="w-full" />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div>
            <x-input-label for="password" value="Mot de passe" />
            <x-text-input id="password" name="password" type="password" required class="w-full" />
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <div>
            <x-input-label for="group_id" value="Groupe" />
            <select name="group_id" id="group_id" class="w-full border-gray-300 rounded">
                @foreach($groups as $group)
                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('group_id')" />
        </div>

        <x-primary-button>Créer</x-primary-button>
        <a href="{{ route('students.index') }}" class="text-sm text-gray-500 underline">Retour</a>
    </form>
</x-section>
@endsection
