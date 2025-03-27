@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-3xl font-bold mb-6">Tableau de Bord - Directeur Pédagogique</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">Nombre de Filières</h2>
            <p class="text-3xl font-bold">{{ $programsCount ?? 0 }}</p>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">Nombre d'Étudiants</h2>
            <p class="text-3xl font-bold">{{ $studentsCount ?? 0 }}</p>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">Nombre de Modules</h2>
            <p class="text-3xl font-bold">{{ $modulesCount ?? 0 }}</p>
        </div>
    </div>
</div>
@endsection