<?php

namespace Domain\DocumentHasMetadata\Actions;

use Domain\DocumentHasMetadata\Data\AttachDocumentMetadataData;
use Domain\Document\Models\Document;

class AttachDocumentMetadataAction
{
    public function execute(Document $document, AttachDocumentMetadataData $data): void
    {
        $document->metadata()->attach($data->metadata_id, ['value' => $data->value]);
    }
}
