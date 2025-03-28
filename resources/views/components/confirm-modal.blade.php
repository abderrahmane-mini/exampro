@props(['id', 'title' => 'Confirmation', 'message' => 'Êtes-vous sûr ?'])

<div x-data="{ open: false }">
    <button @click="open = true" {{ $attributes }}>
        {{ $slot }}
    </button>

    <div x-show="open" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded shadow-lg w-full max-w-md">
            <h2 class="text-lg font-bold mb-4">{{ $title }}</h2>
            <p class="mb-6">{{ $message }}</p>

            <div class="flex justify-end space-x-4">
                <button @click="open = false" class="px-4 py-2 bg-gray-300 rounded">Annuler</button>
                <form method="POST" action="{{ route($id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded">Confirmer</button>
                </form>
            </div>
        </div>
    </div>
</div>
