@extends('layouts.app')

@section('content')
<x-page-title title="Assigner des étudiants" subtitle="Ajouter ou retirer des étudiants du groupe {{ $group->name }}" />

<x-alert />

<x-section>
    <form action="{{ route('groups.assign.save', $group->id) }}" method="POST">
        @csrf

        <div class="overflow-x-auto rounded-md border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 text-left text-sm font-medium text-gray-600">Étudiant</th>
                        <th class="p-3 text-center text-sm font-medium text-gray-600">
                            Assigné
                            <input type="checkbox" id="select-all" class="ml-2">
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($students as $student)
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 text-sm">{{ $student->name }}</td>
                            <td class="p-3 text-center">
                                <input type="checkbox" name="students[]" value="{{ $student->id }}"
                                    class="student-checkbox"
                                    {{ in_array($student->id, $assignedStudentIds) ? 'checked' : '' }}>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6 flex items-center">
            <x-primary-button>Mettre à jour les affectations</x-primary-button>
            <a href="{{ route('groups.index') }}" class="text-sm text-gray-500 underline ml-4">Retour</a>
        </div>
    </form>
</x-section>

<!-- Select All Script -->
@push('scripts')
<script>
    document.getElementById('select-all').addEventListener('change', function () {
        const checkboxes = document.querySelectorAll('.student-checkbox');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });
</script>
@endpush

@endsection
