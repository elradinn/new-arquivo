<?php

namespace Domain\Document\Listeners;

use Domain\Document\Events\DocumentUploaded;
use Domain\Document\Models\Document;
use Domain\Folder\Models\Folder;
use Domain\NumberingScheme\Actions\GenerateDocumentNumberAction;
use Domain\NumberingScheme\Models\NumberingScheme;

class ApplyDocumentNumberListener
{
    public function __construct(
        protected GenerateDocumentNumberAction $generateDocumentNumberAction
    ) {}

    public function handle(DocumentUploaded $event): void
    {
        $document = $event->document;

        $folder = Folder::find($document->item->parent_id);

        if ($folder) {
            // $numberingScheme = NumberingScheme::where('folder_id', $folder->item_id)->first();

            $numberingScheme = $folder->numberingScheme()->get();

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
