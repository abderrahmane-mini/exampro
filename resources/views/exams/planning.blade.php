@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold mb-4">Planning des Examens</h1>

        @if($exams->count())
            <table class="w-full table-auto">
                <thead>
                    <tr>
                        <th class="px-4 py-2">Module</th>
                        <th class="px-4 py-2">Groupe</th>
                        <th class="px-4 py-2">Date</th>
                        <th class="px-4 py-2">Heure</th>
                        <th class="px-4 py-2">Salle</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($exams as $exam)
                        <tr>
                            <td class="px-4 py-2">{{ $exam->module->name }}</td>
                            <td class="px-4 py-2">{{ $exam->group->name }}</td>
                            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($exam->start_time)->format('d M Y') }}</td>
                            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($exam->start_time)->format('H:i') }}</td>
                            <td class="px-4 py-2">
                                @foreach($exam->rooms as $room)
                                    <span class="badge bg-blue-200">{{ $room->name }}</span>
                                @endforeach
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Aucun examen à venir.</p>
        @endif
    </div>
@endsection
