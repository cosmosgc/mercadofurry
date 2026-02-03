@extends('layouts.app')

@section('title', $store->name)

@section('content')
@php
    $style = $store->customStyle;

    $tokens = $style?->tokens ?? [];

    $cssVars = [
        '--primary'   => $tokens['primary']   ?? '#6366f1',
        '--secondary' => $tokens['secondary'] ?? '#22c55e',
        '--bg'        => $tokens['background'] ?? '#ffffff',
        '--card'      => $tokens['card'] ?? '#f9fafb',
        '--radius'    => $tokens['radius'] ?? '12px',
    ];
@endphp

@if($style)
<style>
/* ============================
   STORE THEME VARIABLES
   ============================ */
#store-root {
@foreach($cssVars as $key => $value)
    {{ $key }}: {{ $value }};
@endforeach
}

/* ============================
   DEFAULT STYLE BINDINGS
   ============================ */
#store-root [data-style="product-card"] {
    background: var(--card);
    border-radius: var(--radius);
}

#store-root [data-style="button"][data-style-variant="primary"] {
    background: var(--primary);
}

#store-root [data-style="button"][data-style-variant="secondary"] {
    background: var(--secondary);
}

/* ============================
   USER CUSTOM CSS
   ============================ */
{!! $style->custom_css ?? '' !!}
</style>
@endif

<div
    id="store-root"
    data-store-id="{{ $store->id }}"
    data-style-id="{{ $store->custom_style_id }}"
    class="max-w-7xl mx-auto px-4 space-y-10"
>
    <div class="max-w-7xl mx-auto px-4 space-y-10">

        {{-- Cover / Header --}}
        <div 
            id="store-cover"
            data-style="store-cover"
            class="relative overflow-hidden rounded-2xl border border-gray-200 bg-gray-100">
            <img
                id="store-cover-image"
                data-style="store-cover-image"
                src="{{ $store->cover_url }}"
                alt="{{ $store->name }}"
                class="h-56 w-full object-cover"
            />


            <div
                id="store-cover-overlay"
                data-style="store-cover-overlay"
                class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"
            ></div>

            <div class="absolute bottom-0 left-0 right-0 p-6">
                <h1
                    id="store-title"
                    data-style="store-title"
                    class="text-3xl font-bold text-white"
                >
                    {{ $store->name }}
                </h1>


                <p
                    id="store-description"
                    data-style="store-description"
                    class="mt-2 max-w-3xl text-sm text-gray-200"
                >
                    {{ $store->description }}
                </p>

                <div
                    id="store-owner"
                    data-style="store-owner"
                    class="mt-4 flex items-center gap-4 text-white"
                >
                    <img
                        src="{{ $store->user?->avatar ? asset($store->user->avatar) : 'data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 width=%2248%22 height=%2248%22><rect width=%22100%25%22 height=%22100%25%22 fill=%22%23e5e7eb%22/><path d=%22M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z%22 fill=%22%236b7280%22/></svg>' }}"
                        alt="{{ $store->user?->name }}"
                        class="w-12 h-12 rounded-full object-cover border border-white/30"
                    />

                    <div>
                        <div class="font-semibold">{{ $store->user?->name ?? 'Unknown' }}</div>

                        @if($store->user?->bio)
                            <div class="text-xs text-white/90">{{ $store->user->bio }}</div>
                        @endif

                        <div class="mt-2 flex items-center gap-2 text-sm">
                            @if($store->contact_email)
                                <a href="mailto:{{ $store->contact_email }}" class="underline">Email</a>
                            @endif

                            @if($store->contact_twitter)
                                <a href="https://twitter.com/{{ ltrim($store->contact_twitter, '@') }}" target="_blank" rel="noopener" class="underline">Twitter</a>
                            @endif

                            @if($store->contact_telegram)
                                <a href="https://t.me/{{ ltrim($store->contact_telegram, '@') }}" target="_blank" rel="noopener" class="underline">Telegram</a>
                            @endif

                            @if($store->contact_discord)
                                <span>Discord: {{ $store->contact_discord }}</span>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- Store Actions --}}
        @auth
            @if(auth()->id() === $store->user_id)
                <div
                    id="store-actions"
                    data-style="store-actions"
                    class="flex justify-end gap-3"
                >

                    <a
                        id="store-action-edit-style"
                        data-style="button"
                        data-style-variant="secondary"
                        href="{{ route('stores.style.edit', $store) }}"
                        class="inline-flex items-center gap-2 rounded-lg bg-gray-700 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-800 transition"
                    >
                        🎨 Edit Store Style
                    </a>


                    <a
                        id="store-action-add-product"
                        data-style="button"
                        data-style-variant="primary"
                        href="{{ route('products.create', ['store' => $store]) }}"
                        class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700 transition"
                    >
                        + Add Product
                    </a>

                </div>
            @endif
        @endauth


        {{-- Products Section --}}
        <section
            id="store-products"
            data-style="products-section"
        >

            <div class="flex items-center justify-between mb-6">
                <h2
                    id="store-products-title"
                    data-style="section-title"
                    class="text-xl font-semibold text-gray-900"
                >
                    Products
                </h2>


                <span class="text-sm text-gray-500">
                    {{ $store->products->count() }} item(s)
                </span>
            </div>

            @if($store->products->count())
                <div
                    id="product-grid"
                    data-style="product-grid"
                    class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3"
                >

                    @foreach($store->products as $product)
                        @include('components.product.card', ['product' => $product])
                    @endforeach
                </div>
            @else

                {{-- Empty state --}}
                <div class="rounded-xl border border-dashed border-gray-300 p-10 text-center text-gray-500">
                    <p class="text-lg font-medium">No products yet</p>
                    <p class="text-sm mt-1">
                        This store hasn’t added any products.
                    </p>

                    @auth
                        @if(auth()->id() === $store->user_id)
                            <a
                                href="{{ route('products.create', ['store' => $store]) }}"
                                class="inline-block mt-4 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700 transition"
                            >
                                Add your first product
                            </a>
                        @endif
                    @endauth
                </div>
            @endif
        </section>

    </div>
</div>
@endsection
