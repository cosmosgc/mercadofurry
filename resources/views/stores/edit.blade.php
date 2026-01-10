@extends('layouts.app')

@section('title', isset($store) ? 'Edit Store' : 'New Store')

@section('content')
<div class="max-w-3xl mx-auto">
    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">
            {{ isset($store) ? 'Edit Store' : 'Create Store' }}
        </h1>
        <p class="text-sm text-gray-600 mt-1">
            Customize your storefront appearance and details
        </p>
    </div>

    {{-- Form --}}
    <form
        method="POST"
        action="{{ isset($store) ? route('stores.update', $store) : route('stores.store') }}"
        enctype="multipart/form-data"
        class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 space-y-6"
    >
        @csrf
        @isset($store) @method('PUT') @endisset

        {{-- Store Name --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Store name
            </label>
            <input
                name="name"
                value="{{ old('name', $store->name ?? '') }}"
                required
                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                placeholder="My awesome store"
            >
            @error('name')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Description --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Description
            </label>
            <textarea
                name="description"
                rows="4"
                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                placeholder="Tell people what your store is about"
            >{{ old('description', $store->description ?? '') }}</textarea>
        </div>

        {{-- Cover Image --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Store cover image
            </label>

            @isset($store)
                <div class="mb-3">
                    <img
                        src="{{ $store->cover_url }}"
                        alt="Current cover"
                        class="h-40 w-full object-cover rounded-xl border"
                    >
                </div>
            @endisset

            <input
                type="file"
                name="cover"
                accept="image/*"
                class="block w-full text-sm text-gray-500
                       file:mr-4 file:py-2 file:px-4
                       file:rounded-lg file:border-0
                       file:text-sm file:font-semibold
                       file:bg-indigo-50 file:text-indigo-700
                       hover:file:bg-indigo-100"
            >
            <p class="text-xs text-gray-500 mt-1">
                Recommended ratio: 3:1 (JPG, PNG, WebP)
            </p>
        </div>

        {{-- Custom Style --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Visual style
            </label>
            <select
                name="custom_style_id"
                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
            >
                <option value="">Default style</option>
                @foreach($styles as $style)
                    <option value="{{ $style->id }}"
                        @selected(old('custom_style_id', $store->custom_style_id ?? '') == $style->id)
                    >
                        {{ $style->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-end gap-3 pt-4 border-t">
            <a
                href="{{ route('stores.index') }}"
                class="text-sm text-gray-600 hover:text-gray-900"
            >
                Cancel
            </a>

            <button
                type="submit"
                class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-5 py-2 text-sm font-semibold text-white hover:bg-indigo-700 transition"
            >
                {{ isset($store) ? 'Save changes' : 'Create store' }}
            </button>
        </div>
    </form>
</div>
@endsection
