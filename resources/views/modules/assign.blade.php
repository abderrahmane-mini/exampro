@extends('layouts.app')

@section('content')
<x-page-title title="Assigner des Modules" subtitle="Assigner un ou plusieurs modules à chaque enseignant" />

<x-alert />

<x-section>
    <form action="{{ route('modules.assign.save') }}" method="POST">
        @csrf

        <table class="w-full table-auto">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2">Enseignant</th>
                    <th class="p-2">Modules assignés</th>
                </tr>
            </thead>
            <tbody>
                @foreach($teachers as $teacher)
                    <tr class="border-b">
                        <td class="p-2 font-semibold">{{ $teacher->name }}</td>
                        <td class="p-2">
                            @foreach($modules as $module)
                                <label class="inline-flex items-center mr-4">
                                    <input type="checkbox" name="assignments[{{ $teacher->id }}][]" value="{{ $module->id }}"
                                           {{ in_array($module->id, $teacher->modules->pluck('id')->toArray()) ? 'checked' : '' }}>
                                    <span class="ml-1">{{ $module->name }}</span>
                                </label>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-6">
            <x-primary-button>Enregistrer les affectations</x-primary-button>
        </div>
    </form>
</x-section>
@endsection
