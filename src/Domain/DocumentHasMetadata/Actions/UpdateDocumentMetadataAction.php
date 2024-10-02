<?php

namespace Domain\DocumentHasMetadata\Actions;

use Domain\DocumentHasMetadata\Data\UpdateDocumentMetadataData;
use Domain\Document\Models\Document;
use Domain\Metadata\Models\Metadata;

class UpdateDocumentMetadataAction
{
    public function execute(Document $document, Metadata $metadata, UpdateDocumentMetadataData $data): void
    {
        $document->metadata()->updateExistingPivot($metadata->id, ['value' => $data->value]);
    }
}
