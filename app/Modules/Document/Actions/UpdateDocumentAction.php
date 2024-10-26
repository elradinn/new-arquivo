<?php

namespace Modules\Document\Actions;

use Modules\Document\Actions\AttachDocumentMetadataAction;
use Modules\Document\Data\AttachDocumentMetadataData;
use Modules\Document\Models\Document;
use Modules\Document\Data\UpdateDocumentData;

class UpdateDocumentAction
{
    public function __construct(
        protected AttachDocumentMetadataAction $attachDocumentMetadataAction
    ) {}

    public function execute(Document $document, UpdateDocumentData $data): Document
    {
        $document->update([
            'name' => $data->name,
            'document_number' => $data->document_number,
            'description' => $data->description
        ]);

        $this->attachDocumentMetadataAction->execute($document, $data);

        return $document;
    }
}
