@extends('layouts.app')

@section('content')
<x-page-title title="Groupes" subtitle="Liste des groupes par filière" />

<x-alert />

<x-section>
    <a href="{{ route('groups.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">
        + Nouveau groupe
    </a>

    @if($groups->count())
        <table class="w-full table-auto">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 text-left">Nom</th>
                    <th class="p-2 text-left">Filière</th>
                    <th class="p-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($groups as $group)
                <tr class="border-b">
                    <td class="p-2">{{ $group->name }}</td>
                    <td class="p-2">{{ $group->program->name }}</td>
                    <td class="p-2">
                        <a href="{{ route('groups.edit', $group->id) }}" class="text-blue-600">Modifier</a> |
                        <a href="{{ route('groups.assign', $group->id) }}" class="text-yellow-600">Assigner étudiants</a> |
                        <form action="{{ route('groups.destroy', $group->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Supprimer ce groupe ?')">
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
        <x-empty-state message="Aucun groupe trouvé." />
    @endif
</x-section>
@endsection
