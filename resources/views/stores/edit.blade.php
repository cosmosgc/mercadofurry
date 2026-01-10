@extends('layouts.app')

@section('title', isset($store) ? 'Edit Store' : 'New Store')

@section('content')
<h1 class="text-2xl font-bold mb-6">
    {{ isset($store) ? 'Edit Store' : 'Create Store' }}
</h1>

<form method="POST"
      action="{{ isset($store) ? route('stores.update',$store) : route('stores.store') }}"
      class="space-y-4 bg-white p-6 rounded shadow">
    @csrf
    @isset($store) @method('PUT') @endisset

    <input name="name" placeholder="Store name"
           value="{{ old('name', $store->name ?? '') }}"
           class="input">

    <textarea name="description" placeholder="Description"
              class="input">{{ old('description', $store->description ?? '') }}</textarea>

    <select name="custom_style_id" class="input">
        <option value="">Default Style</option>
        @foreach($styles as $style)
            <option value="{{ $style->id }}"
                @selected(old('custom_style_id', $store->custom_style_id ?? '') == $style->id)>
                {{ $style->name }}
            </option>
        @endforeach
    </select>

    <button class="btn-primary">Save</button>
</form>
@endsection
