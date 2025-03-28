@extends('layouts.app')

@section('content')
<x-page-title title="Nouvelle filière" subtitle="Créer une nouvelle filière d'étude" />

<x-alert />

<x-section>
    <form action="{{ route('programs.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="name" value="Nom de la filière" />
            <x-text-input type="text" name="name" id="name" class="w-full" required />
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <x-primary-button>Enregistrer</x-primary-button>
        <a href="{{ route('programs.index') }}" class="text-sm text-gray-500 underline">Retour</a>
    </form>
</x-section>
@endsection
