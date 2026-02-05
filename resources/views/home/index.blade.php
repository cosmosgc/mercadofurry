@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">
    <h1 class="text-3xl font-bold text-gray-800 mb-8 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-indigo-600">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v3.75m9-.75V12a9 9 0 0 1-9 9H3a9 9 0 0 1-9-9V6.25c0-.69.32-1.25.85-1.25h.85M12 6v3.75m9-.75V12a9 9 0 0 1-9 9H3a9 9 0 0 1-9-9V6.25c0-.69.32-1.25.85-1.25h.85" />
        </svg>
        Mais recentes
    </h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($products as $product)
            <div class="bg-white rounded-xl shadow-sm hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-indigo-100">
                <div class="relative h-48 overflow-hidden">
                    <img 
                        src="{{ (is_null($product->coverImage) ? 'https://via.placeholder.com/300x200/f5f7fa/4a5568?text=No+Image' : $product->coverImage->path) }}" 
                        alt="{{ $product->name }}" 
                        class="w-full h-full object-cover transition-transform duration-300 hover:scale-105"
                    >
                    @if (is_null($product->coverImage))
                        <div class="absolute inset-0 bg-gradient-to-t from-indigo-500/20 to-transparent flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-12 h-12 text-indigo-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                    @endif
                </div>
                
                <div class="p-5">
                    <h2 class="text-xl font-bold text-gray-800 mb-2">{{ $product->name }}</h2>
                    <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ $product->description }}</p>
                    <div class="flex items-center text-sm text-gray-500">
                        <span class="font-semibold text-indigo-600">€{{ number_format($product->price, 2) }}</span>
                        <span class="ml-2 text-gray-400">|</span>
                        <span class="text-gray-500">Disponível</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
