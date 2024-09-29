<?php

namespace Domain\Document\Listeners;

use Domain\Document\Events\DocumentUploaded;
use Domain\DocumentApproval\Actions\CreateDocumentApprovalAction;
use Domain\DocumentApproval\Data\CreateDocumentApprovalData;
use Domain\DocumentApprovalHasUser\Data\CreateDocumentApprovalHasUserData;
use Domain\Folder\Models\Folder;
use Illuminate\Support\Facades\Log;

class CreateDocumentApprovalFromWorkflowListener
{
    public function handle(DocumentUploaded $event)
    {
        $document = $event->document;
        Log::info('CreateDocumentApprovalFromWorkflowListener: ' . $document->item);
        $folder = Folder::find($document->item->parent_id);
        Log::info('Folder: ' . $folder);

        // Log::info('CreateDocumentApprovalFromWorkflowListener: ' . $item);

        if ($folder && $folder->workflow) {
            $workflow = $folder->workflow;

            $createDocumentApprovalData = new CreateDocumentApprovalData(
                document_id: $document->item->id,
                resolution: $workflow->resolution,
                destination: $workflow->destination,
                users: $workflow->workflowUsers->map(fn($user) => new CreateDocumentApprovalHasUserData($user->user_id))->all()
            );

            $createDocumentApprovalAction = new CreateDocumentApprovalAction();
            $createDocumentApprovalAction->execute($createDocumentApprovalData);
        }
    }
}
