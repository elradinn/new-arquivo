<?php

namespace App\Document\Controllers;

use App\Common\Controllers\Controller;
use Domain\Document\Models\Document;
use Domain\Metadata\Models\Metadata;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DocumentMetadataController extends Controller
{
    /**
     * Attach metadata to a document.
     */
    public function attach(Request $request, Document $document): JsonResponse
    {
        $validated = $request->validate([
            'metadata_id' => 'required|exists:metadata,id',
            'value' => 'required|string', // Adjust validation based on metadata type
        ]);

        $document->metadata()->attach($validated['metadata_id'], ['value' => $validated['value']]);

        return response()->json(['message' => 'Metadata attached successfully.'], 200);
    }

    /**
     * Update metadata value for a document.
     */
    public function update(Request $request, Document $document, Metadata $metadata): JsonResponse
    {
        $validated = $request->validate([
            'value' => 'required|string', // Adjust validation based on metadata type
        ]);

        $document->metadata()->updateExistingPivot($metadata->id, ['value' => $validated['value']]);

        return response()->json(['message' => 'Metadata updated successfully.'], 200);
    }

    /**
     * Detach metadata from a document.
     */
    public function detach(Document $document, Metadata $metadata): JsonResponse
    {
        $document->metadata()->detach($metadata->id);

        return response()->json(['message' => 'Metadata detached successfully.'], 200);
    }

    /**
     * List all metadata for a document.
     */
    public function list(Document $document): JsonResponse
    {
        $metadata = $document->metadata()->get()->map(function ($item) {
            return [
                'name' => $item->name,
                'value' => $item->pivot->value,
                'created_at' => $item->pivot->created_at,
                'updated_at' => $item->pivot->updated_at,
            ];
        });

        return response()->json($metadata, 200);
    }
}
