<?php

namespace Domain\Document\Actions;

use Domain\Document\Models\Document;

class DetachRelatedDocumentAction
{
    public function execute(Document $document, Document $relatedDocument): void
    {
        // Detach the related document
        $document->relatedDocuments()->detach($relatedDocument->item_id);

        // Also detach the inverse relationship
        $relatedDocument->relatedDocuments()->detach($document->item_id);
    }
}
