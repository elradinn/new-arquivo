<?php

namespace Modules\Document\Actions;

use Modules\Document\Data\AttachDocumentMetadataData;
use Modules\Document\Models\Document;

class AttachDocumentMetadataAction
{
    public function execute(Document $document, AttachDocumentMetadataData $data): void
    {
        $document->metadata()->attach($data->metadata_id, ['value' => $data->value]);
    }
}
