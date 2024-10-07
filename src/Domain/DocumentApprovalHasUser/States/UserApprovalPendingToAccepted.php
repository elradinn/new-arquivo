<?php

namespace Domain\DocumentApprovalHasUser\States;

use Illuminate\Support\Facades\Auth;
use Spatie\ModelStates\Transition;
use Domain\DocumentApprovalHasUser\Models\DocumentApprovalHasUser;
use Domain\DocumentApproval\Actions\RecalculateDocumentState;
use Domain\DocumentApproval\Actions\SendDocumentApprovalNotificationAction;
use Domain\DocumentApprovalHasUser\States\UserApprovalAccepted;

class UserApprovalPendingToAccepted extends Transition
{
    public function __construct(
        private DocumentApprovalHasUser $documentApprovalHasUser,
    ) {}

    public function handle(
        SendDocumentApprovalNotificationAction $sendDocumentApprovalNotification,
        RecalculateDocumentState $recalculateDocumentState
    ): DocumentApprovalHasUser {

        $this->documentApprovalHasUser->user_state = new UserApprovalAccepted($this->documentApprovalHasUser);
        $this->documentApprovalHasUser->save();

        $sendDocumentApprovalNotification->execute($this->documentApprovalHasUser->documentApproval);

        $recalculateDocumentState->execute($this->documentApprovalHasUser->documentApproval);

        activity()
            ->performedOn($this->documentApprovalHasUser)
            ->causedBy(Auth::id())
            ->log("Document approval accepted");

        return $this->documentApprovalHasUser;
    }
}
