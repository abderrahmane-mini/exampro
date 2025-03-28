@extends('layouts.app')

@section('content')
<x-page-title title="Modules" subtitle="Liste des modules enseignés" />

<x-alert />

<x-section>
    <a href="{{ route('modules.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">
        + Nouveau module
    </a>

    @if($modules->count())
        <div class="overflow-x-auto">
            <table class="w-full table-auto border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 text-left border-b">Nom du module</th>
                        <th class="p-2 text-left border-b">Code</th>
                        <th class="p-2 text-left border-b">Filière</th> {{-- ✅ Added --}}
                        <th class="p-2 text-left border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($modules as $module)
                    <tr class="hover:bg-gray-50">
                        <td class="p-2 border-b">{{ $module->name }}</td>
                        <td class="p-2 border-b">{{ $module->code }}</td>
                        <td class="p-2 border-b">
                            {{ $module->program->name ?? 'Non assignée' }} {{-- ✅ Show program name --}}
                        </td>
                        <td class="p-2 border-b">
                            <a href="{{ route('modules.edit', $module->id) }}" class="text-blue-600 hover:underline">Modifier</a>
                            <form action="{{ route('modules.destroy', $module->id) }}" method="POST" class="inline-block ml-2" onsubmit="return confirm('Supprimer ce module ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <x-empty-state message="Aucun module trouvé." />
    @endif
</x-section>
@endsection
