@extends('layouts.app')

@section('content')
<x-page-title title="Filières" subtitle="Liste des filières enregistrées" />

<x-alert />

<x-section>
    <a href="{{ route('programs.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">
        + Nouvelle filière
    </a>

    @if($programs->count())
        <table class="w-full table-auto">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 text-left">Nom</th>
                    <th class="p-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($programs as $program)
                <tr class="border-b">
                    <td class="p-2">{{ $program->name }}</td>
                    <td class="p-2">
                        <a href="{{ route('programs.edit', $program->id) }}" class="text-blue-600">Modifier</a> |
                        <form action="{{ route('programs.destroy', $program->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Supprimer cette filière ?')">
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
        <x-empty-state message="Aucune filière enregistrée." />
    @endif
</x-section>
@endsection
    