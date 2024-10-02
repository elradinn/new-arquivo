<?php

namespace Domain\Document\Actions;

use Domain\Document\Models\Document;

class AttachRelatedDocumentAction
{
    public function execute(Document $document, Document $relatedDocument): void
    {
        // Attach the related document without detaching existing ones
        $document->relatedDocuments()->syncWithoutDetaching([$relatedDocument->item_id]);

        // Also attach the inverse relationship
        $relatedDocument->relatedDocuments()->syncWithoutDetaching([$document->item_id]);
    }
}
