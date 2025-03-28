@extends('layouts.app')

@section('content')
<x-page-title title="Modifier la filière" subtitle="Mettre à jour le nom de la filière" />

<x-alert />

<x-section>
    <form action="{{ route('programs.update', $program->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <x-input-label for="name" value="Nom de la filière" />
            <x-text-input type="text" name="name" id="name" class="w-full" required value="{{ $program->name }}" />
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <x-primary-button>Mettre à jour</x-primary-button>
        <a href="{{ route('programs.index') }}" class="text-sm text-gray-500 underline">Annuler</a>
    </form>
</x-section>
@endsection
