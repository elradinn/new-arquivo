<?php

namespace Domain\Document\Actions;

use Domain\Document\Data\UploadDocumentData;
use Domain\Document\Models\Document;
use Domain\DocumentApproval\Actions\CreateDocumentApprovalFromWorkflowAction;
use Domain\Item\Actions\CreateItemAction;
use Domain\Item\Data\CreateItemData;
use Domain\NumberingScheme\Actions\ApplyDocumentNumberAction;
use Illuminate\Support\Facades\Auth;

class UploadDocumentAction
{
    public function __construct(
        protected CreateItemAction $createItemAction,
        protected CreateDocumentApprovalFromWorkflowAction $createDocumentApprovalFromWorkflowAction,
        protected ApplyDocumentNumberAction $applyDocumentNumberAction,
    ) {}

    public function execute(UploadDocumentData $data): Document
    {
        $item = $this->createItemAction->execute(
            CreateItemData::from([
                'parent_id' => $data->parent_id,
            ])
        );

        $document = $item->document()->create([
            'name' => $data->name,
            'owned_by' => Auth::id(),
        ]);

        $this->applyDocumentNumberAction->execute($document);

        $this->createDocumentApprovalFromWorkflowAction->execute($document);

        return $document;
    }
}
