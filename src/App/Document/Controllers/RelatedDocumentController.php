<?php

namespace App\Document\Controllers;

use App\Common\Controllers\Controller;
use Domain\Document\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class RelatedDocumentController extends Controller
{
    /**
     * Attach a related document to a document.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Domain\Document\Models\Document  $document
     * @return \Illuminate\Http\JsonResponse
     */
    public function attach(Request $request, Document $document): JsonResponse
    {
        $validated = $request->validate([
            'related_document_id' => 'required|exists:documents,item_id|different:item_id',
        ]);

        $relatedDocumentId = $validated['related_document_id'];

        // Attach the related document without detaching existing ones
        $document->relatedDocuments()->syncWithoutDetaching([$relatedDocumentId]);

        // Also attach the inverse relationship if bidirectional
        $relatedDocument = Document::find($relatedDocumentId);
        if ($relatedDocument) {
            $relatedDocument->relatedDocuments()->syncWithoutDetaching([$document->item_id]);
        }

        return response()->json([
            'message' => 'Related document attached successfully.',
        ], 200);
    }

    /**
     * Detach a related document from a document.
     *
     * @param  \Domain\Document\Models\Document  $document
     * @param  int  $relatedDocumentId
     * @return \Illuminate\Http\JsonResponse
     */
    public function detach(Document $document, $relatedDocumentId): JsonResponse
    {
        $document->relatedDocuments()->detach($relatedDocumentId);

        // Also detach the inverse relationship if bidirectional
        $relatedDocument = Document::find($relatedDocumentId);
        if ($relatedDocument) {
            $relatedDocument->relatedDocuments()->detach($document->item_id);
        }

        return response()->json([
            'message' => 'Related document detached successfully.',
        ], 200);
    }

    /**
     * List all related documents for a document.
     *
     * @param  \Domain\Document\Models\Document  $document
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Document $document): JsonResponse
    {
        $relatedDocuments = $document->relatedDocuments()->with('item')->get();

        return response()->json([
            'related_documents' => $relatedDocuments,
        ], 200);
    }
}
