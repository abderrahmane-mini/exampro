@extends('layouts.app')

@section('content')
<x-page-title title="PV des Notes" subtitle="Liste des PV disponibles" />

<x-alert />

<x-section>
    @if($exams->count())
        <table class="w-full table-auto">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 text-left">Module</th>
                    <th class="p-2 text-left">Groupe</th>
                    <th class="p-2 text-left">Date</th>
                    <th class="p-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($exams as $exam)
                    <tr class="border-b">
                        <td class="p-2">{{ $exam->module->name }}</td>
                        <td class="p-2">{{ $exam->group->name }}</td>
                        <td class="p-2">{{ \Carbon\Carbon::parse($exam->start_time)->format('d/m/Y H:i') }}</td>
                        <td class="p-2">
                            <a href="{{ route('documents.pv', $exam->id) }}" class="text-blue-600 hover:underline">
                                Voir PV
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <x-empty-state message="Aucun PV disponible pour le moment." />
    @endif
</x-section>
@endsection
