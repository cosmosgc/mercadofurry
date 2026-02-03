@extends('layouts.app')

@section('title', 'Products')

@section('content')
<div class="max-w-7xl mx-auto px-4 space-y-8">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Products</h1>
            <p class="text-sm text-gray-600">
                Manage your marketplace listings
            </p>
        </div>

        <a
            href="{{ route('products.create') }}"
            class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700 transition"
        >
            + New Product
        </a>
    </div>

    {{-- Products Grid --}}
    @if($products->count())
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach($products as $product)
                <div
                    class="group bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition overflow-hidden cursor-pointer"
                    role="link"
                    tabindex="0"
                    onclick="window.location='{{ route('products.show', $product) }}'"
                    onkeydown="if(event.key==='Enter' || event.key===' '){event.preventDefault(); window.location='{{ route('products.show', $product) }}';}"
                >

                    {{-- Image --}}
                    <div class="relative h-48 bg-gray-100 overflow-hidden">
                        <img
                            src="{{ $product->cover_url }}"
                            alt="{{ $product->name }}"
                            class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-300"
                        >

                        @if(!$product->active)
                            <span class="absolute top-2 left-2 rounded-full bg-gray-900/80 px-2 py-0.5 text-xs text-white">
                                Inactive
                            </span>
                        @endif
                    </div>

                    {{-- Content --}}
                    <div class="p-4 space-y-2">
                        <h3 class="font-semibold text-gray-900 line-clamp-1">
                            {{ $product->name }}
                        </h3>

                        <p class="text-sm text-gray-600 line-clamp-2">
                            {{ strip_tags($product->description) ?: 'No description' }}
                        </p>

                        <div class="flex items-center justify-between pt-2">
                            <span class="text-sm font-semibold text-gray-900">
                                R$ {{ number_format($product->price, 2, ',', '.') }}
                            </span>

                            <span class="text-xs text-gray-500">
                                {{ $product->store->name }}
                            </span>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="border-t border-gray-100 px-4 py-3 flex justify-end">
                        <a
                            href="{{ route('products.edit', $product) }}"
                            class="text-sm text-indigo-600 hover:underline"
                        >
                            Edit
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="pt-6">
            {{ $products->links() }}
        </div>
    @else
        {{-- Empty state --}}
        <div class="rounded-xl border border-dashed border-gray-300 p-10 text-center text-gray-500">
            <p class="text-lg font-medium">No products yet</p>
            <p class="text-sm mt-1">
                Start by creating your first product.
            </p>

            <a
                href="{{ route('products.create') }}"
                class="inline-block mt-4 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700 transition"
            >
                Add product
            </a>
        </div>
    @endif

</div>
@endsection
