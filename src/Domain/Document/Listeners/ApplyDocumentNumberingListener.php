<?php

namespace Domain\Document\Listeners;

use Domain\Document\Events\DocumentUploaded;
use Domain\Document\Models\Document;
use Domain\Folder\Models\Folder;
use Domain\NumberingScheme\Models\NumberingScheme;
use Support\Utilities\GenerateDocumentNumbering;


class ApplyDocumentNumberingListener
{
    public function handle(DocumentUploaded $event)
    {
        $document = $event->document;

        $folder = Folder::find($document->item->parent_id);

        if ($folder) {
            $numberingScheme = NumberingScheme::where('folder_id', $folder->item_id)->first();

            if ($numberingScheme) {
                $documentNumber = GenerateDocumentNumbering::generate($numberingScheme->prefix);
                $document = Document::find($document->item->id);
                $document->document_number = $documentNumber;
                $document->save();
            }
        }
    }
}
