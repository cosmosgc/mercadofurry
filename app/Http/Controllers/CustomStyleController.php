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
            'name'   => 'required|string|max:255',
            'styles' => 'required|array',
        ]);

        CustomStyle::create([
            'name' => $data['name'],
            'styles' => json_encode($data['styles']),
        ]);

        return redirect()->route('custom-styles.index')
            ->with('success', 'Style created');
    }

    public function show(CustomStyle $customStyle)
    {
        return view('custom_styles.show', compact('customStyle'));
    }

    public function edit(CustomStyle $customStyle)
    {
        return view('custom_styles.edit', compact('customStyle'));
    }

    public function update(Request $request, CustomStyle $customStyle)
    {
        $data = $request->validate([
            'name'   => 'required|string|max:255',
            'styles' => 'required|array',
        ]);

        $customStyle->update([
            'name' => $data['name'],
            'styles' => json_encode($data['styles']),
        ]);

        return redirect()->route('custom-styles.index')
            ->with('success', 'Style updated');
    }

    public function destroy(CustomStyle $customStyle)
    {
        $customStyle->delete();

        return redirect()->route('custom-styles.index')
            ->with('success', 'Style deleted');
    }
}
