@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-3xl font-bold mb-6">Tableau de Bord - Administrateur</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">Total Utilisateurs</h2>
            <p class="text-3xl font-bold">{{ $totalUsersCount ?? 0 }}</p>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">Directeurs Pédagogiques</h2>
            <p class="text-3xl font-bold">{{ $directeurCount ?? 0 }}</p>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">Enseignants</h2>
            <p class="text-3xl font-bold">{{ $enseignantCount ?? 0 }}</p>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">Étudiants</h2>
            <p class="text-3xl font-bold">{{ $etudiantCount ?? 0 }}</p>
        </div>
    </div>

    <div class="mt-8">
        <h2 class="text-2xl font-bold mb-4">Derniers Comptes Créés</h2>
        <div class="bg-white p-6 rounded-lg shadow">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-3 text-left">Nom</th>
                        <th class="p-3 text-left">Email</th>
                        <th class="p-3 text-left">Type</th>
                        <th class="p-3 text-left">Date Création</th>
                        <th class="p-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentUsers ?? [] as $user)
                        <tr class="border-b">
                            <td class="p-3">{{ $user->name }}</td>
                            <td class="p-3">{{ $user->email }}</td>
                            <td class="p-3">
                                <span class="px-2 py-1 rounded 
                                    {{ $user->user_type == 'directeur_pedagogique' ? 'bg-blue-100 text-blue-800' : 
                                       ($user->user_type == 'enseignant' ? 'bg-green-100 text-green-800' : 
                                       ($user->user_type == 'etudiant' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800')) }}">
                                    {{ __(ucfirst($user->user_type)) }}
                                </span>
                            </td>
                            <td class="p-3">{{ $user->created_at->format('d/m/Y') }}</td>
                            <td class="p-3">
                                <a href="{{ route('users.edit', $user->id) }}" 
                                   class="text-blue-500 hover:text-blue-700 mr-2">
                                    Éditer
                                </a>
                                <a href="{{ route('users.delete', $user->id) }}" 
                                   class="text-red-500 hover:text-red-700">
                                    Supprimer
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-3 text-center text-gray-500">
                                Aucun utilisateur récent
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-8 grid grid-cols-2 gap-6">
        <div>
            <h2 class="text-2xl font-bold mb-4">Distribution des Utilisateurs</h2>
            <div class="bg-white p-6 rounded-lg shadow">
                <canvas id="userDistributionChart"></canvas>
            </div>
        </div>
        <div>
            <h2 class="text-2xl font-bold mb-4">Activités Récentes</h2>
            <div class="bg-white p-6 rounded-lg shadow">
                <ul class="divide-y">
                    @forelse($recentActivities ?? [] as $activity)
                        <li class="py-3">
                            <div class="flex justify-between">
                                <span>{{ $activity->description }}</span>
                                <span class="text-gray-500 text-sm">
                                    {{ $activity->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </li>
                    @empty
                        <li class="text-center text-gray-500">
                            Aucune activité récente
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('userDistributionChart').getContext('2d');
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
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(75, 192, 192, 0.6)',
                    'rgba(255, 206, 86, 0.6)',
                    'rgba(231, 76, 60, 0.6)'
                ]
            }]
        },
        options: {
            responsive: true,
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