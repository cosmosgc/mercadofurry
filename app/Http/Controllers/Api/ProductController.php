<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return response()->json(
            Product::with('store', 'customStyle')->latest()->get()
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'store_id'        => 'required|exists:stores,id',
            'custom_style_id' => 'nullable|exists:custom_styles,id',
            'name'            => 'required|string|max:255',
            'description'     => 'nullable|string',
            'price'           => 'nullable|numeric|min:0',
            'active'          => 'boolean',
        ]);

        $product = Product::create($data);

        return response()->json($product, 201);
    }

    public function show(Product $product)
    {
        return response()->json(
            $product->load('store', 'customStyle')
        );
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'custom_style_id' => 'nullable|exists:custom_styles,id',
            'name'            => 'sometimes|string|max:255',
            'description'     => 'nullable|string',
            'price'           => 'nullable|numeric|min:0',
            'active'          => 'boolean',
        ]);

        $product->update($data);

        return response()->json($product);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json(['message' => 'Product deleted']);
    }
}
