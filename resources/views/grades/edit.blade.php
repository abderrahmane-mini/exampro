@extends('layouts.app')

@section('content')
<x-page-title title="Modifier la note" subtitle="Modifier la note d’un étudiant pour un examen" />

<x-alert />

<x-section>
    <form action="{{ route('enseignant.grades.update', ['exam' => $grade->exam_id, 'student' => $grade->student_id]) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <p><strong>Étudiant :</strong> {{ $grade->student->name }}</p>
            <p><strong>Module :</strong> {{ $grade->exam->module->name }}</p>
        </div>

        <div>
            <x-input-label for="grade" value="Note (/20)" />
            <x-text-input id="grade" name="grade" type="number" step="0.01" min="0" max="20" class="w-full" value="{{ $grade->grade }}" required />
            <x-input-error :messages="$errors->get('grade')" />
        </div>

        <x-primary-button>Mettre à jour</x-primary-button>
        <a href="{{ route('enseignant.grades.view') }}" class="text-sm text-gray-500 underline ml-4">Annuler</a>
    </form>
</x-section>
@endsection
