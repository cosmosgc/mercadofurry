@extends('layouts.app')

@section('title', 'Edit Product')

@section('content')
<div class="max-w-5xl mx-auto px-4 space-y-8">

    {{-- Header --}}
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Edit Product</h1>
        <p class="text-sm text-gray-600 mt-1">
            Manage product details and gallery
        </p>
    </div>

    {{-- Form --}}
    <form
        method="POST"
        action="{{ route('products.update', $product) }}"
        enctype="multipart/form-data"
        class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 space-y-6"
    >
        @csrf
        @method('PUT')

        {{-- Store --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Store</label>
            <select name="store_id" class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                @foreach($stores as $store)
                    <option value="{{ $store->id }}"
                        @selected($product->store_id === $store->id)>
                        {{ $store->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Name --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Product name</label>
            <input
                name="name"
                value="{{ old('name', $product->name) }}"
                class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
            >
        </div>

        {{-- Price --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Price</label>
            <input
                name="price"
                value="{{ old('price', $product->price) }}"
                class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
            >
        </div>

        {{-- Description --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea
                name="description"
                rows="4"
                class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
            >{{ old('description', $product->description) }}</textarea>
        </div>

        {{-- Image Upload --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Product Images
            </label>

            <input
                id="image-input"
                type="file"
                name="images[]"
                multiple
                accept="image/*"
                class="block w-full text-sm text-gray-500
                       file:mr-4 file:py-2 file:px-4
                       file:rounded-lg file:border-0
                       file:text-sm file:font-semibold
                       file:bg-indigo-50 file:text-indigo-700
                       hover:file:bg-indigo-100"
            >
            <div
                id="image-preview"
                class="mt-4 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4"
            ></div>


            <p class="text-xs text-gray-500 mt-1">
                Drag images to reorder. First image is the cover.
            </p>
        </div>

        {{-- Existing Images --}}
        <div>
            <ul
                id="image-list"
                class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4"
            >
                @foreach($product->images as $image)
                    <li
                        class="relative group cursor-move"
                        data-id="{{ $image->id }}"
                    >
                        <img
                            src="{{ $image->url }}"
                            class="h-32 w-full object-cover rounded-lg border"
                        >

                        <button
                            type="button"
                            data-id="{{ $image->id }}"
                            class="absolute top-1 right-1 hidden group-hover:flex
                                   items-center justify-center rounded-full
                                   bg-red-600 text-white text-xs w-6 h-6"
                        >
                            ✕
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- Actions --}}
        <div class="flex justify-end gap-3 pt-4 border-t">
            <a href="{{ route('products.index') }}" class="text-sm text-gray-600">
                Cancel
            </a>
            <button class="rounded-lg bg-indigo-600 px-5 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                Save changes
            </button>
        </div>
    </form>
</div>
<script>
const input = document.getElementById('image-input');
const preview = document.getElementById('image-preview');

input.addEventListener('change', () => {
    preview.innerHTML = '';

    [...input.files].forEach(file => {
        if (!file.type.startsWith('image/')) return;

        const reader = new FileReader();

        reader.onload = e => {
            const wrapper = document.createElement('div');
            wrapper.className = 'relative';

            wrapper.innerHTML = `
                <img
                    src="${e.target.result}"
                    class="h-32 w-full object-cover rounded-lg border"
                />
                <span
                    class="absolute top-1 left-1 rounded bg-black/60 px-1.5 py-0.5 text-xs text-white"
                >
                    New
                </span>
            `;

            preview.appendChild(wrapper);
        };

        reader.readAsDataURL(file);
    });
});
</script>

{{-- SortableJS --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
<script>
    window.productImageRoutes = {
        reorder: "{{ route('api.products.images.reorder', $product) }}",
        delete: "{{ route('api.products.images.destroy', ['image' => '__ID__']) }}",
        csrf: "{{ csrf_token() }}"
    };
</script>

<script>
const list = document.getElementById('image-list');

new Sortable(list, {
    animation: 150,
    onEnd: () => {
        const order = [...list.children].map((el, index) => ({
            id: el.dataset.id,
            position: index
        }));

        fetch(window.productImageRoutes.reorder, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': window.productImageRoutes.csrf,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ order })
        });
    }
});

// Delete image
list.addEventListener('click', e => {
    if (e.target.tagName !== 'BUTTON') return;

    const id = e.target.dataset.id;
    const url = window.productImageRoutes.delete.replace('__ID__', id);

    fetch(url, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': window.productImageRoutes.csrf,
            'Accept': 'application/json'
        }
    }).then(() => e.target.closest('li').remove());
});
</script>
@endsection
