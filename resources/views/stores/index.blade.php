@extends('layouts.app')

@section('title', 'Stores')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Stores</h1>
            <p class="text-sm text-gray-600">
                Manage your storefronts and customize their appearance
            </p>
        </div>

        <a
            href="{{ route('stores.create') }}"
            class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700 transition"
        >
            + New Store
        </a>
    </div>

    {{-- Stores Grid --}}
    @if($stores->count())
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($stores as $store)
                @include('components.store.card', ['store' => $store])
            @endforeach
        </div>

    @else
        <div class="rounded-xl border border-dashed border-gray-300 p-10 text-center text-gray-500">
            <p class="text-lg font-medium">No stores yet</p>
            <p class="text-sm mt-1">Create your first store to get started.</p>
        </div>
    @endif

    {{-- Pagination --}}
    <div class="mt-8">
        {{ $stores->links() }}
    </div>
</div>
@endsection
