<?php

namespace Modules\Document\Actions;

use Modules\Document\Data\UpdateDocumentData;
use Modules\Document\Models\Document;

class AttachDocumentMetadataAction
{
    public function execute(Document $document, UpdateDocumentData $data): void
    {
        collect($data->metadata)->map(function ($metadata) use ($document) {
            $document->metadata()->updateExistingPivot($metadata->metadata_id, ['value' => $metadata->value]);
        });
    }
}


// namespace Modules\Document\Actions;

// use Modules\Document\Data\AttachDocumentMetadataData;
// use Modules\Document\Models\Document;

// class AttachDocumentMetadataAction
// {
//     public function execute(Document $document, AttachDocumentMetadataData $data): void
//     {
//         $document->metadata()->attach($data->metadata_id, ['value' => $data->value]);
//     }
// }
