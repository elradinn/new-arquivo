<?php

namespace Modules\Document\Actions;

use Modules\Document\Data\UploadDocumentData;
use Modules\Document\Models\Document;
use Modules\DocumentApproval\Actions\CreateDocumentApprovalFromWorkflowAction;
use Modules\Item\Actions\CreateItemAction;
use Modules\Item\Data\CreateItemData;
use Modules\NumberingScheme\Actions\ApplyDocumentNumberAction;
use Illuminate\Support\Facades\Auth;

class UploadDocumentAction
{
    public function __construct(
        protected CreateItemAction $createItemAction,
        protected CreateDocumentApprovalFromWorkflowAction $createDocumentApprovalFromWorkflowAction,
        protected ApplyDocumentNumberAction $applyDocumentNumberAction,
    ) {}

    public function execute(UploadDocumentData $data): array
    {
        $documents = [];

        foreach ($data->files as $file) {
            // Create the Item
            $item = $this->createItemAction->execute(
                CreateItemData::from([
                    'parent_id' => $data->parent_id,
                ])
            );

            // Store the uploaded file
            $filePath = $file->store('documents', 'public');

            // Create the Document
            $document = $item->document()->create([
                'name' => $file->getClientOriginalName(), // Use the file's original name
                'owned_by' => $data->owned_by ?? Auth::id(),
                'file_path' => $filePath, // Save the file path
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
