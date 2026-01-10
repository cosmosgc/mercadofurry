@extends('layouts.app')

@section('title', $store->name)

@section('content')
<h1 class="text-2xl font-bold mb-2">{{ $store->name }}</h1>
<p class="text-gray-600 mb-6">{{ $store->description }}</p>

<h2 class="font-semibold mb-3">Products</h2>
<div class="grid md:grid-cols-3 gap-4">
@foreach($store->products as $product)
    <div class="bg-white p-4 rounded shadow">
        <p class="font-semibold">{{ $product->name }}</p>
        <p class="text-sm text-gray-600">R$ {{ $product->price }}</p>
    </div>
@endforeach
</div>
@endsection
