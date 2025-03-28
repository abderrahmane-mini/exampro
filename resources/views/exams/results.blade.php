@extends('layouts.app')

@section('content')
    <x-page-title title="Résultats des Examens" subtitle="Liste des notes par module et groupe" />

    <x-alert />

    <x-section>
        @if($exams->count())
            @foreach($exams as $exam)
                <div class="mb-8 border rounded-lg p-4 shadow bg-white">
                    <h3 class="text-xl font-semibold mb-2">
                        {{ $exam->module->name }} — {{ $exam->group->name }}
                    </h3>

                    @if($exam->results->count())
                        <table class="w-full table-auto">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="p-2 text-left">Étudiant</th>
                                    <th class="p-2 text-left">Note</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($exam->results as $result)
                                    <tr class="border-b">
                                        <td class="p-2">{{ $result->student->name }}</td>
                                        <td class="p-2">{{ $result->grade }}/20</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-gray-500 italic">Aucune note enregistrée pour cet examen.</p>
                    @endif
                </div>
            @endforeach
        @else
            <x-empty-state message="Aucun examen avec des résultats disponibles." />
        @endif
    </x-section>
@endsection
