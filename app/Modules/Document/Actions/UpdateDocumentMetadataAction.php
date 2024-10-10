<?php

namespace Modules\Document\Actions;

use Modules\Document\Data\UpdateDocumentMetadataData;
use Modules\Document\Models\Document;
use Modules\Metadata\Models\Metadata;

class UpdateDocumentMetadataAction
{
    public function execute(Document $document, Metadata $metadata, UpdateDocumentMetadataData $data): void
    {
        $document->metadata()->updateExistingPivot($metadata->id, ['value' => $data->value]);
    }
}
