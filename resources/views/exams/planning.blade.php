@extends('layouts.app')

@section('content')
<x-page-title title="Planning des examens" subtitle="Consultez vos examens programmés" />

<x-alert />

<x-section>
    @if($exams->count())
        <table class="w-full table-auto">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2">Module</th>
                    <th class="p-2">Date</th>
                    <th class="p-2">Heure</th>
                    <th class="p-2">Salle(s)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($exams as $exam)
                <tr class="border-b">
                    <td class="p-2">{{ $exam->module->name }}</td>
                    <td class="p-2">{{ $exam->date }}</td>
                    <td class="p-2">{{ $exam->time }}</td>
                    <td class="p-2">
                        @foreach($exam->rooms as $room)
                            <span class="inline-block bg-gray-200 text-sm px-2 py-1 rounded mr-1">{{ $room->name }}</span>
                        @endforeach
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <x-empty-state message="Aucun examen prévu." />
    @endif
</x-section>
@endsection
