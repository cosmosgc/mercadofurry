<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index()
    {
        return response()->json(
            Store::with('customStyle', 'user')->latest()->get()
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'            => 'required|string|max:255',
            'description'     => 'nullable|string',
            'user_id'         => 'required|exists:users,id',
            'custom_style_id' => 'nullable|exists:custom_styles,id',
        ]);

        $store = Store::create($data);

        return response()->json($store, 201);
    }

    public function show(Store $store)
    {
        return response()->json(
            $store->load('customStyle', 'user', 'products')
        );
    }

    public function update(Request $request, Store $store)
    {
        $data = $request->validate([
            'name'            => 'sometimes|string|max:255',
            'description'     => 'nullable|string',
            'custom_style_id' => 'nullable|exists:custom_styles,id',
        ]);

        $store->update($data);

        return response()->json($store);
    }

    public function destroy(Store $store)
    {
        $store->delete();

        return response()->json(['message' => 'Store deleted']);
    }
}
