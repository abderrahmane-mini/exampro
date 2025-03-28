@extends('layouts.app')

@section('content')
<x-page-title title="Assigner des étudiants" subtitle="Ajouter ou retirer des étudiants du groupe {{ $group->name }}" />

<x-alert />

<x-section>
    <form action="{{ route('groups.assign.update', $group->id) }}" method="POST">
        @csrf

        <table class="w-full table-auto">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2">Étudiant</th>
                    <th class="p-2 text-center">Assigné</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                <tr class="border-b">
                    <td class="p-2">{{ $student->name }}</td>
                    <td class="p-2 text-center">
                        <input type="checkbox" name="students[]" value="{{ $student->id }}"
                            {{ in_array($student->id, $assignedStudentIds) ? 'checked' : '' }}>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-6">
            <x-primary-button>Mettre à jour les affectations</x-primary-button>
            <a href="{{ route('groups.index') }}" class="text-sm text-gray-500 underline ml-4">Retour</a>
        </div>
    </form>
</x-section>
@endsection
