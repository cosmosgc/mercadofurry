<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Store;
use App\Models\CustomStyle;
use App\Models\ProductImage;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('store', 'customStyle')->latest()->paginate(12);
        return view('products.index', compact('products'));
    }

    public function create(Request $request)
    {
        $requestedStoreId = $request->query('store');
        $selectedStore = null;

        if (is_numeric($requestedStoreId)) {
            $selectedStore = Store::find($requestedStoreId);
        }

        $stores = $selectedStore
            ? collect([$selectedStore])
            : Store::where('user_id', auth()->id())->get();

        return view('products.create', [
            'stores' => $stores,
            'styles' => CustomStyle::all(),
            'selectedStore' => $selectedStore,
            'categories' => Category::with('parent')->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'store_id'        => 'required|exists:stores,id',
            'category_id'     => 'nullable|exists:categories,id',
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
        $product->load('store', 'customStyle', 'category.parent');

        return view('products.show', compact('product'));
    }


    public function edit(Product $product)
    {
        $stores = Store::where('user_id', auth()->id())->get();
        return view('products.edit', [
            'product' => $product,
            'styles' => CustomStyle::all(),
            'stores' => $stores,
            'categories' => Category::with('parent')->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Product $product)
    {
        // Security: ensure ownership
        abort_if($product->store->user_id !== auth()->id(), 403);

        $data = $request->validate([
            'store_id'    => 'required|exists:stores,id',
            'category_id' => 'nullable|exists:categories,id',
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'nullable|numeric|min:0',
            'images.*'    => 'nullable|image|max:4096',
        ]);

        // Update product fields
        $product->update($data);

        // Handle image uploads
        if ($request->hasFile('images')) {
            $destination = public_path('uploads/products');

            // Ensure folder exists
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            // Get next position index
            $position = $product->images()->max('position') ?? 0;

            foreach ($request->file('images') as $file) {
                $filename = uniqid('product_') . '.' . $file->getClientOriginalExtension();

                $file->move($destination, $filename);

                ProductImage::create([
                    'product_id' => $product->id,
                    'path'       => 'uploads/products/' . $filename,
                    'position'   => ++$position,
                ]);
            }
        }

        return redirect()
            ->route('products.edit', $product)
            ->with('success', 'Product updated successfully');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted');
    }
}
