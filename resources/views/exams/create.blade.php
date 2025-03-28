@extends('layouts.app')

@section('content')
<x-page-title title="Planifier un examen" subtitle="Attribuer un module, un groupe, une salle et une date" />

<x-alert />

<x-section>
    <form action="{{ route('exams.store') }}" method="POST" class="space-y-4">
        @csrf

        <!-- Module -->
        <div>
            <x-input-label for="module_id" value="Module" />
            <select name="module_id" id="module_id" class="w-full border-gray-300 rounded">
                @foreach($modules as $module)
                    <option value="{{ $module->id }}">{{ $module->name }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('module_id')" />
        </div>

        <!-- Groupe -->
        <div>
            <x-input-label for="group_id" value="Groupe" />
            <select name="group_id" id="group_id" class="w-full border-gray-300 rounded">
                @foreach($groups as $group)
                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('group_id')" />
        </div>

        <!-- Salles -->
        <div>
            <x-input-label for="room_ids" value="Salles" />
            <select name="room_ids[]" id="room_ids" class="w-full border-gray-300 rounded" multiple>
                @foreach($rooms as $room)
                    <option value="{{ $room->id }}">{{ $room->name }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('room_ids')" />
        </div>

        <!-- Date -->
        <div>
            <x-input-label for="date" value="Date" />
            <x-text-input type="date" name="date" id="date" class="w-full" required />
            <x-input-error :messages="$errors->get('date')" />
        </div>

        <!-- Heure -->
        <div>
            <x-input-label for="time" value="Heure" />
            <x-text-input type="time" name="time" id="time" class="w-full" required />
            <x-input-error :messages="$errors->get('time')" />
        </div>

        <!-- Année académique -->
        <div>
            <x-input-label for="academic_year" value="Année académique" />
            <x-text-input type="text" name="academic_year" id="academic_year" class="w-full" placeholder="2024/2025" required />
            <x-input-error :messages="$errors->get('academic_year')" />
        </div>

        <!-- Semestre -->
        <div>
            <x-input-label for="semester" value="Semestre" />
            <select name="semester" id="semester" class="w-full border-gray-300 rounded" required>
                <option value="">-- Choisir --</option>
                <option value="S1">S1</option>
                <option value="S2">S2</option>
                <option value="S3">S3</option>
                <option value="S4">S4</option>
            </select>
            <x-input-error :messages="$errors->get('semester')" />
        </div>

        <!-- teacher -->
        <div>
            <x-input-label for="teacher_ids" value="Enseignants responsables" />
            <select name="teacher_ids[]" id="teacher_ids" class="w-full border-gray-300 rounded" multiple>
                @foreach(\App\Models\User::where('user_type', 'enseignant')->get() as $teacher)
                    <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('teacher_ids')" />
        </div>
        
        <x-primary-button>Planifier</x-primary-button>
        <a href="{{ route('exams.index') }}" class="text-sm text-gray-500 underline">Annuler</a>
    </form>
</x-section>
@endsection
