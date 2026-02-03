@props(['product'])

<a
    data-style="product-card"
    data-product-id="{{ $product->id }}"
    href="{{ route('products.show', $product) }}"
    class="group block bg-white rounded-xl border border-gray-200 shadow-sm
           hover:shadow-md transition overflow-hidden focus:outline-none
           focus:ring-2 focus:ring-indigo-500"
>
    {{-- Image --}}
    <div class="relative h-44 bg-gray-100 overflow-hidden">
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
        <h3 class="font-semibold text-gray-900 group-hover:text-indigo-600 transition line-clamp-1">
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
                View →
            </span>
        </div>
    </div>
</a>
