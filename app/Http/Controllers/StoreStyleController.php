<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\CustomStyle;

class StoreStyleController extends Controller
{
    public function edit(Store $store)
    {
        abort_if(auth()->id() !== $store->user_id, 403);

        $styles = CustomStyle::where('user_id', auth()->id())->get();

        return view('stores.style.edit', compact('store', 'styles'));
    }

    public function update(Request $request, Store $store)
    {
        abort_if(auth()->id() !== $store->user_id, 403);

        $request->validate([
            'custom_style_id' => [
                'nullable',
                'exists:custom_styles,id',
            ],
        ]);

        $store->update([
            'custom_style_id' => $request->custom_style_id,
        ]);

        return redirect()
            ->route('stores.show', $store)
            ->with('success', 'Store style updated!');
    }


}
