<?php

namespace Domain\Document\Listeners;

use Domain\Document\Events\DocumentUploaded;
use Domain\DocumentApproval\Actions\CreateDocumentApprovalAction;
use Domain\DocumentApproval\Data\CreateDocumentApprovalData;
use Domain\DocumentApprovalHasUser\Data\CreateDocumentApprovalHasUserData;
use Domain\Folder\Models\Folder;


class CreateDocumentApprovalFromWorkflowListener
{
    public function __construct(
        protected CreateDocumentApprovalAction $createDocumentApprovalAction
    ) {}

    public function handle(DocumentUploaded $event)
    {
        $document = $event->document;
        $folder = Folder::find($document->item->parent_id);

        if ($folder && $folder->workflow) {
            $workflow = $folder->workflow;

            $createDocumentApprovalData = new CreateDocumentApprovalData(
                document_id: $document->item->id,
                resolution: $workflow->resolution,
                destination: $workflow->destination,
                users: $workflow->workflowUsers->map(fn($user) => new CreateDocumentApprovalHasUserData($user->user_id))->all()
            );

            $this->createDocumentApprovalAction->execute($createDocumentApprovalData);
        }
    }
}
