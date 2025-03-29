<x-guest-layout>
    <div class="card-header mb-6 text-center">
        <h2 class="text-2xl font-bold text-gray-800 decorated-header">Créer un compte</h2>
        <p class="mt-4 text-gray-600">Rejoignez notre plateforme d'examens</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div class="form-group">
            <x-input-label for="name" :value="__('Name')" class="text-gray-700 font-medium mb-2" />
            <div class="relative">
                <span class="absolute inset-y-0 left-3 flex items-center text-gray-500">
                    <i class="fas fa-user"></i>
                </span>
                <x-text-input id="name" 
                              class="block w-full pl-10 pr-3 py-3 border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition-all duration-200" 
                              type="text" 
                              name="name" 
                              :value="old('name')" 
                              required 
                              autofocus 
                              autocomplete="name"
                              placeholder="Votre nom" />
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-red-600" />
        </div>

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
                              autocomplete="username"
                              placeholder="votre@email.com" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
        </div>

        <!-- Password -->
        <div class="form-group">
            <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-medium mb-2" />
            <div class="relative">
                <span class="absolute inset-y-0 left-3 flex items-center text-gray-500">
                    <i class="fas fa-lock"></i>
                </span>
                <x-text-input id="password" 
                              class="block w-full pl-10 pr-3 py-3 border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition-all duration-200"
                              type="password"
                              name="password"
                              required 
                              autocomplete="new-password"
                              placeholder="••••••••" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
        </div>

        <!-- Confirm Password -->
        <div class="form-group">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-gray-700 font-medium mb-2" />
            <div class="relative">
                <span class="absolute inset-y-0 left-3 flex items-center text-gray-500">
                    <i class="fas fa-check-double"></i>
                </span>
                <x-text-input id="password_confirmation" 
                              class="block w-full pl-10 pr-3 py-3 border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition-all duration-200"
                              type="password"
                              name="password_confirmation" 
                              required 
                              autocomplete="new-password"
                              placeholder="••••••••" />
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-red-600" />
        </div>

        <div class="pt-2">
            <button type="submit" class="btn-primary w-full flex items-center justify-center px-6 py-3 bg-blue-600 rounded-lg font-semibold text-white transition-all duration-200 text-base">
                <i class="fas fa-user-plus mr-2"></i> {{ __('Register') }}
            </button>
        </div>

        <div class="text-center mt-6">
            <p class="text-sm text-gray-600">
                {{ __("Already registered?") }} 
                <a class="text-blue-600 hover:text-blue-800 font-medium transition-colors" href="{{ route('login') }}">
                    {{ __("Log in") }}
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>