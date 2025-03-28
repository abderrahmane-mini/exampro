@extends('layouts.app')

@section('content')
<x-page-title title="Permissions" subtitle="Gestion des rôles et autorisations" />

<x-alert />

<x-section>
    <p class="text-gray-600">La gestion avancée des rôles peut être intégrée ici à l’aide d’un package comme <strong>spatie/laravel-permission</strong>.</p>

    <ul class="list-disc pl-6 mt-4 text-sm text-gray-700">
        <li><strong>Administrateur</strong> – Gère tous les comptes et les rôles</li>
        <li><strong>Directeur pédagogique</strong> – Gère les filières, groupes, étudiants, modules, examens</li>
        <li><strong>Enseignant</strong> – Saisie des notes, consultation des examens</li>
        <li><strong>Étudiant</strong> – Consultation planning et résultats</li>
    </ul>

    <p class="mt-4">Pour des rôles dynamiques, implémentez une table de permissions ou utilisez un système basé sur les policies.</p>
</x-section>
@endsection
