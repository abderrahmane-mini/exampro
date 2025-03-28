@extends('layouts.app')

@section('content')
<x-page-title title="Modifier le groupe" subtitle="Modifier le nom ou la filière d’un groupe" />

<x-alert />

<x-section>
    <form action="{{ route('groups.update', $group->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <x-input-label for="name" value="Nom du groupe" />
            <x-text-input type="text" name="name" id="name" class="w-full" required value="{{ $group->name }}" />
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="program_id" value="Filière" />
            <select name="program_id" id="program_id" class="w-full border-gray-300 rounded">
                @foreach($programs as $program)
                    <option value="{{ $program->id }}" {{ $group->program_id == $program->id ? 'selected' : '' }}>
                        {{ $program->name }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('program_id')" />
        </div>

        <x-primary-button>Mettre à jour</x-primary-button>
        <a href="{{ route('groups.index') }}" class="text-sm text-gray-500 underline">Annuler</a>
    </form>
</x-section>
@endsection
