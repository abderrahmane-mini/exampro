@extends('layouts.app')

@section('content')
    <x-page-title title="Attestations" subtitle="Générer une attestation de réussite" />
    <x-alert />

    <x-section>
        @if($students->count())
            <table class="w-full table-auto">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 text-left">Nom</th>
                        <th class="p-2 text-left">Groupe</th>
                        <th class="p-2 text-left">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                        <tr class="border-b">
                            <td class="p-2">{{ $student->name }}</td>
                            <td class="p-2">{{ $student->group->name ?? '-' }}</td>
                            <td class="p-2 space-x-4">
                                <a href="{{ route('documents.attestation.view', $student->id) }}" class="text-blue-500 hover:underline">
                                    Voir l’attestation
                                </a>
                                <a href="{{ route('documents.attestation.download', $student->id) }}" class="text-green-600 hover:underline">
                                    Télécharger PDF
                                </a>
                            </td>
                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <x-empty-state message="Aucun étudiant trouvé." />
        @endif
    </x-section>
@endsection
