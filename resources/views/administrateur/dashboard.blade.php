@extends('layouts.app')
@section('content')
<div class="container mx-auto px-4">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-extrabold text-gray-800">Tableau de Bord Administrateur</h1>
        <div class="flex items-center space-x-4">
            <span class="text-gray-600">{{ now()->format('d M Y') }}</span>
            <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        @php
            $cards = [
                ['title' => 'Total Utilisateurs', 'value' => $totalUsersCount ?? 0, 'icon' => 'fas fa-users', 'color' => 'blue', 'trend' => 5.2],
                ['title' => 'Directeurs Pédagogiques', 'value' => $directeurCount ?? 0, 'icon' => 'fas fa-chalkboard-teacher', 'color' => 'green', 'trend' => 3.8],
                ['title' => 'Enseignants', 'value' => $enseignantCount ?? 0, 'icon' => 'fas fa-book-reader', 'color' => 'purple', 'trend' => -1.5],
                ['title' => 'Étudiants', 'value' => $etudiantCount ?? 0, 'icon' => 'fas fa-user-graduate', 'color' => 'red', 'trend' => 2.1]
            ];
        @endphp
        @foreach($cards as $card)
            <div class="bg-gradient-to-br from-{{ $card['color'] }}-50 to-{{ $card['color'] }}-100 rounded-xl shadow-md p-6 transform transition-all hover:scale-105 hover:shadow-lg group">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-600 mb-2">{{ $card['title'] }}</h2>
                        <p class="text-3xl font-bold text-{{ $card['color'] }}-800">{{ $card['value'] }}</p>
                    </div>
                    <i class="{{ $card['icon'] }} text-{{ $card['color'] }}-400 opacity-70 group-hover:text-{{ $card['color'] }}-600 transition-all transform group-hover:scale-110" style="font-size: 48px;"></i>
                </div>
                @if($card['trend'])
                <div class="mt-4 flex items-center">
                    <i class="fas fa-arrow-{{ $card['trend'] > 0 ? 'up' : 'down' }} mr-2 {{ $card['trend'] > 0 ? 'text-green-500' : 'text-red-500' }}" style="font-size: 20px;"></i>
                    <span class="text-sm {{ $card['trend'] > 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ abs($card['trend']) }}% ce mois-ci
                    </span>
                </div>
                @endif
            </div>
        @endforeach
    </div>
    <div class="grid md:grid-cols-2 gap-8">
        <div>
            <h2 class="text-2xl font-bold mb-4">Derniers Comptes</h2>
            <div class="bg-white rounded-xl shadow-lg p-6">
                <table class="w-full">
                    <thead>
                        <tr class="text-gray-600 border-b">
                            <th class="pb-3 text-left">Nom</th>
                            <th class="pb-3 text-left">Type</th>
                            <th class="pb-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentUsers ?? [] as $user)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="py-3">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-blue-100 rounded-full mr-3 flex items-center justify-center text-blue-600">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="font-semibold">{{ $user->name }}</p>
                                            <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <span class="px-2 py-1 rounded-full text-xs 
                                        {{ $user->user_type == 'directeur_pedagogique' ? 'bg-green-100 text-green-800' : 
                                           ($user->user_type == 'enseignant' ? 'bg-blue-100 text-blue-800' : 
                                           ($user->user_type == 'etudiant' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800')) }}">
                                        {{ ucfirst($user->user_type) }}
                                    </span>
                                </td>
                                <td class="py-3 text-right">
                                    <div class="flex justify-end space-x-2">
                                        <a href="{{ route('users.edit', $user->id) }}" class="text-blue-500 hover:text-blue-700">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.379-8.379-2.828-2.828z"/>
                                            </svg>
                                        </a>
                                        <a href="{{ route('users.delete', $user->id) }}" class="text-red-500 hover:text-red-700">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-gray-500 py-4">
                                    Aucun utilisateur récent
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div>
            <h2 class="text-2xl font-bold mb-4">Distribution des Utilisateurs</h2>
            <div class="bg-white rounded-xl shadow-lg p-6">
                <canvas id="userDistributionChart"></canvas>
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
        type: 'doughnut',
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
            plugins: {
                legend: {
                    position: 'bottom',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let total = context.dataset.data.reduce((a, b) => a + b, 0);
                            let value = context.parsed;
                            let percentage = ((value/total) * 100).toFixed(1);
                            return `${context.label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush
@endsection