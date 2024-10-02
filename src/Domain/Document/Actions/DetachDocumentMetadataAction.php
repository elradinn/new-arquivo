<?php

namespace Domain\Document\Actions;

use Domain\Document\Models\Document;
use Domain\Metadata\Models\Metadata;

class DetachDocumentMetadataAction
{
    public function execute(Document $document, Metadata $metadata): void
    {
        $document->metadata()->detach($metadata->id);
    }
}
