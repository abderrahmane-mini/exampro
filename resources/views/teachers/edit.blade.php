@extends('layouts.app')

@section('content')
<x-page-title title="Modifier l’enseignant" subtitle="Mettre à jour les informations et les modules assignés" />

<x-alert />

<x-section>
    <form action="{{ route('teachers.update', $teacher->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <x-input-label for="name" value="Nom" />
            <x-text-input id="name" name="name" type="text" required class="w-full" value="{{ $teacher->name }}" />
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" name="email" type="email" required class="w-full" value="{{ $teacher->email }}" />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div>
            <x-input-label for="modules" value="Modules assignés" />
            <select name="modules[]" id="modules" multiple class="w-full border-gray-300 rounded">
                @foreach($modules as $module)
                    <option value="{{ $module->id }}" {{ in_array($module->id, $teacher->modules->pluck('id')->toArray()) ? 'selected' : '' }}>
                        {{ $module->name }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('modules')" />
        </div>

        <x-primary-button>Mettre à jour</x-primary-button>
        <a href="{{ route('teachers.index') }}" class="text-sm text-gray-500 underline">Annuler</a>
    </form>
</x-section>
@endsection
