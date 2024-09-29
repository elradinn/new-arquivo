<?php

namespace App\Metadata\Controllers;

use App\Common\Controllers\Controller;
use Domain\Metadata\Models\Metadata;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MetadataController extends Controller
{
    /**
     * Display a listing of the metadata.
     */
    public function index(): JsonResponse
    {
        $metadata = Metadata::all();
        return response()->json($metadata, 200);
    }

    /**
     * Store a newly created metadata in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:metadata,name',
            'type' => 'required|string|in:string,integer,float,boolean,date,datetime',
        ]);

        $metadata = Metadata::create($validated);

        return response()->json($metadata, 201);
    }

    /**
     * Update the specified metadata in storage.
     */
    public function update(Request $request, Metadata $metadata): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|unique:metadata,name,' . $metadata->id,
            'type' => 'sometimes|required|string|in:string,integer,float,boolean,date,datetime',
        ]);

        $metadata->update($validated);

        return response()->json($metadata, 200);
    }

    /**
     * Remove the specified metadata from storage.
     */
    public function destroy(Metadata $metadata): JsonResponse
    {
        $metadata->delete();
        return response()->json(['message' => 'Metadata deleted successfully.'], 200);
    }
}
