@extends('layouts.app')

@section('title', 'Create Product')

@section('content')
<div class="max-w-5xl mx-auto px-4 space-y-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Create Product</h1>
        <p class="text-sm text-gray-600 mt-1">
            Add a new product to your store with details and pricing
        </p>
    </div>

    <form
        method="POST"
        action="{{ route('products.store') }}"
        class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 space-y-6"
    >
        @csrf

        {{-- Store --}}
        @if($selectedStore)
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Store</label>
                <div class="flex items-center justify-between rounded-lg border border-gray-200 bg-gray-50 px-4 py-3">
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ $selectedStore->name }}</p>
                        <p class="text-xs text-gray-500">Selected from the create link</p>
                    </div>
                    <span class="text-xs text-gray-500">ID {{ $selectedStore->id }}</span>
                </div>
                <input
                    type="hidden"
                    name="store_id"
                    value="{{ old('store_id', $selectedStore->id) }}"
                >
            </div>
        @else
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Store</label>
                <select
                    name="store_id"
                    class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
                >
                    @foreach($stores as $store)
                        <option value="{{ $store->id }}"
                            @selected(old('store_id') == $store->id)>
                            {{ $store->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endif

        {{-- Name --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Product name</label>
            <input
                name="name"
                value="{{ old('name') }}"
                class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
                placeholder="E.g. Plush Fox Hoodie"
            >
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
                    value="{{ old('price') }}"
                    class="w-full rounded-lg border-gray-300 pl-10 focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="0,00"
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

        {{-- Actions --}}
        <div class="flex items-center justify-end gap-3 pt-4 border-t">
            <a href="{{ route('products.index') }}" class="text-sm text-gray-600">
                Cancel
            </a>
            <button class="rounded-lg bg-indigo-600 px-5 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                Create product
            </button>
        </div>
    </form>
</div>

<link href="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.snow.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.min.js"></script>
<script>
const descriptionInput = document.getElementById('description-input');
const descriptionEditor = document.getElementById('description-editor');
const descriptionToolbar = document.getElementById('description-toolbar');
const descriptionForm = descriptionInput?.closest('form');
const initialDescription = @json(old('description', ''));

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
@endsection
