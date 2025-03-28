@extends('layouts.app')

@section('content')
<x-page-title title="Modifier le module" subtitle="Mettre à jour le nom du module" />

<x-alert />

<x-section>
    <form action="{{ route('modules.update', $module->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <x-input-label for="name" value="Nom du module" />
            <x-text-input type="text" name="name" id="name" class="w-full" value="{{ $module->name }}" required />
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <x-primary-button>Mettre à jour</x-primary-button>
        <a href="{{ route('modules.index') }}" class="text-sm text-gray-500 underline">Annuler</a>
    </form>
</x-section>
@endsection
