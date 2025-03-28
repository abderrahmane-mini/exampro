@extends('layouts.app')

@section('content')
<x-page-title title="Ajouter un enseignant" subtitle="Créer un nouveau compte enseignant et lui assigner des modules" />

<x-alert />

<x-section>
    <form action="{{ route('teachers.store') }}" method="POST" class="space-y-4">
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
            <x-input-label for="modules" value="Modules assignés" />
            <select name="modules[]" id="modules" multiple class="w-full border-gray-300 rounded">
                @foreach($modules as $module)
                    <option value="{{ $module->id }}">{{ $module->name }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('modules')" />
        </div>

        <x-primary-button>Créer</x-primary-button>
        <a href="{{ route('teachers.index') }}" class="text-sm text-gray-500 underline">Retour</a>
    </form>
</x-section>
@endsection
