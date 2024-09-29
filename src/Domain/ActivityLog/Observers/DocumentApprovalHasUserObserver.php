<?php

namespace Domain\ActivityLog\Observers;

use Domain\DocumentApprovalHasUser\Models\DocumentApprovalHasUser;
use Spatie\Activitylog\Models\Activity;

class DocumentApprovalHasUserObserver
{
    public function updated(DocumentApprovalHasUser $userApproval)
    {
        if ($userApproval->isDirty('user_state')) {
            $oldState = $userApproval->getOriginal('user_state');
            $newState = $userApproval->user_state->label();

            activity()
                ->performedOn($userApproval)
                ->causedBy(auth()->user())
                ->withProperties([
                    'old_state' => $oldState,
                    'new_state' => $newState,
                ])
                ->log("User approval state changed from {$oldState} to {$newState}");
        }
    }
}
