@props(['store'])

<div class="group bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition overflow-hidden">
    {{-- Header --}}
    <div class="p-5">
        <h2 class="text-lg font-semibold text-gray-900 group-hover:text-indigo-600 transition">
            {{ $store->name }}
        </h2>
        <img
            src="{{ $store->cover_url }}"
            alt="{{ $store->name }}"
            class="h-36 w-full object-cover"
        />


        @if($store->description)
            <p class="mt-2 text-sm text-gray-600 line-clamp-3">
                {{ $store->description }}
            </p>
        @else
            <p class="mt-2 text-sm text-gray-400 italic">
                No description provided
            </p>
        @endif
    </div>

    {{-- Divider --}}
    <div class="border-t border-gray-100"></div>

    {{-- Actions --}}
    <div class="flex items-center justify-between px-5 py-3 text-sm bg-gray-50">
        <a
            href="{{ route('stores.show', $store) }}"
            class="text-indigo-600 font-medium hover:underline"
        >
            View store →
        </a>

        <a
            href="{{ route('stores.edit', $store) }}"
            class="text-gray-500 hover:text-yellow-600 transition"
        >
            Edit
        </a>
    </div>
</div>
