@extends('layouts.app')

@section('content')
    <x-page-title title="Planning des Examens" subtitle="Liste des examens à venir" />

    <x-alert />

    <x-section>
        @if($exams->count())
            <table class="table-auto w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 text-left">Module</th>
                        <th class="p-2 text-left">Groupe</th>
                        <th class="p-2 text-left">Date & Heure</th>
                        <th class="p-2 text-left">Salles</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($exams as $exam)
                        <tr class="border-b">
                            <td class="p-2">{{ $exam->module->name ?? '-' }}</td>
                            <td class="p-2">{{ $exam->group->name ?? '-' }}</td>
                            <td class="p-2">{{ \Carbon\Carbon::parse($exam->start_time)->format('d/m/Y H:i') }}</td>
                            <td class="p-2">
                                @foreach($exam->rooms as $room)
                                    <span class="inline-block bg-blue-100 text-blue-700 px-2 py-1 rounded mr-2">
                                        {{ $room->name }}
                                    </span>
                                @endforeach
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <x-empty-state message="Aucun examen programmé." />
        @endif
    </x-section>
@endsection
