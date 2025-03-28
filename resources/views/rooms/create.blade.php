@extends('layouts.app')

@section('content')
<x-page-title title="Ajouter une salle" subtitle="Créer une nouvelle salle d'examen" />

<x-alert />

<x-section>
    <form action="{{ route('rooms.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="name" value="Nom de la salle" />
            <x-text-input id="name" name="name" type="text" required class="w-full" />
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="capacity" value="Capacité" />
            <x-text-input id="capacity" name="capacity" type="number" min="1" required class="w-full" />
            <x-input-error :messages="$errors->get('capacity')" />
        </div>

        <x-primary-button>Créer</x-primary-button>
        <a href="{{ route('rooms.index') }}" class="text-sm text-gray-500 underline">Retour</a>
    </form>
</x-section>
@endsection
