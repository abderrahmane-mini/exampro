@extends('layouts.app')

@section('content')
<x-page-title title="Ajouter un module" subtitle="Créer un nouveau module d’enseignement" />

<x-alert />

<x-section>
    <form action="{{ route('modules.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="name" value="Nom du module" />
            <x-text-input type="text" name="name" id="name" class="w-full" required />
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="code" value="Code du module" />
            <x-text-input type="text" name="code" id="code" class="w-full" required />
            <x-input-error :messages="$errors->get('code')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>Créer</x-primary-button>
            <a href="{{ route('modules.index') }}" class="text-sm text-gray-500 underline">Retour</a>
        </div>
    </form>
</x-section>
@endsection
