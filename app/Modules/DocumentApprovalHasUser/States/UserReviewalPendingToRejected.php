<?php

namespace Modules\DocumentApprovalHasUser\States;

use Illuminate\Support\Facades\Auth;
use Spatie\ModelStates\Transition;
use Modules\DocumentApprovalHasUser\Models\DocumentApprovalHasUser;
use Modules\DocumentApproval\Actions\SendDocumentApprovalNotificationAction;
use Modules\DocumentApproval\Actions\RecalculateDocumentStateAction;
use Modules\DocumentApprovalHasUser\States\UserReviewalRejected;

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
