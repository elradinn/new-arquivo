<?php

namespace Domain\DocumentApproval\Actions;

use Domain\DocumentApproval\States\DocumentApprovalPending;
use Domain\DocumentApproval\States\DocumentReviewalPending;
use Domain\DocumentApproval\Data\CreateDocumentApprovalData;
use Domain\DocumentApproval\Models\DocumentApproval;
use Domain\DocumentApprovalHasUser\Models\DocumentApprovalHasUser;

class CreateDocumentApprovalAction
{
    public function __construct(
        protected SendDocumentApprovalNotificationAction $sendDocumentApprovalNotificationAction
    ) {}

    public function execute(CreateDocumentApprovalData $data): DocumentApproval
    {
        $documentApproval = DocumentApproval::create([
            'document_id' => $data->document_id,
            'resolution' => $data->resolution,
            'destination' => $data->destination,
            'state' => $data->type === 'reviewal' ? DocumentReviewalPending::class : DocumentApprovalPending::class,
        ]);

        $documentApprovalUsers = collect($data->users)->map(function ($user) {
            return new DocumentApprovalHasUser([
                'user_id' => $user->user_id,
            ]);
        });

        $documentApproval->documentApprovalUsers()->saveMany($documentApprovalUsers);

        $this->sendDocumentApprovalNotificationAction->execute($documentApproval);

        return $documentApproval;
    }
}
