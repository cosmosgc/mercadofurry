@extends('layouts.app')

@section('title', 'Custom Styles')

@section('content')
<div class="flex justify-between mb-6">
    <h1 class="text-2xl font-bold">Custom Styles</h1>
    <a href="{{ route('custom-styles.create') }}" class="btn-primary">+ New Style</a>
</div>

<div class="grid md:grid-cols-3 gap-4">
@foreach($styles as $style)
    <div class="bg-white p-4 rounded shadow">
        <h2 class="font-semibold">{{ $style->name }}</h2>
        <a href="{{ route('custom-styles.edit',$style) }}" class="text-sm text-blue-600">Edit</a>
    </div>
@endforeach
</div>

<div class="mt-6">{{ $styles->links() }}</div>
@endsection
