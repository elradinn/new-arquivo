<?php

namespace Domain\DocumentApproval\Actions;

use Domain\DocumentApproval\States\DocumentApprovalPending;
use Domain\DocumentApproval\States\DocumentReviewalPending;
use Domain\DocumentApproval\Data\CreateDocumentApprovalData;
use Domain\DocumentApproval\Models\DocumentApproval;
use Domain\DocumentApprovalHasUser\Models\DocumentApprovalHasUser;
use Domain\DocumentApprovalHasUser\States\UserApprovalPending;
use Domain\DocumentApprovalHasUser\States\UserReviewalPending;

class CreateDocumentApprovalAction
{
    public function __construct(
        protected SendDocumentApprovalNotificationAction $sendDocumentApprovalNotificationAction
    ) {}

    public function execute(CreateDocumentApprovalData $data): DocumentApproval
    {
        $approvalType = $data->type;

        $documentApproval = DocumentApproval::create([
            'document_id' => $data->document_id,
            'resolution' => $data->resolution,
            'destination' => $data->destination,
            'type' => $data->type,
            'overall_state' => $approvalType === 'reviewal' ? DocumentReviewalPending::class : DocumentApprovalPending::class,
        ]);

        $documentApprovalUsers = collect($data->users)->map(function ($user) use ($approvalType) {
            return new DocumentApprovalHasUser([
                'user_id' => $user->user_id,
                'user_state' => $approvalType === 'reviewal' ? UserReviewalPending::class : UserApprovalPending::class,
            ]);
        });

        $documentApproval->documentApprovalUsers()->saveMany($documentApprovalUsers);

        $this->sendDocumentApprovalNotificationAction->execute($documentApproval);

        return $documentApproval;
    }
}
