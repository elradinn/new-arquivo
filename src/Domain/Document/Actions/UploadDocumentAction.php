<?php

namespace Domain\Document\Actions;

use Domain\Document\Data\UploadDocumentData;
use Domain\Document\Models\Document;
use Domain\DocumentApproval\Actions\CreateDocumentApprovalFromWorkflowAction;
use Domain\Item\Actions\CreateItemAction;
use Domain\Item\Data\CreateItemData;
use Domain\NumberingScheme\Actions\ApplyDocumentNumberAction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UploadDocumentAction
{
    public function __construct(
        protected CreateItemAction $createItemAction,
        protected CreateDocumentApprovalFromWorkflowAction $createDocumentApprovalFromWorkflowAction,
        protected ApplyDocumentNumberAction $applyDocumentNumberAction,
    ) {}

    public function execute(UploadDocumentData $data): Document
    {
        // Create the Item
        $item = $this->createItemAction->execute(
            CreateItemData::from([
                'parent_id' => $data->parent_id,
            ])
        );

        // Store the uploaded file
        $filePath = $data->file->store('documents', 'public');

        // Create the Document
        $document = $item->document()->create([
            'name' => $data->name,
            'owned_by' => Auth::id(),
            'file_path' => $filePath, // Save the file path
        ]);

        // Apply Document Number
        $this->applyDocumentNumberAction->execute($document);

        // Create Document Approval from Workflow
        $this->createDocumentApprovalFromWorkflowAction->execute($document);

        return $document;
    }
}
