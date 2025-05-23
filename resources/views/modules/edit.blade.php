@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <x-page-title 
            title="Modifier le module" 
            subtitle="Mettre à jour les informations du module" 
        />

        {{-- Error Alert --}}
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Erreur de validation !</strong>
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Success Message --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <x-section>
            <form 
                action="{{ route('modules.update', $module->id) }}" 
                method="POST" 
                class="space-y-6 bg-white p-6 rounded-lg shadow-md"
            >
                @csrf
                @method('PUT')

                {{-- Module Name Input --}}
                <div>
                    <x-input-label for="name" value="Nom du module" />
                    <x-text-input 
                        type="text" 
                        name="name" 
                        id="name" 
                        class="w-full {{ $errors->has('name') ? 'border-red-500' : '' }}"
                        value="{{ old('name', $module->name) }}" 
                        required 
                        autofocus 
                        placeholder="Entrez le nom du module"
                    />
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Module Code Input --}}
                <div>
                    <x-input-label for="code" value="Code du module" />
                    <x-text-input 
                        type="text" 
                        name="code" 
                        id="code" 
                        class="w-full {{ $errors->has('code') ? 'border-red-500' : '' }}"
                        value="{{ old('code', $module->code) }}" 
                        required 
                        placeholder="Entrez le code du module"
                    />
                    @error('code')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Program Select --}}
                <div>
                    <x-input-label for="program_id" value="Filière (Programme)" />
                    <select name="program_id" id="program_id" class="w-full border-gray-300 rounded">
                        <option value="">-- Choisissez une filière --</option>
                        @foreach($programs as $program)
                            <option value="{{ $program->id }}" 
                                {{ old('program_id', $module->program_id) == $program->id ? 'selected' : '' }}>
                                {{ $program->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('program_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <x-primary-button type="submit">Mettre à jour</x-primary-button>
                        <a href="{{ route('modules.index') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">
                            Annuler
                        </a>
                    </div>
                </div>
            </form>
        </x-section>
    </div>
@endsection
