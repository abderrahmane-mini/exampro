@extends('layouts.app')

@section('content')
<x-page-title title="Examens" subtitle="Liste des examens planifiés" />

<x-alert />

<x-section>
    <a href="{{ route('exams.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">
        + Planifier un examen
    </a>

    @if($exams->count())
        <table class="w-full table-auto">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2">Module</th>
                    <th class="p-2">Groupe</th>
                    <th class="p-2">Salle(s)</th>
                    <th class="p-2">Date</th>
                    <th class="p-2">Heure</th>
                </tr>
            </thead>
            <tbody>
                @foreach($exams as $exam)
                <tr class="border-b">
                    <td class="p-2">{{ $exam->module->name }}</td>
                    <td class="p-2">{{ $exam->group->name }}</td>
                    <td class="p-2">
                        @foreach($exam->rooms as $room)
                            <span class="inline-block bg-gray-200 text-sm px-2 py-1 rounded mr-1">{{ $room->name }}</span>
                        @endforeach
                    </td>
                    <td class="p-2">{{ \Carbon\Carbon::parse($exam->start_time)->format('d/m/Y') }}</td>
                    <td class="p-2">{{ \Carbon\Carbon::parse($exam->start_time)->format('H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <x-empty-state message="Aucun examen planifié pour le moment." />
    @endif
</x-section>
@endsection
