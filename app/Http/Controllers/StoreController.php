<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\CustomStyle;
use App\Models\User;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index()
    {
        $stores = Store::with('user', 'customStyle')->latest()->paginate(10);
        return view('stores.index', compact('stores'));
    }

    public function create()
    {
        return view('stores.create', [
            'users' => User::all(),
            'styles' => CustomStyle::all(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'            => 'required|string|max:255',
            'description'     => 'nullable|string',
            'custom_style_id' => 'nullable|exists:custom_styles,id',
            'cover'           => 'nullable|image|max:4096',
        ]);

        $data['user_id'] = auth()->id();

        if ($request->hasFile('cover')) {
            $file = $request->file('cover');

            $filename = uniqid('store_') . '.' . $file->getClientOriginalExtension();
            $destination = public_path('uploads/stores');

            $file->move($destination, $filename);

            $data['cover_path'] = 'uploads/stores/' . $filename;
        }

        Store::create($data);

        return redirect()
            ->route('stores.index')
            ->with('success', 'Store created successfully');
    }



    public function show(Store $store)
    {
        $store->load('products', 'customStyle', 'user');
        return view('stores.show', compact('store'));
    }

    public function edit(Store $store)
    {
        return view('stores.edit', [
            'store' => $store,
            'styles' => CustomStyle::all(),
        ]);
    }

    public function update(Request $request, Store $store)
    {
        $data = $request->validate([
            'name'            => 'required|string|max:255',
            'description'     => 'nullable|string',
            'custom_style_id' => 'nullable|exists:custom_styles,id',
            'cover'           => 'nullable|image|max:4096',
        ]);

        if ($request->hasFile('cover')) {
            $file = $request->file('cover');

            $filename = uniqid('store_') . '.' . $file->getClientOriginalExtension();
            $destination = public_path('uploads/stores');

            $file->move($destination, $filename);

            $data['cover_path'] = 'uploads/stores/' . $filename;
        }

        $store->update($data);

        return redirect()
            ->route('stores.show', $store)
            ->with('success', 'Store updated');
    }


    public function destroy(Store $store)
    {
        $store->delete();

        return redirect()->route('stores.index')
            ->with('success', 'Store deleted');
    }
}
