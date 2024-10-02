<?php

namespace App\Document\Controllers;

use App\Common\Controllers\Controller;
use Domain\Document\Models\Document;
use Domain\DocumentHasMetadata\Actions\AttachDocumentMetadataAction;
use Domain\DocumentHasMetadata\Actions\DetachDocumentMetadataAction;
use Domain\DocumentHasMetadata\Actions\UpdateDocumentMetadataAction;
use Domain\DocumentHasMetadata\Data\AttachDocumentMetadataData;
use Domain\DocumentHasMetadata\Data\UpdateDocumentMetadataData;
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
