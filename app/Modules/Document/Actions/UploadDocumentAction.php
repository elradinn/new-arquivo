<?php

namespace Modules\Document\Actions;

use Modules\Document\Data\UploadDocumentData;
use Modules\Document\Models\Document;
use Modules\DocumentApproval\Actions\CreateDocumentApprovalFromWorkflowAction;
use Modules\Item\Actions\CreateItemAction;
use Modules\Item\Data\CreateItemData;
use Modules\NumberingScheme\Actions\ApplyDocumentNumberAction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UploadDocumentAction
{
    public function __construct(
        protected CreateItemAction $createItemAction,
        protected CreateDocumentApprovalFromWorkflowAction $createDocumentApprovalFromWorkflowAction,
        protected ApplyDocumentNumberAction $applyDocumentNumberAction,
    ) {}

    public function execute(UploadDocumentData $data): array
    {
        // dd($data);

        $documents = [];

        Log::info($data->files);

        foreach ($data->files as $file) {

            // Create the Item
            $item = $this->createItemAction->execute(
                CreateItemData::from([
                    'parent_id' => $data->parent_id,
                ])
            );

            // Store the uploaded file
            $filePath = $file->file->store('documents', 'public');

            // Create the Document
            $document = $item->document()->create([
                'name' => $file->file->getClientOriginalName(),
                'owned_by' => $data->owned_by ?? Auth::id(),
                'mime' => $file->file->getMimeType(),
                'size' => $file->file->getSize(),
                'file_path' => $filePath,
            ]);

            // Apply Document Number
            $this->applyDocumentNumberAction->execute($document);

            // Create Document Approval from Workflow
            $this->createDocumentApprovalFromWorkflowAction->execute($document);

            $documents[] = $document;
        }

        return $documents;
    }
}
