@extends('layouts.app')

@section('content')
<x-page-title title="Profil Utilisateur" subtitle="Détails de l'utilisateur" />

<x-section>
    <div class="space-y-4">
        <p><strong>Nom :</strong> {{ $user->name }}</p>
        <p><strong>Email :</strong> {{ $user->email }}</p>
        <p><strong>Rôle :</strong> {{ ucfirst($user->user_type) }}</p>
        <a href="{{ route('users.manage') }}" class="text-blue-600 hover:underline text-sm">← Retour à la liste</a>
    </div>
</x-section>
@endsection
