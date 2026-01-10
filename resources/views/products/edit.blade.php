@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-6">
    {{ isset($product) ? 'Edit Product' : 'Create Product' }}
</h1>

<form method="POST"
      action="{{ isset($product) ? route('products.update',$product) : route('products.store') }}"
      class="bg-white p-6 rounded shadow space-y-4">
    @csrf
    @isset($product) @method('PUT') @endisset

    <select name="store_id" class="input">
        @foreach($stores as $store)
            <option value="{{ $store->id }}"
                @selected(old('store_id', $product->store_id ?? '') == $store->id)>
                {{ $store->name }}
            </option>
        @endforeach
    </select>

    <input name="name" class="input" placeholder="Product name"
           value="{{ old('name', $product->name ?? '') }}">

    <input name="price" class="input" placeholder="Price"
           value="{{ old('price', $product->price ?? '') }}">

    <textarea name="description" class="input"
              placeholder="Description">{{ old('description', $product->description ?? '') }}</textarea>

    <button class="btn-primary">Save</button>
</form>
@endsection
