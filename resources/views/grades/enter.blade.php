@extends('layouts.app')

@section('content')
<x-page-title title="Saisie des notes" subtitle="Examen : {{ $exam->module->name }} - Groupe : {{ $exam->group->name }}" />

<x-alert />

<x-section>
    <form action="{{ route('grades.store', $exam->id) }}" method="POST">
        @csrf

        <table class="w-full table-auto">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 text-left">Étudiant</th>
                    <th class="p-2 text-left">Note (/20)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($exam->group->students as $student)
                <tr class="border-b">
                    <td class="p-2">{{ $student->name }}</td>
                    <td class="p-2">
                        <input type="number" step="0.1" min="0" max="20"
                               name="grades[{{ $student->id }}]"
                               class="w-24 border rounded"
                               value="{{ optional($student->examResults->where('exam_id', $exam->id)->first())->grade }}">
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-6">
            <x-primary-button>Enregistrer les notes</x-primary-button>
        </div>
    </form>
</x-section>
@endsection
