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
        $documents = [];

        foreach ($data->files as $file) {
            $uploadedFile = $file->getUploadedFile();

            $item = $this->createItemAction->execute(
                CreateItemData::from([
                    'parent_id' => $data->parent_id,
                ])
            );

            $filePath = $uploadedFile->store('documents', 'public');

            $document = $item->document()->create([
                'name' => $uploadedFile->getClientOriginalName(),
                'owned_by' => $data->owned_by ?? Auth::id(),
                'mime' => $uploadedFile->getMimeType(),
                'size' => $uploadedFile->getSize(),
                'file_path' => $filePath,
            ]);

            activity()
                ->performedOn($document)
                ->causedBy(Auth::id())
                ->log("Document uploaded");

            $this->applyDocumentNumberAction->execute($document);

            $this->createDocumentApprovalFromWorkflowAction->execute($document);

            $documents[] = $document;
        }

        return $documents;
    }
}
