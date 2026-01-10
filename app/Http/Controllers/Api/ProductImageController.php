<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{
    public function reorder(Request $request, Product $product)
    {
        foreach ($request->order as $item) {
            ProductImage::where('id', $item['id'])
                ->where('product_id', $product->id)
                ->update(['position' => $item['position']]);
        }

        return response()->json(['status' => 'ok']);
    }

    public function destroy(ProductImage $image)
    {        
        $image->delete();
        unlink(public_path($image->path));
        return response()->json(['status' => 'deleted']);
    }
}
