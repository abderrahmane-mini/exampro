@extends('layouts.app')

@section('content')
<x-page-title title="Consultation des notes" subtitle="Liste des notes enregistrées" />

<x-alert />

<x-section>
    @if($grades->count())
        <table class="w-full table-auto">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2">Étudiant</th>
                    <th class="p-2">Module</th>
                    <th class="p-2">Groupe</th>
                    <th class="p-2">Note</th>
                </tr>
            </thead>
            <tbody>
                @foreach($grades as $grade)
                <tr class="border-b">
                    <td class="p-2">{{ $grade->student->name }}</td>
                    <td class="p-2">{{ $grade->exam->module->name }}</td>
                    <td class="p-2">{{ $grade->exam->group->name }}</td>
                    <td class="p-2">{{ $grade->grade }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <x-empty-state message="Aucune note enregistrée pour le moment." />
    @endif
</x-section>
@endsection
