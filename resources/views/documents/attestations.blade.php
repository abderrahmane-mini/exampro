@extends('layouts.app')

@section('content')
    <x-page-title title="Attestations" subtitle="Générer une attestation de réussite" />
    <x-alert />

    <x-section>
        <!-- 🔍 Filters -->
        <form method="GET" action="{{ route('documents.attestations') }}" class="mb-4 flex flex-wrap gap-4 items-center">
            <div>
                <label for="group_id" class="mr-2 font-medium text-sm text-gray-700">Groupe :</label>
                <select name="group_id" id="group_id" onchange="this.form.submit()" class="border px-3 py-1 rounded shadow-sm text-sm">
                    <option value="">Tous</option>
                    @foreach($groups as $group)
                        <option value="{{ $group->id }}" {{ request('group_id') == $group->id ? 'selected' : '' }}>
                            {{ $group->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="search" class="mr-2 font-medium text-sm text-gray-700">Nom :</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Rechercher un étudiant"
                       class="border px-3 py-1 rounded shadow-sm text-sm">
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-1.5 rounded text-sm hover:bg-blue-700">
                Filtrer
            </button>
        </form>

        <!-- 📄 Table -->
        @if($students->count())
            <table class="w-full table-auto">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 text-left">Nom</th>
                        <th class="p-2 text-left">Groupe</th>
                        <th class="p-2 text-left">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                        <tr class="border-b">
                            <td class="p-2">{{ $student->name }}</td>
                            <td class="p-2">{{ $student->group->name ?? '-' }}</td>
                            <td class="p-2 space-x-4">
                                <a href="{{ route('documents.attestation.view', $student->id) }}" class="text-blue-500 hover:underline">
                                    Voir l’attestation
                                </a>
                                <a href="{{ route('documents.attestation.download', $student->id) }}" class="text-green-600 hover:underline">
                                    Télécharger PDF
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- 🔄 Pagination -->
            <div class="mt-6 text-center">
                {{ $students->appends(request()->query())->links() }}
            </div>
        @else
            <x-empty-state message="Aucun étudiant trouvé." />
        @endif
    </x-section>
@endsection
