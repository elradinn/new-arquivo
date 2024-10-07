<?php

namespace Domain\DocumentApprovalHasUser\States;

use Illuminate\Support\Facades\Auth;
use Spatie\ModelStates\Transition;
use Domain\DocumentApprovalHasUser\Models\DocumentApprovalHasUser;
use Domain\DocumentApproval\Actions\SendDocumentApprovalNotificationAction;
use Domain\DocumentApproval\Actions\RecalculateDocumentStateAction;
use Domain\DocumentApprovalHasUser\States\UserReviewalRejected;

class UserReviewalPendingToRejected extends Transition
{
    public function __construct(
        private DocumentApprovalHasUser $documentApprovalHasUser,
    ) {}

    public function handle(
        SendDocumentApprovalNotificationAction $sendDocumentApprovalNotification,
        RecalculateDocumentStateAction $recalculateDocumentStateAction
    ): DocumentApprovalHasUser {

        $this->documentApprovalHasUser->user_state = new UserReviewalRejected($this->documentApprovalHasUser);
        $this->documentApprovalHasUser->save();

        $sendDocumentApprovalNotification->execute($this->documentApprovalHasUser->documentApproval);

        $recalculateDocumentStateAction->execute($this->documentApprovalHasUser->documentApproval);

        activity()
            ->performedOn($this->documentApprovalHasUser)
            ->causedBy(Auth::id())
            ->log("Document reviewal rejected");

        return $this->documentApprovalHasUser;
    }
}
