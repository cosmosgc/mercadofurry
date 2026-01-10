@props([
    'name',
    'label',
    'type' => 'color',
    'value' => null,
    'placeholder' => null,
])

<div
    data-style-token="{{ $name }}"
    class="space-y-1"
>
    <label
        for="token-{{ $name }}"
        class="block text-sm font-medium text-gray-700"
    >
        {{ $label }}
    </label>

    <input
        id="token-{{ $name }}"
        type="{{ $type }}"
        name="tokens[{{ $name }}]"
        value="{{ old("tokens.$name", $value) }}"
        placeholder="{{ $placeholder }}"
        class="w-full rounded-lg border-gray-300"
        data-token-input="{{ $name }}"
        oninput="applyPreview()"
    >
</div>
