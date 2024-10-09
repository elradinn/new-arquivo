<?php

namespace Modules\Document\Actions;

use Modules\Document\Models\Document;
use Modules\Document\Data\UpdateDocumentData;

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
