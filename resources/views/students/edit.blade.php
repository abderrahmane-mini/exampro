@extends('layouts.app')

@section('content')
<x-page-title title="Modifier l'étudiant" subtitle="Mettre à jour les informations de l’étudiant" />

<x-alert />

<x-section>
    <form action="{{ route('students.update', $student->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <x-input-label for="name" value="Nom" />
            <x-text-input id="name" name="name" type="text" required class="w-full" value="{{ $student->name }}" />
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" name="email" type="email" required class="w-full" value="{{ $student->email }}" />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div>
            <x-input-label for="group_id" value="Groupe" />
            <select name="group_id" id="group_id" class="w-full border-gray-300 rounded">
                @foreach($groups as $group)
                    <option value="{{ $group->id }}" {{ $student->group_id == $group->id ? 'selected' : '' }}>
                        {{ $group->name }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('group_id')" />
        </div>

        <x-primary-button>Mettre à jour</x-primary-button>
        <a href="{{ route('students.index') }}" class="text-sm text-gray-500 underline">Annuler</a>
    </form>
</x-section>
@endsection
