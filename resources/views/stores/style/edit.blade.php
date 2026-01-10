@extends('layouts.app')

@section('title', 'Edit Store Style')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-xl shadow p-6">
    <h1 class="text-xl font-bold mb-6">
        🎨 Style settings — {{ $store->name }}
    </h1>

    <form method="POST" action="{{ route('stores.style.update', $store) }}">
        @csrf
        @method('PUT')

        {{-- Style ID --}}
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">
                Custom Style ID
            </label>

            <input
                type="number"
                name="custom_style_id"
                value="{{ old('custom_style_id', $store->custom_style_id) }}"
                class="w-full rounded-lg border-gray-300"
                placeholder="Leave empty to use default"
            >

            @if($store->customStyle)
                <p class="mt-1 text-sm text-gray-500">
                    Current style:
                    <span class="font-semibold">
                        {{ $store->customStyle->name }}
                    </span>

                    @if($store->customStyle->user_id !== auth()->id())
                        <span class="ml-2 rounded bg-yellow-100 px-2 py-0.5 text-xs text-yellow-800">
                            external style
                        </span>
                    @endif
                </p>

            @else
                <p class="mt-1 text-sm text-gray-400">
                    Using default style
                </p>
            @endif
        </div>

        {{-- Actions --}}
        <div class="flex flex-wrap gap-3 justify-between mt-6">
            <div class="flex gap-3">
                @if($store->customStyle && $store->customStyle->user_id === auth()->id())
                    <a
                        href="{{ route('custom-styles.edit', $store->custom_style_id) }}"
                        class="inline-flex items-center gap-2 rounded-lg bg-gray-700 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-800 transition"
                    >
                        ✏️ Edit Style
                    </a>
                @endif


                <a
                    href="{{ route('custom-styles.create') }}"
                    class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700 transition"
                >
                    ➕ Create New Style
                </a>
            </div>

            <button
                class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-5 py-2 text-sm font-semibold text-white hover:bg-indigo-700 transition"
            >
                💾 Save to Store
            </button>
        </div>
    </form>
</div>
@endsection
