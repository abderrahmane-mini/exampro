<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="card-header mb-6 text-center">
        <h2 class="text-2xl font-bold text-gray-800 decorated-header">Connexion</h2>
        <p class="mt-4 text-gray-600">Accédez à votre compte pour gérer vos examens</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
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
                              autocomplete="current-password"
                              placeholder="••••••••" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="flex items-center cursor-pointer">
                <input id="remember_me" 
                       type="checkbox" 
                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
                       name="remember">
                <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
            
            @if (Route::has('password.request'))
                <a class="text-sm text-blue-600 hover:text-blue-800 font-medium transition-colors" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <div class="pt-2">
            <button type="submit" class="btn-primary w-full flex items-center justify-center px-6 py-3 bg-blue-600 rounded-lg font-semibold text-white transition-all duration-200 text-base">
                <i class="fas fa-sign-in-alt mr-2"></i> {{ __('Log in') }}
            </button>
        </div>

        @if (Route::has('register'))
            <div class="text-center mt-6">
                <p class="text-sm text-gray-600">
                    {{ __("Don't have an account?") }} 
                    <a class="text-blue-600 hover:text-blue-800 font-medium transition-colors" href="{{ route('register') }}">
                        {{ __("Register") }}
                    </a>
                </p>
            </div>
        @endif
    </form>
</x-guest-layout>