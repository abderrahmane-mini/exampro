@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-extrabold text-gray-800">Tableau de Bord - Administrateur</h1>
        <div class="flex items-center space-x-4">
            <span class="text-gray-600">{{ now()->format('d M Y') }}</span>
            <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-2 p-6 border-l-4 border-blue-500">
            <h3 class="text-lg font-semibold text-gray-600 mb-3">Total Utilisateurs</h3>
            <div class="flex justify-between items-center">
                <p class="text-3xl font-bold text-blue-600">{{ $totalUsersCount ?? 0 }}</p>
                <div class="bg-blue-100 text-blue-600 p-2 rounded-full">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5 8.445v5.127a1 1 0 00.553.894l4 2a1 1 0 00.894 0l4-2A1 1 0 0015 13.572v-5.127l2-1.527V17a1 1 0 102 0V4a1 1 0 00-.553-.894l-7-3z"/>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-2 p-6 border-l-4 border-green-500">
            <h3 class="text-lg font-semibold text-gray-600 mb-3">Directeurs Pédagogiques</h3>
            <div class="flex justify-between items-center">
                <p class="text-3xl font-bold text-green-600">{{ $directeurCount ?? 0 }}</p>
                <div class="bg-green-100 text-green-600 p-2 rounded-full">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-2 p-6 border-l-4 border-purple-500">
            <h3 class="text-lg font-semibold text-gray-600 mb-3">Étudiants</h3>
            <div class="flex justify-between items-center">
                <p class="text-3xl font-bold text-purple-600">{{ $etudiantCount ?? 0 }}</p>
                <div class="bg-purple-100 text-purple-600 p-2 rounded-full">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-16">
        <div>
            <h2 class="text-2xl font-bold mb-4">Distribution des Utilisateurs</h2>
            <div class="bg-white rounded-xl shadow-lg p-6">
                <canvas id="programDistributionChart"></canvas>
            </div>
        </div>
    
        <div>
            <h2 class="text-2xl font-bold mb-4">Détails des Utilisateurs</h2>
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="space-y-4">
                    @forelse($recentUsers ?? [] as $user)
                        <div class="bg-gray-100 p-4 rounded-lg flex justify-between items-center">
                            <div>
                                <h4 class="font-semibold">{{ $user->name }}</h4>
                                <p class="text-sm text-gray-600">{{ $user->email }}</p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="text-sm 
                                    {{ $user->user_type == 'directeur_pedagogique' ? 'bg-blue-100 text-blue-600' : 
                                       ($user->user_type == 'enseignant' ? 'bg-green-100 text-green-600' : 
                                       ($user->user_type == 'etudiant' ? 'bg-yellow-100 text-yellow-600' : 'bg-gray-100 text-gray-600')) }} 
                                    px-2 py-1 rounded-full">
                                    {{ __(ucfirst($user->user_type)) }}
                                </span>
                                <a href="{{ route('users.edit', $user->id) }}" class="text-blue-500 hover:text-blue-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <form action="{{ route('users.delete', $user->id) }}" method="POST" onsubmit="return confirm('Supprimer cet utilisateur ?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500">Aucun utilisateur récent</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('programDistributionChart').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Directeurs', 'Enseignants', 'Étudiants', 'Administrateurs'],
            datasets: [{
                data: [
                    {{ $directeurCount ?? 0 }}, 
                    {{ $enseignantCount ?? 0 }}, 
                    {{ $etudiantCount ?? 0 }}, 
                    {{ $adminCount ?? 0 }}
                ],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(231, 76, 60, 0.7)'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });
});
</script>
@endpush
@endsection