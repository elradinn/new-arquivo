<?php

namespace Domain\NumberingScheme\Actions;

use Domain\Document\Models\Document;
use Domain\Folder\Models\Folder;
use Domain\NumberingScheme\Actions\GenerateDocumentNumberAction;

class ApplyDocumentNumberAction
{
    public function __construct(
        protected GenerateDocumentNumberAction $generateDocumentNumberAction
    ) {}

    public function execute(Document $document): void
    {

        $folder = Folder::find($document->item->parent_id);

        if ($folder) {
            // $numberingScheme = NumberingScheme::where('folder_id', $folder->item_id)->first();

            $numberingScheme = $folder->numberingScheme;

            if ($numberingScheme) {
                $documentNumber = $this->generateDocumentNumberAction->execute($numberingScheme->prefix);

                // $document = Document::find($document->item->id);
                // $document->document_number = $documentNumber;

                $document->update([
                    'document_number' => $documentNumber,
                ]);
            }
        }
    }
}
