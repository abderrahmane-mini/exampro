@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-extrabold text-gray-800">Tableau de Bord Enseignant</h1>
        <div class="flex items-center space-x-4">
            <span class="text-gray-600">{{ now()->format('d M Y') }}</span>
            <div class="w-10 h-10 bg-purple-500 rounded-full flex items-center justify-center text-white">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all 
                    transform hover:-translate-y-2 p-6 border-l-4 border-blue-500">
            <h3 class="text-lg font-semibold text-gray-600 mb-3">Modules Assignés</h3>
            <div class="flex justify-between items-center">
                <p class="text-3xl font-bold text-blue-600">{{ $assignedModulesCount ?? 0 }}</p>
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
            <h3 class="text-lg font-semibold text-gray-600 mb-3">Examens à Venir</h3>
            <div class="flex justify-between items-center">
                <p class="text-3xl font-bold text-green-600">{{ $upcomingExamsCount ?? 0 }}</p>
                <div class="bg-green-100 text-green-600 p-2 rounded-full">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all 
                    transform hover:-translate-y-2 p-6 border-l-4 border-purple-500">
            <h3 class="text-lg font-semibold text-gray-600 mb-3">Total Étudiants</h3>
            <div class="flex justify-between items-center">
                <p class="text-3xl font-bold text-purple-600">{{ $totalStudentsCount ?? 0 }}</p>
                <div class="bg-purple-100 text-purple-600 p-2 rounded-full">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-8">
        <div>
            <h2 class="text-2xl font-bold mb-4">Mes Modules Récents</h2>
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="space-y-4">
                    @forelse($recentModules ?? [] as $module)
                        <div class="bg-gray-100 p-4 rounded-lg flex justify-between items-center">
                            <div>
                                <h4 class="font-semibold">{{ $module->name }}</h4>
                                <p class="text-sm text-gray-600">{{ $module->code }}</p>
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('modules.details', $module->id) }}" 
                                   class="text-blue-500 hover:text-blue-700">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500">Aucun module récent</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div>
            <h2 class="text-2xl font-bold mb-4">Notes des Étudiants</h2>
            <div class="bg-white rounded-xl shadow-lg p-6">
                <canvas id="studentGradesChart"></canvas>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('studentGradesChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {{ json_encode($moduleNames ?? []) }},
            datasets: [{
                label: 'Moyenne des Notes',
                data: {{ json_encode($moduleAverageGrades ?? []) }},
                backgroundColor: [
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(255, 206, 86, 0.7)'
                ]
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