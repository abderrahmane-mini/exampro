@extends('layouts.app')

@section('content')
<x-page-title title="Étudiants" subtitle="Liste des étudiants inscrits par groupe" />

<x-alert />

<x-section>
    <a href="{{ route('students.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">
        + Nouvel étudiant
    </a>

    @if($students->count())
        <table class="w-full table-auto">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 text-left">Nom</th>
                    <th class="p-2 text-left">Email</th>
                    <th class="p-2 text-left">Groupe</th>
                    <th class="p-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                <tr class="border-b">
                    <td class="p-2">{{ $student->name }}</td>
                    <td class="p-2">{{ $student->email }}</td>
                    <td class="p-2">{{ $student->group->name ?? '-' }}</td>
                    <td class="p-2">
                        <a href="{{ route('students.edit', $student->id) }}" class="text-blue-600">Modifier</a> |
                        <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Supprimer cet étudiant ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500">Supprimer</button>
                        </form>
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
