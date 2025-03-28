@extends('layouts.app')

@section('content')
    <x-page-title title="Moyennes" subtitle="Moyennes par module ou par étudiant" />

    <x-alert />

    <x-section>

        {{-- Moyennes par étudiant --}}
        @if(!empty($studentAverages) && count($studentAverages))
            <h2 class="text-lg font-semibold mb-2">Moyennes des étudiants</h2>
            <table class="w-full table-auto mb-8">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2">Étudiant</th>
                        <th class="p-2">Moyenne générale</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($studentAverages as $student)
                        <tr class="border-b">
                            <td class="p-2">{{ $student['student'] }}</td>
                            <td class="p-2 font-semibold">{{ number_format($student['average'], 2) }}/20</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <x-empty-state message="Aucune moyenne d'étudiant disponible." />
        @endif

        {{-- Moyennes par module --}}
        @if(!empty($moduleAverages) && count($moduleAverages))
            <h2 class="text-lg font-semibold mb-2">Moyennes par module</h2>
            <table class="w-full table-auto">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2">Module</th>
                        <th class="p-2">Moyenne</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($moduleAverages as $module => $avg)
                        <tr class="border-b">
                            <td class="p-2">{{ $module }}</td>
                            <td class="p-2 font-semibold">{{ number_format($avg, 2) }}/20</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <x-empty-state message="Aucune moyenne de module disponible." />
        @endif

    </x-section>
@endsection
