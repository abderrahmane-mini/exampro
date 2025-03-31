@extends('layouts.app')

@section('content')
<x-page-title title="Examens" subtitle="Liste des examens planifiés" />

<x-alert />

<x-section>
    <!-- Filter Form -->
    <form method="GET" action="{{ route('exams.index') }}" class="mb-4 flex flex-wrap items-center space-x-4">
        <div>
            <label class="text-sm font-medium">Filtrer par groupe :</label>
            <select name="group" onchange="this.form.submit()" class="border rounded px-2 py-1 text-sm">
                <option value="">Tous</option>
                @foreach($groups as $group)
                    <option value="{{ $group->id }}" {{ request('group') == $group->id ? 'selected' : '' }}>
                        {{ $group->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="text-sm font-medium">Filtrer par module :</label>
            <select name="module" onchange="this.form.submit()" class="border rounded px-2 py-1 text-sm">
                <option value="">Tous</option>
                @foreach($modules as $mod)
                    <option value="{{ $mod->id }}" {{ request('module') == $mod->id ? 'selected' : '' }}>
                        {{ $mod->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <a href="{{ route('exams.create') }}" class="ml-auto bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
            + Planifier un examen
        </a>
    </form>

    @if($exams->count())
        <div class="overflow-x-auto">
            <table class="w-full table-auto">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2">Module</th>
                        <th class="p-2">Groupe</th>
                        <th class="p-2">Salle(s)</th>
                        <th class="p-2">Date</th>
                        <th class="p-2">Heure</th>
                        <th class="p-2">Enseignant(s)</th>
                        <th class="p-2 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($exams as $exam)
                        <tr class="border-b">
                            <td class="p-2">{{ $exam->module->name }}</td>
                            <td class="p-2">{{ $exam->group->name }}</td>
                            <td class="p-2">
                                @foreach($exam->rooms as $room)
                                    <span class="inline-block bg-gray-200 text-sm px-2 py-1 rounded mr-1">{{ $room->name }}</span>
                                @endforeach
                            </td>
                            <td class="p-2">{{ \Carbon\Carbon::parse($exam->start_time)->format('d/m/Y') }}</td>
                            <td class="p-2">{{ \Carbon\Carbon::parse($exam->start_time)->format('H:i') }}</td>
                            <td class="p-2">
                                @foreach($exam->teachers as $teacher)
                                    <span class="inline-block bg-blue-100 text-sm px-2 py-1 rounded text-blue-800 mr-1">
                                        {{ $teacher->name }}
                                    </span>
                                @endforeach
                            </td>
                            <td class="p-2 text-center">
                                <a href="{{ route('exams.edit', $exam->id) }}" class="text-blue-600 hover:underline">
                                    <i class="fas fa-edit"></i> Modifier
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $exams->appends(request()->query())->links() }}
        </div>
    @else
        <x-empty-state message="Aucun examen planifié pour le moment." />
    @endif
</x-section>
@endsection
