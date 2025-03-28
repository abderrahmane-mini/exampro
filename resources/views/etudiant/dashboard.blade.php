@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-extrabold text-gray-800">Tableau de Bord Étudiant</h1>
        <div class="flex items-center space-x-4">
            <span class="text-gray-600">{{ now()->format('d M Y') }}</span>
            <div class="w-10 h-10 bg-red-500 rounded-full flex items-center justify-center text-white">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all 
                    transform hover:-translate-y-2 p-6 border-l-4 border-blue-500">
            <h3 class="text-lg font-semibold text-gray-600 mb-3">Moyenne Générale</h3>
            <div class="flex justify-between items-center">
                <p class="text-3xl font-bold text-blue-600">{{ $averageGrade ?? 'N/A' }}</p>
                <div class="bg-blue-100 text-blue-600 p-2 rounded-full">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all 
                    transform hover:-translate-y-2 p-6 border-l-4 border-green-500">
            <h3 class="text-lg font-semibold text-gray-600 mb-3">Modules Inscrits</h3>
            <div class="flex justify-between items-center">
                <p class="text-3xl font-bold text-green-600">{{ $registeredModulesCount ?? 0 }}</p>
                <div class="bg-green-100 text-green-600 p-2 rounded-full">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5 8.445v5.127a1 1 0 00.553.894l4 2a1 1 0 00.894 0l4-2A1 1 0 0015 13.572v-5.127l2-1.527V17a1 1 0 102 0V4a1 1 0 00-.553-.894l-7-3z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all 
                    transform hover:-translate-y-2 p-6 border-l-4 border-purple-500">
            <h3 class="text-lg font-semibold text-gray-600 mb-3">Examens à Venir</h3>
            <div class="flex justify-between items-center">
                <p class="text-3xl font-bold text-purple-600">{{ $upcomingExamsCount ?? 0 }}</p>
                <div class="bg-purple-100 text-purple-600 p-2 rounded-full">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13 7H7v2h6V7z"/>
                        <path fill-rule="evenodd" d="M3 5a2 2 0 012-2h10a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5zm11 1H6v8h8V6z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-8">
        <div>
            <h2 class="text-2xl font-bold mb-4">Notes par Module</h2>
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="space-y-4">
                    @forelse($moduleGrades ?? [] as $moduleGrade)
                        <div class="bg-gray-100 p-4 rounded-lg flex justify-between items-center">
                            <div>
                                <h4 class="font-semibold">{{ $moduleGrade->module_name }}</h4>
                                <p class="text-sm text-gray-600">{{ $moduleGrade->module_code }}</p>
                            </div>
                            <span class="text-lg font-bold 
                                {{ $moduleGrade->grade >= 10 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $moduleGrade->grade }}/20
                            </span>
                        </div>
                    @empty
                        <p class="text-center text-gray-500">Aucune note disponible</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div>
            <h2 class="text-2xl font-bold mb-4">Progression des Notes</h2>
            <div class="bg-white rounded-xl shadow-lg p-6">
                <canvas id="gradeProgressChart"></canvas>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('gradeProgressChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {{ json_encode($moduleNames ?? []) }},
            datasets: [{
                label: 'Notes',
                data: {{ json_encode($moduleGradeProgress ?? []) }},
                borderColor: 'rgba(54, 162, 235, 0.7)',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 20
                }
            }
        }
    });
});
</script>
@endpush
@endsection