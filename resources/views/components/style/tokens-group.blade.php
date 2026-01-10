@props([
    'title' => 'Design Tokens',
    'id' => 'style-tokens',
    'tokens' => null,
])

<div
    id="{{ $id }}"
    data-style-editor="tokens-group"
    class="space-y-4"
>
    <h2 class="text-sm font-semibold text-gray-700 uppercase tracking-wide">
        {{ $title }}
    </h2>

    <div
        class="grid grid-cols-1 md:grid-cols-2 gap-4"
        data-style-editor="tokens-grid"
    >
        {!! $tokens !!}
    </div>
</div>
