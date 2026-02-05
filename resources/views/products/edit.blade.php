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

        {{-- Category --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
            <select name="category_id" class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">No category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected((int)old('category_id', $product->category_id) === $category->id)>
                        {{ $category->parent ? $category->parent->name . ' > ' . $category->name : $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Price --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Price</label>
            <div class="relative">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500 text-sm">
                    R$
                </span>
                <input
                    type="number"
                    step="0.01"
                    min="0"
                    name="price"
                    value="{{ old('price', $product->price) }}"
                    class="w-full rounded-lg border-gray-300 pl-10 focus:ring-indigo-500 focus:border-indigo-500"
                >
            </div>
        </div>

        {{-- Description --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
            <div class="rounded-lg border border-gray-300 bg-white">
                <div id="description-toolbar" class="border-b border-gray-200"></div>
                <div id="description-editor" class="min-h-[180px]"></div>
            </div>
            <input type="hidden" id="description-input" name="description" value="">
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
        <div class="flex items-center justify-end gap-3 pt-4 border-t">
            <a href="{{ route('products.index') }}" class="text-sm text-gray-600">
                Cancel
            </a>
            <button class="rounded-lg bg-indigo-600 px-5 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                Save changes
            </button>
        </div>
    </form>
    <div class="flex items-center justify-between">
        <form
            method="POST"
            action="{{ route('products.destroy', $product) }}"
            onsubmit="return confirm('Delete this product? This cannot be undone.')"
        >
            @csrf
            @method('DELETE')
            <button class="rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700">
                Delete
            </button>
        </form>
    </div>
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

<link href="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.snow.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.min.js"></script>
<script>
const descriptionInput = document.getElementById('description-input');
const descriptionEditor = document.getElementById('description-editor');
const descriptionToolbar = document.getElementById('description-toolbar');
const descriptionForm = descriptionInput?.closest('form');
const initialDescription = @json(old('description', $product->description));

if (descriptionEditor && descriptionInput) {
    const quill = new Quill(descriptionEditor, {
        theme: 'snow',
        modules: {
            toolbar: {
                container: [
                    ['bold', 'italic', 'underline'],
                    [{ list: 'ordered' }, { list: 'bullet' }],
                    ['link'],
                    ['clean']
                ]
            }
        }
    });

    if (initialDescription) {
        quill.clipboard.dangerouslyPasteHTML(initialDescription);
    }

    descriptionToolbar.appendChild(
        descriptionEditor.parentElement.querySelector('.ql-toolbar')
    );

    quill.on('text-change', () => {
        descriptionInput.value = quill.root.innerHTML;
    });

    descriptionForm?.addEventListener('submit', () => {
        descriptionInput.value = quill.root.innerHTML;
    });
}
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
