<?php

namespace Domain\Document\Listeners;

use Domain\Document\Events\DocumentUploaded;
use Domain\Document\Models\Document;
use Domain\Folder\Models\Folder;
use Domain\NumberingScheme\Models\NumberingScheme;
use Support\Utilities\GenerateDocumentNumbering;
use Illuminate\Support\Facades\Log;

class ApplyDocumentNumberingListener
{
    public function handle(DocumentUploaded $event)
    {
        $document = $event->document;

        Log::info('ApplyDocumentNumberingListener: Document: ' . $document);
        $folder = Folder::find($document->item->parent_id);


        Log::info('ApplyDocumentNumberingListener: Folder ID - ' . $folder->item_id);

        if ($folder) {
            $numberingScheme = NumberingScheme::where('folder_id', $folder->item_id)->first();

            if ($numberingScheme) {
                $documentNumber = GenerateDocumentNumbering::generate($numberingScheme->prefix);
                $document = Document::find($document->item->id);
                $document->document_number = $documentNumber;
                $document->save();

                Log::info('ApplyDocumentNumberingListener: Document number applied - ' . $documentNumber);
            }
        }
    }
}
