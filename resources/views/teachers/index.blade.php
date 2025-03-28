@extends('layouts.app')

@section('content')
<x-page-title title="Enseignants" subtitle="Liste des enseignants et leurs modules" />

<x-alert />

<x-section>
    <a href="{{ route('teachers.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">
        + Nouvel enseignant
    </a>

    @if($teachers->count())
        <table class="w-full table-auto">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 text-left">Nom</th>
                    <th class="p-2 text-left">Email</th>
                    <th class="p-2 text-left">Modules assignés</th>
                    <th class="p-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($teachers as $teacher)
                <tr class="border-b">
                    <td class="p-2">{{ $teacher->name }}</td>
                    <td class="p-2">{{ $teacher->email }}</td>
                    <td class="p-2">
                        @foreach($teacher->modules as $module)
                            <span class="inline-block bg-gray-200 text-sm px-2 py-1 rounded mr-1">{{ $module->name }}</span>
                        @endforeach
                    </td>
                    <td class="p-2">
                        <a href="{{ route('teachers.edit', $teacher->id) }}" class="text-blue-600">Modifier</a>
                        <form action="{{ route('teachers.destroy', $teacher->id) }}" method="POST" class="inline-block ml-2" onsubmit="return confirm('Supprimer cet enseignant ?')">
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
        <x-empty-state message="Aucun enseignant enregistré." />
    @endif
</x-section>
@endsection
