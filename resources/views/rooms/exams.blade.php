@extends('layouts.app')

@section('content')
<x-page-title title="Examens programmés" subtitle="Examens planifiés dans la salle {{ $room->name }}" />

<x-alert />

<x-section>
    @if($exams->count())
        <table class="w-full table-auto">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2">Module</th>
                    <th class="p-2">Groupe</th>
                    <th class="p-2">Date</th>
                    <th class="p-2">Heure</th>
                </tr>
            </thead>
            <tbody>
                @foreach($exams as $exam)
                <tr class="border-b">
                    <td class="p-2">{{ $exam->module->name }}</td>
                    <td class="p-2">{{ $exam->group->name }}</td>
                    <td class="p-2">{{ $exam->date }}</td>
                    <td class="p-2">{{ $exam->time }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <x-empty-state message="Aucun examen planifié dans cette salle." />
    @endif
</x-section>
@endsection
