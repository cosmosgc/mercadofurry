<?php

namespace App\Http\Controllers;

use App\Models\CustomStyle;
use Illuminate\Http\Request;

class CustomStyleController extends Controller
{
    public function index()
    {
        $styles = CustomStyle::latest()->paginate(10);
        return view('custom_styles.index', compact('styles'));
    }

    public function create()
    {
        return view('custom_styles.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'tokens' => ['required', 'array'],
            'custom_css' => ['nullable', 'string'],
        ]);

        CustomStyle::create([
            'user_id' => auth()->id(),
            'name' => $data['name'],
            'tokens' => $data['tokens'],
            'custom_css' => $data['custom_css'],
        ]);

        return redirect()->route('dashboard')->with('success', 'Style created!');
    }


    public function show(CustomStyle $customStyle)
    {
        return view('custom_styles.show', compact('customStyle'));
    }

    public function edit(CustomStyle $customStyle)
    {
        abort_if($customStyle->user_id !== auth()->id(), 403);
        return view('custom_styles.edit', compact('customStyle'));
    }

    public function update(Request $request, CustomStyle $customStyle)
    {
        abort_if($customStyle->user_id !== auth()->id(), 403);

        $data = $request->validate([
            'name'       => 'required|string|max:255',
            'tokens'     => 'required|array',
            'custom_css' => 'nullable|string',
        ]);

        $customStyle->update([
            'name'       => $data['name'],
            'tokens'     => $data['tokens'],     // ✅ let casts handle it
            'custom_css' => $data['custom_css'], // ✅ now saved
        ]);

        return redirect()
            ->route('custom-styles.index')
            ->with('success', 'Style updated');
    }


    public function destroy(CustomStyle $customStyle)
    {
        $customStyle->delete();

        return redirect()->route('custom-styles.index')
            ->with('success', 'Style deleted');
    }
}
