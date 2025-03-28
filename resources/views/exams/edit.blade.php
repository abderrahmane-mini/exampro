@extends('layouts.app')

@section('content')
<x-page-title title="Modifier l'examen" subtitle="Mettre à jour les informations de l'examen planifié" />

<x-alert />

<x-section>
    <form action="{{ route('exams.update', $exam->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <x-input-label for="module_id" value="Module" />
            <select name="module_id" id="module_id" class="w-full border-gray-300 rounded">
                @foreach($modules as $module)
                    <option value="{{ $module->id }}" {{ $exam->module_id == $module->id ? 'selected' : '' }}>
                        {{ $module->name }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('module_id')" />
        </div>

        <div>
            <x-input-label for="group_id" value="Groupe" />
            <select name="group_id" id="group_id" class="w-full border-gray-300 rounded">
                @foreach($groups as $group)
                    <option value="{{ $group->id }}" {{ $exam->group_id == $group->id ? 'selected' : '' }}>
                        {{ $group->name }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('group_id')" />
        </div>

        <div>
            <x-input-label for="room_ids" value="Salle(s)" />
            <select name="room_ids[]" id="room_ids" class="w-full border-gray-300 rounded" multiple>
                @foreach($rooms as $room)
                    <option value="{{ $room->id }}" {{ in_array($room->id, $exam->rooms->pluck('id')->toArray()) ? 'selected' : '' }}>
                        {{ $room->name }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('room_ids')" />
        </div>

        <div>
            <x-input-label for="teacher_ids" value="Enseignant(s)" />
            <select name="teacher_ids[]" id="teacher_ids" class="w-full border-gray-300 rounded" multiple>
                @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}" {{ in_array($teacher->id, $exam->teachers->pluck('id')->toArray()) ? 'selected' : '' }}>
                        {{ $teacher->name }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('teacher_ids')" />
        </div>

        <div>
            <x-input-label for="academic_year" value="Année académique" />
            <x-text-input type="text" name="academic_year" id="academic_year" class="w-full"
                          value="{{ old('academic_year', $exam->academic_year) }}" required />
            <x-input-error :messages="$errors->get('academic_year')" />
        </div>

        <div>
            <x-input-label for="semester" value="Semestre" />
            <select name="semester" id="semester" class="w-full border-gray-300 rounded" required>
                @foreach(['S1', 'S2', 'S3', 'S4'] as $sem)
                    <option value="{{ $sem }}" {{ $exam->semester == $sem ? 'selected' : '' }}>{{ $sem }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('semester')" />
        </div>

        <div>
            <x-input-label for="date" value="Date" />
            <x-text-input type="date" name="date" id="date" class="w-full"
                value="{{ \Carbon\Carbon::parse($exam->start_time)->format('Y-m-d') }}" required />
            <x-input-error :messages="$errors->get('date')" />
        </div>

        <div>
            <x-input-label for="time" value="Heure" />
            <x-text-input type="time" name="time" id="time" class="w-full"
                value="{{ \Carbon\Carbon::parse($exam->start_time)->format('H:i') }}" required />
            <x-input-error :messages="$errors->get('time')" />
        </div>

        <x-primary-button>Mettre à jour</x-primary-button>
        <a href="{{ route('exams.index') }}" class="text-sm text-gray-500 underline ml-4">Annuler</a>
    </form>
</x-section>
@endsection
