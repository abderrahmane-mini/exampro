@props(['title', 'subtitle'])

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">{{ $title }}</h1>
    @if($subtitle)
        <p class="text-sm text-gray-500">{{ $subtitle }}</p>
    @endif
</div>
