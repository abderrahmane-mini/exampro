@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-3xl font-bold mb-6">Tableau de Bord - Étudiant</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">Moyenne Générale</h2>
            <p class="text-3xl font-bold">{{ number_format($generalAverage ?? 0, 2) }}</p>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">Examens à Venir</h2>
            <p class="text-3xl font-bold">{{ $upcomingExamsCount ?? 0 }}</p>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">Groupe</h2>
            <p class="text-xl font-bold">{{ $userGroup->name ?? 'Non assigné' }}</p>
        </div>
    </div>

    <div class="mt-8">
        <h2 class="text-2xl font-bold mb-4">Résultats Récents</h2>
        <div class="bg-white p-6 rounded-lg shadow">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-3 text-left">Module</th>
                        <th class="p-3 text-left">Examen</th>
                        <th class="p-3 text-left">Note</th>
                        <th class="p-3 text-left">Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentResults ?? [] as $result)
                        <tr class="border-b">
                            <td class="p-3">{{ $result->exam->module->name }}</td>
                            <td class="p-3">{{ $result->exam->date }}</td>
                            <td class="p-3">
                                <span class="{{ $result->grade >= 10 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ number_format($result->grade, 2) }}
                                </span>
                            </td>
                            <td class="p-3">
                                {{ $result->grade >= 10 ? 'Validé' : 'Non Validé' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-3 text-center text-gray-500">
                                Aucun résultat disponible
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-8">
        <h2 class="text-2xl font-bold mb-4">Emploi du Temps</h2>
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="grid grid-cols-7 gap-2 text-center">
                @foreach(['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'] as $day)
                    <div class="font-bold">{{ $day }}</div>
                @endforeach
                @foreach($scheduleSlots ?? [] as $slot)
                    <div class="bg-blue-100 p-2 rounded">
                        {{ $slot->module }} <br>
                        {{ $slot->time }}
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection