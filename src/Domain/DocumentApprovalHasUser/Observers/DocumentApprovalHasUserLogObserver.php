<?php

namespace Domain\DocumentApprovalHasUser\Observers;

use Domain\DocumentApprovalHasUser\Models\DocumentApprovalHasUser;
use Illuminate\Support\Facades\Auth;

class DocumentApprovalHasUserLogObserver
{
    public function updated(DocumentApprovalHasUser $userApproval)
    {
        if ($userApproval->isDirty('user_state')) {
            $oldState = $userApproval->getOriginal('user_state');
            $newState = $userApproval->user_state->label();

            activity()
                ->performedOn($userApproval)
                ->causedBy(Auth::id())
                ->withProperties([
                    'old_state' => $oldState,
                    'new_state' => $newState,
                ])
                ->log("User approval state changed from {$oldState} to {$newState}");
        }
    }
}
