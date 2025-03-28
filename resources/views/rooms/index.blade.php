@extends('layouts.app')

@section('content')
<x-page-title title="Salles" subtitle="Liste des salles d'examen" />

<x-alert />

<x-section>
    <a href="{{ route('rooms.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">
        + Nouvelle salle
    </a>

    @if($rooms->count())
        <table class="w-full table-auto">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 text-left">Nom</th>
                    <th class="p-2 text-left">Capacité</th>
                    <th class="p-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rooms as $room)
                <tr class="border-b">
                    <td class="p-2">{{ $room->name }}</td>
                    <td class="p-2">{{ $room->capacity }}</td>
                    <td class="p-2">
                        <a href="{{ route('rooms.edit', $room->id) }}" class="text-blue-600">Modifier</a> |
                        <a href="{{ route('rooms.exams', $room->id) }}" class="text-yellow-600">Examens</a>
                        <form action="{{ route('rooms.destroy', $room->id) }}" method="POST" class="inline-block ml-2" onsubmit="return confirm('Supprimer cette salle ?')">
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
        <x-empty-state message="Aucune salle trouvée." />
    @endif
</x-section>
@endsection
