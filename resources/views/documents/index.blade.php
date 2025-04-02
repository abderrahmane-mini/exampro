@extends('layouts.app')

@section('content')
<x-page-title title="PV des Notes" subtitle="Liste des PV disponibles" />
<x-alert />

<x-section>
    @if(auth()->user()->isDirecteurPedagogique())
        <!-- 🔍 Filters -->
        <form method="GET" action="{{ route('documents.index') }}" class="mb-4 flex flex-wrap gap-4 items-end">
            <div>
                <label for="module_id" class="text-sm font-semibold text-gray-700">Module</label>
                <select name="module_id" id="module_id" class="border px-3 py-1 rounded">
                    <option value="">Tous</option>
                    @foreach($modules as $module)
                        <option value="{{ $module->id }}" {{ request('module_id') == $module->id ? 'selected' : '' }}>
                            {{ $module->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="group_id" class="text-sm font-semibold text-gray-700">Groupe</label>
                <select name="group_id" id="group_id" class="border px-3 py-1 rounded">
                    <option value="">Tous</option>
                    @foreach($groups as $group)
                        <option value="{{ $group->id }}" {{ request('group_id') == $group->id ? 'selected' : '' }}>
                            {{ $group->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>

            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700">
                Filtrer
            </button>
        </form>
    @endif

    @if($exams->count())
        <table class="w-full table-auto">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 text-left">Module</th>
                    <th class="p-2 text-left">Groupe</th>
                    <th class="p-2 text-left">Date</th>
                    <th class="p-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($exams as $exam)
                    <tr class="border-b">
                        <td class="p-2">{{ $exam->module->name }}</td>
                        <td class="p-2">{{ $exam->group->name }}</td>
                        <td class="p-2">{{ \Carbon\Carbon::parse($exam->start_time)->format('d/m/Y H:i') }}</td>
                        <td class="p-2 space-x-2">
                            <a href="{{ route('documents.pv', $exam->id) }}" class="text-blue-600 hover:underline">Voir PV</a>
                            <a href="{{ route('documents.pv.download', $exam->id) }}" class="text-green-600 hover:underline">Télécharger</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- 🔄 Pagination -->
        <div class="mt-6 text-center">
            {{ $exams->appends(request()->query())->links() }}
        </div>

        

    @else
        <x-empty-state message="Aucun PV disponible pour le moment." />
    @endif
</x-section>
@endsection
