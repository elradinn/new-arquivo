<?php

namespace Modules\DocumentApprovalHasUser\States;

use Illuminate\Support\Facades\Auth;
use Spatie\ModelStates\Transition;
use Modules\DocumentApprovalHasUser\Models\DocumentApprovalHasUser;
use Modules\DocumentApproval\Actions\SendDocumentApprovalNotificationAction;
use Modules\DocumentApproval\Actions\RecalculateDocumentStateAction;
use Modules\DocumentApprovalHasUser\States\UserApprovalRejected;

class UserApprovalPendingToRejected extends Transition
{
    public function __construct(
        private DocumentApprovalHasUser $documentApprovalHasUser,
    ) {}

    public function handle(
        SendDocumentApprovalNotificationAction $sendDocumentApprovalNotification,
        RecalculateDocumentStateAction $recalculateDocumentStateAction
    ): DocumentApprovalHasUser {

        $this->documentApprovalHasUser->user_state = new UserApprovalRejected($this->documentApprovalHasUser);
        $this->documentApprovalHasUser->save();

        $sendDocumentApprovalNotification->execute($this->documentApprovalHasUser->documentApproval);

        $recalculateDocumentStateAction->execute($this->documentApprovalHasUser->documentApproval);

        activity()
            ->performedOn($this->documentApprovalHasUser)
            ->causedBy(Auth::id())
            ->log("Document approval rejected");

        return $this->documentApprovalHasUser;
    }
}
