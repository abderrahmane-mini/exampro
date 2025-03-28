@extends('layouts.app')

@section('content')
<x-page-title title="Planifier un examen" subtitle="Attribuer un module, un groupe, une salle et une date" />

<x-alert />

<x-section>
    <form action="{{ route('exams.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="module_id" value="Module" />
            <select name="module_id" id="module_id" class="w-full border-gray-300 rounded">
                @foreach($modules as $module)
                    <option value="{{ $module->id }}">{{ $module->name }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('module_id')" />
        </div>

        <div>
            <x-input-label for="group_id" value="Groupe" />
            <select name="group_id" id="group_id" class="w-full border-gray-300 rounded">
                @foreach($groups as $group)
                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('group_id')" />
        </div>

        <div>
            <x-input-label for="room_ids" value="Salles" />
            <select name="room_ids[]" id="room_ids" class="w-full border-gray-300 rounded" multiple>
                @foreach($rooms as $room)
                    <option value="{{ $room->id }}">{{ $room->name }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('room_ids')" />
        </div>

        <div>
            <x-input-label for="date" value="Date" />
            <x-text-input type="date" name="date" id="date" class="w-full" required />
            <x-input-error :messages="$errors->get('date')" />
        </div>

        <div>
            <x-input-label for="time" value="Heure" />
            <x-text-input type="time" name="time" id="time" class="w-full" required />
            <x-input-error :messages="$errors->get('time')" />
        </div>

        <x-primary-button>Planifier</x-primary-button>
        <a href="{{ route('exams.index') }}" class="text-sm text-gray-500 underline">Annuler</a>
    </form>
</x-section>
@endsection
