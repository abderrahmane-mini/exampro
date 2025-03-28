@extends('layouts.app')

@section('content')
    <x-page-title title="Tableau de bord" subtitle="Bienvenue sur la plateforme ExamPro" />

    <x-alert />

    <x-section>
        <p class="text-gray-600">Vous êtes connecté en tant que <strong>{{ Auth::user()->user_type }}</strong>.</p>

        <p class="mt-2 text-sm text-gray-500">
            Utilisez le menu latéral pour accéder aux fonctionnalités adaptées à votre rôle.
        </p>
    </x-section>
@endsection
