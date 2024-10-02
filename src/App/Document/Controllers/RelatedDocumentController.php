<?php

namespace App\Document\Controllers;

use Illuminate\Http\JsonResponse;
use App\Common\Controllers\Controller;
use Domain\Document\Models\Document;
use Domain\Document\Actions\AttachRelatedDocumentAction;
use Domain\Document\Actions\DetachRelatedDocumentAction;
use Illuminate\Http\Response;

class RelatedDocumentController extends Controller
{
    public function __construct(
        protected AttachRelatedDocumentAction $attachRelatedDocumentAction,
        protected DetachRelatedDocumentAction $detachRelatedDocumentAction
    ) {}

    /**
     * Attach a related document to a document.
     *
     * @param  \Domain\Document\Models\Document  $document
     * @param  \Domain\Document\Models\Document  $relatedDocument
     * @return \Illuminate\Http\JsonResponse
     */
    public function attach(Document $document, Document $relatedDocument): JsonResponse
    {
        $this->attachRelatedDocumentAction->execute($document, $relatedDocument);

        return response()->json([
            'message' => 'Related document attached successfully.',
        ], Response::HTTP_OK);
    }

    /**
     * Detach a related document from a document.
     *
     * @param  \Domain\Document\Models\Document  $document
     * @param  \Domain\Document\Models\Document  $relatedDocument
     * @return \Illuminate\Http\JsonResponse
     */
    public function detach(Document $document, Document $relatedDocument): JsonResponse
    {
        $this->detachRelatedDocumentAction->execute($document, $relatedDocument);

        return response()->json([
            'message' => 'Related document detached successfully.',
        ], Response::HTTP_OK);
    }
}
