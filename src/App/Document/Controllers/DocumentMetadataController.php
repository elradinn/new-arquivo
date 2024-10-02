<?php

namespace App\Document\Controllers;

use App\Common\Controllers\Controller;
use Domain\Document\Models\Document;
use Domain\Document\Actions\AttachDocumentMetadataAction;
use Domain\Document\Actions\DetachDocumentMetadataAction;
use Domain\Document\Actions\UpdateDocumentMetadataAction;
use Domain\Document\Data\AttachDocumentMetadataData;
use Domain\Document\Data\UpdateDocumentMetadataData;
use Domain\Metadata\Models\Metadata;
use Illuminate\Http\JsonResponse;

class DocumentMetadataController extends Controller
{
    public function __construct(
        protected AttachDocumentMetadataAction $attachDocumentMetadataAction,
        protected UpdateDocumentMetadataAction $updateDocumentMetadataAction,
        protected DetachDocumentMetadataAction $detachDocumentMetadataAction
    ) {}

    /**
     * Attach metadata to a document.
     */
    public function attach(AttachDocumentMetadataData $data, Document $document): JsonResponse
    {
        $this->attachDocumentMetadataAction->execute($document, $data);

        return response()->json(['message' => 'Metadata attached successfully.'], 200);
    }

    /**
     * Update metadata value for a document.
     */
    public function update(UpdateDocumentMetadataData $data, Document $document, Metadata $metadata): JsonResponse
    {
        $this->updateDocumentMetadataAction->execute($document, $metadata, $data);

        return response()->json(['message' => 'Metadata updated successfully.'], 200);
    }

    /**
     * Detach metadata from a document.
     */
    public function detach(Document $document, Metadata $metadata): JsonResponse
    {
        $this->detachDocumentMetadataAction->execute($document, $metadata);

        return response()->json(['message' => 'Metadata detached successfully.'], 200);
    }
}
