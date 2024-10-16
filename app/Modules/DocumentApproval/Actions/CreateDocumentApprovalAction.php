<?php

namespace Modules\DocumentApproval\Actions;

use Modules\DocumentApproval\States\DocumentApprovalPending;
use Modules\DocumentApproval\States\DocumentReviewalPending;
use Modules\DocumentApproval\Data\CreateDocumentApprovalData;
use Modules\DocumentApproval\Models\DocumentApproval;
use Modules\DocumentApprovalHasUser\Models\DocumentApprovalHasUser;
use Modules\DocumentApprovalHasUser\States\UserApprovalPending;
use Modules\DocumentApprovalHasUser\States\UserReviewalPending;

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

        $documentApproval->document->update([
            'status' => $approvalType === 'reviewal' ? DocumentReviewalPending::class : DocumentApprovalPending::class,
        ]);

        $this->sendDocumentApprovalNotificationAction->execute($documentApproval);

        return $documentApproval;
    }
}
