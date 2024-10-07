<?php

namespace Domain\DocumentApproval\Actions;

use Domain\Document\Models\Document;
use Domain\DocumentApproval\Actions\CreateDocumentApprovalAction;
use Domain\DocumentApproval\Data\CreateDocumentApprovalData;
use Domain\DocumentApprovalHasUser\Data\CreateDocumentApprovalHasUserData;
use Domain\Folder\Models\Folder;


class CreateDocumentApprovalFromWorkflowAction
{
    public function __construct(
        protected CreateDocumentApprovalAction $createDocumentApprovalAction
    ) {}

    public function execute(Document $document)
    {
        $folder = Folder::find($document->item->parent_id);

        if ($folder && $folder->workflow) {
            $workflow = $folder->workflow;

            $createDocumentApprovalData = new CreateDocumentApprovalData(
                document_id: $document->item->id,
                resolution: $workflow->resolution,
                destination: $workflow->destination,
                type: $workflow->type,
                users: $workflow->workflowUsers->map(fn($user) => new CreateDocumentApprovalHasUserData($user->user_id))->all()
            );

            $this->createDocumentApprovalAction->execute($createDocumentApprovalData);
        }
    }
}
