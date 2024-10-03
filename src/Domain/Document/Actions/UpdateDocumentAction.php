<?php

namespace Domain\Document\Actions;

use Domain\Document\Models\Document;
use Domain\Document\Data\UpdateDocumentData;

class UpdateDocumentAction
{
    public function execute(Document $document, UpdateDocumentData $data): Document
    {
        $document->update([
            'name' => $data->name,
        ]);

        return $document;
    }
}
