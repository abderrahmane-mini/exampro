<x-guest-layout>
    <div class="card-header mb-6 text-center">
        <h2 class="text-2xl font-bold text-gray-800 decorated-header">Réinitialiser le mot de passe</h2>
    </div>

    <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-100 text-blue-800">
        <p class="text-sm">
            <i class="fas fa-info-circle mr-2 text-blue-500"></i>
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-6 p-4 bg-green-50 rounded-lg border border-green-100 text-green-700" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div class="form-group">
            <x-input-label for="email" :value="__('Email')" class="text-gray-700 font-medium mb-2" />
            <div class="relative">
                <span class="absolute inset-y-0 left-3 flex items-center text-gray-500">
                    <i class="fas fa-envelope"></i>
                </span>
                <x-text-input id="email" 
                              class="block w-full pl-10 pr-3 py-3 border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition-all duration-200" 
                              type="email" 
                              name="email" 
                              :value="old('email')" 
                              required 
                              autofocus
                              placeholder="votre@email.com" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
        </div>

        <div class="flex items-center justify-between pt-2">
            <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-800 transition-colors">
                <i class="fas fa-arrow-left mr-1"></i> Retour à la connexion
            </a>

            <button type="submit" class="btn-primary flex items-center justify-center px-6 py-3 bg-blue-600 rounded-lg font-semibold text-white transition-all duration-200 text-sm">
                <i class="fas fa-paper-plane mr-2"></i> {{ __('Email Password Reset Link') }}
            </button>
        </div>
    </form>
</x-guest-layout>