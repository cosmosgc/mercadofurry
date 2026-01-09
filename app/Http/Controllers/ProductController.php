<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Store;
use App\Models\CustomStyle;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('store', 'customStyle')->latest()->paginate(12);
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create', [
            'stores' => Store::all(),
            'styles' => CustomStyle::all(),
        ]);
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

        Product::create($data);

        return redirect()->route('products.index')
            ->with('success', 'Product created');
    }

    public function show(Product $product)
    {
        $product->load('store', 'customStyle');
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('products.edit', [
            'product' => $product,
            'styles' => CustomStyle::all(),
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'custom_style_id' => 'nullable|exists:custom_styles,id',
            'name'            => 'required|string|max:255',
            'description'     => 'nullable|string',
            'price'           => 'nullable|numeric|min:0',
            'active'          => 'boolean',
        ]);

        $product->update($data);

        return redirect()->route('products.show', $product)
            ->with('success', 'Product updated');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted');
    }
}
