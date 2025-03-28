@extends('layouts.app')

@section('content')
<x-page-title title="Sélectionner un examen" subtitle="Choisissez l’examen pour saisir les notes" />

<x-alert />

<x-section>
    @if($exams->count())
        <ul class="space-y-2">
            @foreach($exams as $exam)
                <li>
                    <a href="{{ route('grades.enter', $exam->id) }}"
                       class="block bg-white border rounded px-4 py-2 hover:bg-gray-100">
                        {{ $exam->module->name }} — {{ $exam->group->name }} | {{ $exam->date }} {{ $exam->time }}
                    </a>
                </li>
            @endforeach
        </ul>
    @else
        <x-empty-state message="Aucun examen disponible pour la saisie des notes." />
    @endif
</x-section>
@endsection
