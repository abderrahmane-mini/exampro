@extends('layouts.app')

@section('content')
<x-page-title title="Modules" subtitle="Liste des modules enseignés" />

<x-alert />

<x-section>
    <a href="{{ route('modules.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">
        + Nouveau module
    </a>

    @if($modules->count())
        <table class="w-full table-auto">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 text-left">Nom du module</th>
                    <th class="p-2 text-left">Code</th>
                    <th class="p-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($modules as $module)
                <tr class="border-b">
                    <td class="p-2">{{ $module->name }}</td>
                    <td class="p-2">{{ $module->code }}</td>
                    <td class="p-2">
                        <a href="{{ route('modules.edit', $module->id) }}" class="text-blue-600">Modifier</a>
                        <form action="{{ route('modules.destroy', $module->id) }}" method="POST" class="inline-block ml-2" onsubmit="return confirm('Supprimer ce module ?')">
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
        <x-empty-state message="Aucun module trouvé." />
    @endif
</x-section>
@endsection
