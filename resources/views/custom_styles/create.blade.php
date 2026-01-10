@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-6">
    {{ isset($customStyle) ? 'Edit Style' : 'Create Style' }}
</h1>

<form method="POST"
      action="{{ isset($customStyle) ? route('custom-styles.update',$customStyle) : route('custom-styles.store') }}"
      class="bg-white p-6 rounded shadow space-y-4">
    @csrf
    @isset($customStyle) @method('PUT') @endisset

    <input name="name" class="input" placeholder="Style name"
           value="{{ old('name', $customStyle->name ?? '') }}">

    <textarea name="styles" class="input h-40"
              placeholder='{"primary":"#ff00ff"}'>{{ old('styles', $customStyle->styles ?? '') }}</textarea>

    <button class="btn-primary">Save</button>
</form>
@endsection
