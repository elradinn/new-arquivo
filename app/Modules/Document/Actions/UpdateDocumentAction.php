<?php

namespace Modules\Document\Actions;

use Modules\Document\Actions\DocumentMetadataAction;
use Modules\Document\Data\DocumentMetadataData;
use Modules\Document\Models\Document;
use Modules\Document\Data\UpdateDocumentData;

class UpdateDocumentAction
{
    public function __construct(
        protected UpdateDocumentMetadataAction $updateDocumentMetadataAction
    ) {}

    public function execute(Document $document, UpdateDocumentData $data): Document
    {
        $document->update([
            'name' => $data->name,
            'document_number' => $data->document_number,
            'description' => $data->description
        ]);

        $this->updateDocumentMetadataAction->execute($document, $data);

        return $document;
    }
}
