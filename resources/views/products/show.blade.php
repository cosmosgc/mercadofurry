@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8 space-y-10">

    {{-- Breadcrumb --}}
    <nav class="text-sm text-gray-500">
        <a href="{{ route('stores.show', $product->store) }}" class="hover:underline">
            {{ $product->store->name }}
        </a>
        <span class="mx-2">/</span>
        <span class="text-gray-700">{{ $product->name }}</span>
    </nav>

    {{-- Main layout --}}
    <div class="grid gap-10 lg:grid-cols-2">

        {{-- Images --}}
        <div class="space-y-4">
            {{-- Cover --}}
            <div class="aspect-square bg-gray-100 rounded-2xl overflow-hidden border">
                <img
                    src="{{ $product->cover_url }}"
                    alt="{{ $product->name }}"
                    class="h-full w-full object-cover"
                >
            </div>

            {{-- Thumbnails --}}
            @if($product->images->count() > 1)
                <div class="grid grid-cols-4 gap-3">
                    @foreach($product->images as $image)
                        <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden border">
                            <img
                                src="{{ $image->url }}"
                                alt=""
                                class="h-full w-full object-cover"
                            >
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Product info --}}
        <div class="space-y-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">
                    {{ $product->name }}
                </h1>

                <p class="mt-2 text-sm text-gray-600">
                    Sold by
                    <a
                        href="{{ route('stores.show', $product->store) }}"
                        class="font-medium text-indigo-600 hover:underline"
                    >
                        {{ $product->store->name }}
                    </a>
                </p>
            </div>

            {{-- Price --}}
            <div class="text-3xl font-bold text-gray-900">
                R$ {{ number_format($product->price, 2, ',', '.') }}
            </div>

            {{-- Description --}}
            <div class="prose prose-sm max-w-none text-gray-700">
                {!! $product->description !!}
            </div>

            {{-- Meta --}}
            <div class="flex items-center gap-4 text-sm text-gray-500">
                <span>
                    Status:
                    <span class="font-medium text-gray-700">
                        {{ $product->active ? 'Available' : 'Unavailable' }}
                    </span>
                </span>
            </div>

            {{-- Actions --}}
            <div class="pt-4 border-t space-y-3">
                @php
                    $telegram = $product->store->contact_telegram ?? $product->store->user?->telegram;
                    $email = $product->store->contact_email ?? $product->store->user?->email;

                    $priceText = 'R$ ' . number_format($product->price, 2, ',', '.');
                    $message = "Olá, tenho interesse no produto '{$product->name}' da {$product->store->name} anunciado por {$priceText}. Ainda está disponível?";
                    $encoded = rawurlencode($message);
                @endphp

                <div class="flex gap-3">
                    @if($telegram)
                        <a
                            href="https://t.me/{{ ltrim($telegram, '@') }}?text={{ $encoded }}"
                            target="_blank" rel="noopener"
                            class="inline-flex items-center gap-2 flex-1 justify-center rounded-lg bg-telegram px-4 py-3 text-sm font-semibold text-white hover:opacity-90 transition"
                        >
                            📩 Message via Telegram
                        </a>
                    @endif

                    @if($email)
                        <a
                            href="mailto:{{ $email }}?subject={{ rawurlencode('Enquiry about ' . $product->name) }}&body={{ $encoded }}"
                            class="inline-flex items-center gap-2 flex-1 justify-center rounded-lg bg-indigo-600 px-4 py-3 text-sm font-semibold text-white hover:bg-indigo-700 transition"
                        >
                            ✉️ Email the Seller
                        </a>
                    @endif

                    @if(!$telegram && !$email)
                        <button disabled class="w-full rounded-lg bg-gray-300 px-4 py-3 text-sm font-semibold text-gray-600 cursor-not-allowed">
                            Contact seller (not available)
                        </button>
                    @endif
                </div>

                @auth
                    @if(auth()->id() === $product->store->user_id)
                        <div class="mt-3">
                            <a
                                href="{{ route('products.edit', $product) }}"
                                class="inline-flex items-center gap-2 rounded-lg border border-gray-200 px-4 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition"
                            >
                                ✏️ Edit product
                            </a>
                        </div>
                    @endif
                @endauth
            </div>
        </div>
    </div>

    {{-- Related products --}}
    @if($product->store->products->count() > 1)
        <section class="pt-10 border-t">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">
                More from {{ $product->store->name }}
            </h2>

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach($product->store->products->where('id', '!=', $product->id)->take(4) as $related)
                    @include('components.product.card', ['product' => $related])
                @endforeach
            </div>
        </section>
    @endif

</div>
@endsection
