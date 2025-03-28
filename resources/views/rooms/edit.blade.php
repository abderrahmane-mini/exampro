@extends('layouts.app')

@section('content')
<x-page-title title="Modifier la salle" subtitle="Mettre à jour les détails de la salle" />

<x-alert />

<x-section>
    <form action="{{ route('rooms.update', $room->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <x-input-label for="name" value="Nom de la salle" />
            <x-text-input id="name" name="name" type="text" class="w-full" value="{{ $room->name }}" required />
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="capacity" value="Capacité" />
            <x-text-input id="capacity" name="capacity" type="number" class="w-full" value="{{ $room->capacity }}" required />
            <x-input-error :messages="$errors->get('capacity')" />
        </div>

        <x-primary-button>Mettre à jour</x-primary-button>
        <a href="{{ route('rooms.index') }}" class="text-sm text-gray-500 underline">Annuler</a>
    </form>
</x-section>
@endsection
