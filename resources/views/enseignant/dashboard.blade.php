@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-3xl font-bold mb-6">Tableau de Bord - Enseignant</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">Modules Assignés</h2>
            <p class="text-3xl font-bold">{{ $assignedModulesCount ?? 0 }}</p>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">Examens à Venir</h2>
            <p class="text-3xl font-bold">{{ $upcomingExamsCount ?? 0 }}</p>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">Étudiants Total</h2>
            <p class="text-3xl font-bold">{{ $totalStudentsCount ?? 0 }}</p>
        </div>
    </div>

    <div class="mt-8">
        <h2 class="text-2xl font-bold mb-4">Mes Modules Récents</h2>
        <div class="bg-white p-6 rounded-lg shadow">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-3 text-left">Module</th>
                        <th class="p-3 text-left">Code</th>
                        <th class="p-3 text-left">Filière</th>
                        <th class="p-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentModules ?? [] as $module)
                        <tr class="border-b">
                            <td class="p-3">{{ $module->name }}</td>
                            <td class="p-3">{{ $module->code }}</td>
                            <td class="p-3">{{ $module->program->name }}</td>
                            <td class="p-3">
                                <a href="{{ route('modules.details', $module->id) }}" 
                                   class="text-blue-500 hover:text-blue-700">
                                    Détails
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-3 text-center text-gray-500">
                                Aucun module assigné
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection