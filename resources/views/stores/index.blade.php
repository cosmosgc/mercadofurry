@extends('layouts.app')

@section('title', 'Stores')

@section('content')
<div class="flex justify-between mb-6">
    <h1 class="text-2xl font-bold">Stores</h1>
    <a href="{{ route('stores.create') }}" class="btn-primary">+ New Store</a>
</div>

<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
@foreach($stores as $store)
    <div class="bg-white p-5 rounded shadow">
        <h2 class="font-semibold text-lg">{{ $store->name }}</h2>
        <p class="text-sm text-gray-600">{{ $store->description }}</p>

        <div class="mt-4 flex justify-between text-sm">
            <a href="{{ route('stores.show', $store) }}" class="text-blue-600">View</a>
            <a href="{{ route('stores.edit', $store) }}" class="text-yellow-600">Edit</a>
        </div>
    </div>
@endforeach
</div>

<div class="mt-6">{{ $stores->links() }}</div>
@endsection
