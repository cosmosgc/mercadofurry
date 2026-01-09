<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CustomStyle;
use Illuminate\Http\Request;

class CustomStyleController extends Controller
{
    public function index()
    {
        return response()->json(
            CustomStyle::latest()->get()
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'   => 'required|string|max:255',
            'styles' => 'required|array',
        ]);

        $customStyle = CustomStyle::create([
            'name'   => $data['name'],
            'styles' => json_encode($data['styles']),
        ]);

        return response()->json($customStyle, 201);
    }

    public function show(CustomStyle $customStyle)
    {
        return response()->json($customStyle);
    }

    public function update(Request $request, CustomStyle $customStyle)
    {
        $data = $request->validate([
            'name'   => 'sometimes|string|max:255',
            'styles' => 'sometimes|array',
        ]);

        if (isset($data['styles'])) {
            $data['styles'] = json_encode($data['styles']);
        }

        $customStyle->update($data);

        return response()->json($customStyle);
    }

    public function destroy(CustomStyle $customStyle)
    {
        $customStyle->delete();

        return response()->json(['message' => 'Custom style deleted']);
    }
}
