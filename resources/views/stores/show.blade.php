@extends('layouts.app')

@section('title', $store->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 space-y-10">

    {{-- Cover / Header --}}
    <div class="relative overflow-hidden rounded-2xl border border-gray-200 bg-gray-100">
        <img
            src="{{ $store->cover_url }}"
            alt="{{ $store->name }}"
            class="h-56 w-full object-cover"
        >

        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>

        <div class="absolute bottom-0 left-0 right-0 p-6">
            <h1 class="text-3xl font-bold text-white">
                {{ $store->name }}
            </h1>

            @if($store->description)
                <p class="mt-2 max-w-3xl text-sm text-gray-200">
                    {{ $store->description }}
                </p>
            @endif
        </div>
    </div>

    {{-- Store Actions --}}
    @auth
        @if(auth()->id() === $store->user_id)
            <div class="flex justify-end">
                <a
                    href="{{ route('products.create', ['store' => $store]) }}"
                    class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700 transition"
                >
                    + Add Product
                </a>
            </div>
        @endif
    @endauth

    {{-- Products Section --}}
    <section>
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-semibold text-gray-900">
                Products
            </h2>

            <span class="text-sm text-gray-500">
                {{ $store->products->count() }} item(s)
            </span>
        </div>

        @if($store->products->count())
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($store->products as $product)
                    <div class="group bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition overflow-hidden">
                        {{-- Product image placeholder --}}
                        <div class="h-40 bg-gray-100 flex items-center justify-center text-gray-400 text-sm">
                            No image
                        </div>

                        <div class="p-4 space-y-2">
                            <h3 class="font-semibold text-gray-900 group-hover:text-indigo-600 transition">
                                {{ $product->name }}
                            </h3>

                            <p class="text-sm text-gray-600 line-clamp-2">
                                {{ $product->description ?? 'No description' }}
                            </p>

                            <div class="flex items-center justify-between pt-2">
                                <span class="text-sm font-semibold text-gray-900">
                                    R$ {{ number_format($product->price, 2, ',', '.') }}
                                </span>

                                <a
                                    href="{{ route('products.show', $product) }}"
                                    class="text-sm text-indigo-600 hover:underline"
                                >
                                    View →
                                </a>
                            </div>
                        </div>
                    </div>
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
@endsection
