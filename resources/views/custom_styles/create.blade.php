@extends('layouts.app')

@section('title', 'Create Style')

@section('content')
<div
    id="style-editor-root"
    data-style-editor="root"
    class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-8"
>

    {{-- LEFT: FORM --}}
    <form
        id="style-editor-form"
        data-style-editor="form"
        method="POST"
        action="{{ route('custom-styles.store') }}"
        class="bg-white p-6 rounded-xl shadow space-y-6"
    >
        @csrf

        <h1
            id="style-editor-title"
            class="text-xl font-bold"
        >
            🎨 Create Custom Style
        </h1>

        {{-- Name --}}
        <div data-style-editor="style-name">
            <label class="block text-sm font-medium mb-1">Style name</label>
            <input
                id="style-name"
                name="name"
                class="w-full rounded-lg border-gray-300"
                placeholder="Neon Feral Theme"
                required
            >
        </div>

        {{-- TOKENS --}}
        @include('components.style.tokens-group', [
            'title' => 'Colors & Layout',
            'id' => 'style-tokens-main'
        ])

            @include('components.style.token-input', [
                'name' => 'primary',
                'label' => 'Primary color',
                'type' => 'color',
                'value' => '#6366f1'
            ])

            @include('components.style.token-input', [
                'name' => 'secondary',
                'label' => 'Secondary color',
                'type' => 'color',
                'value' => '#22c55e'
            ])

            @include('components.style.token-input', [
                'name' => 'background',
                'label' => 'Background color',
                'type' => 'color',
                'value' => '#ffffff'
            ])

            @include('components.style.token-input', [
                'name' => 'card',
                'label' => 'Card background',
                'type' => 'color',
                'value' => '#f9fafb'
            ])

            @include('components.style.token-input', [
                'name' => 'radius',
                'label' => 'Border radius',
                'type' => 'text',
                'placeholder' => '12px',
                'value' => '12px'
            ])

        @endinclude

        {{-- Custom CSS --}}
        <div data-style-editor="custom-css">
            <label class="block text-sm font-medium mb-1">
                Custom CSS (optional)
            </label>

            <textarea
                id="custom-css"
                name="custom_css"
                class="w-full h-40 rounded-lg border-gray-300 font-mono text-sm"
                placeholder="#store-root { border: 3px solid hotpink; }"
                oninput="applyPreview()"
            ></textarea>
        </div>

        {{-- Save --}}
        <div class="flex justify-end">
            <button
                id="style-save"
                class="rounded-lg bg-indigo-600 px-5 py-2 text-white font-semibold hover:bg-indigo-700"
            >
                💾 Create Style
            </button>
        </div>
    </form>

    {{-- RIGHT: PREVIEW --}}
    <div
        id="style-preview-panel"
        data-style-editor="preview-panel"
        class="bg-gray-100 rounded-xl p-6"
    >
        <h2 class="text-lg font-bold mb-4">👁 Live Preview</h2>

        <style id="stylePreview"></style>

        <div
            id="style-preview-root"
            data-style="store-root"
            class="p-6 rounded-xl transition"
            style="background: var(--bg)"
        >
            <div
                data-style="product-card"
                class="p-4 rounded-xl shadow"
                style="background: var(--card); border-radius: var(--radius)"
            >
                <h3
                    data-style="product-title"
                    class="text-lg font-bold mb-2"
                    style="color: var(--primary)"
                >
                    Product Card
                </h3>

                <p class="text-sm text-gray-600 mb-4">
                    Preview of store / product cards
                </p>

                <button
                    data-style="button"
                    data-style-variant="primary"
                    class="px-4 py-2 text-white font-semibold rounded"
                    style="background: var(--primary); border-radius: var(--radius)"
                >
                    Action
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Preview Script --}}
<script>
function applyPreview() {
    const form = document.getElementById('style-editor-form');
    const data = new FormData(form);

    let css = ':root {';
    css += `--primary: ${data.get('tokens[primary]') || '#6366f1'};`;
    css += `--secondary: ${data.get('tokens[secondary]') || '#22c55e'};`;
    css += `--bg: ${data.get('tokens[background]') || '#ffffff'};`;
    css += `--card: ${data.get('tokens[card]') || '#f9fafb'};`;
    css += `--radius: ${data.get('tokens[radius]') || '12px'};`;
    css += '}';

    css += data.get('custom_css') || '';

    document.getElementById('stylePreview').innerHTML = css;
}

applyPreview();
</script>
@endsection
