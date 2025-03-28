@extends('layouts.app')

@section('content')
<x-page-title title="Nouveau groupe" subtitle="Créer un groupe pour une filière" />

<x-alert />

<x-section>
    <form action="{{ route('groups.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="name" value="Nom du groupe" />
            <x-text-input type="text" name="name" id="name" class="w-full" required />
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="program_id" value="Filière" />
            <select name="program_id" id="program_id" class="w-full border-gray-300 rounded">
                @foreach($programs as $program)
                    <option value="{{ $program->id }}">{{ $program->name }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('program_id')" />
        </div>

        <x-primary-button>Créer</x-primary-button>
        <a href="{{ route('groups.index') }}" class="text-sm text-gray-500 underline">Retour</a>
    </form>
</x-section>
@endsection
