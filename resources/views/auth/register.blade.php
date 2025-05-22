{{-- Registration is disabled --}}
<x-guest-layout>
    <div class="text-center py-10">
        <h2 class="text-2xl font-bold text-gray-800">L'inscription est désactivée</h2>
        <p class="mt-4 text-gray-600">Veuillez contacter l'administrateur pour créer un compte.</p>
        <a href="{{ route('login') }}" class="btn btn-primary mt-6">Retour à la connexion</a>
    </div>
</x-guest-layout>