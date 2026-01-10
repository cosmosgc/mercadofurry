@extends('layouts.app')

@section('title', 'Products')

@section('content')
<div class="flex justify-between mb-6">
    <h1 class="text-2xl font-bold">Products</h1>
    <a href="{{ route('products.create') }}" class="btn-primary">+ New Product</a>
</div>

<table class="w-full bg-white shadow rounded">
<tr class="border-b text-left text-sm">
    <th class="p-3">Name</th>
    <th>Store</th>
    <th>Price</th>
    <th></th>
</tr>
@foreach($products as $product)
<tr class="border-b text-sm">
    <td class="p-3">{{ $product->name }}</td>
    <td>{{ $product->store->name }}</td>
    <td>R$ {{ $product->price }}</td>
    <td class="text-right pr-3">
        <a href="{{ route('products.edit',$product) }}" class="text-yellow-600">Edit</a>
    </td>
</tr>
@endforeach
</table>

<div class="mt-6">{{ $products->links() }}</div>
@endsection
