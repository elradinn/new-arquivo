<?php

namespace Domain\Document\Actions;

use Domain\Document\Data\AttachDocumentMetadataData;
use Domain\Document\Models\Document;

class AttachDocumentMetadataAction
{
    public function execute(Document $document, AttachDocumentMetadataData $data): void
    {
        $document->metadata()->attach($data->metadata_id, ['value' => $data->value]);
    }
}
