<?php

namespace App\NumberingScheme\Controllers;

use App\Common\Controllers\Controller;
use Domain\NumberingScheme\Models\NumberingScheme;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NumberingSchemeController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'folder_id' => 'required|exists:folders,item_id|unique:numbering_schemes,folder_id',
            'prefix' => 'required|string',
        ]);

        $numberingScheme = NumberingScheme::create($validated);

        return response()->json($numberingScheme, 201);
    }

    public function update(Request $request, NumberingScheme $numberingScheme): JsonResponse
    {
        $validated = $request->validate([
            'prefix' => 'required|string',
        ]);

        $numberingScheme->update($validated);

        return response()->json($numberingScheme);
    }

    public function destroy(NumberingScheme $numberingScheme): JsonResponse
    {
        $numberingScheme->delete();

        return response()->json(['message' => 'Numbering scheme deleted successfully']);
    }
}
