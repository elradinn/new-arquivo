<?php

namespace Domain\DocumentApprovalHasUser\Listeners;

use Domain\DocumentApproval\Actions\RecalculateApprovalState;
use Domain\DocumentApprovalHasUser\Events\UserApprovalUpdated;

class RecalculateOverallStateListener
{
    /**
     * Handle the event.
     *
     * @param  \Domain\DocumentApprovalHasUser\Events\UserApprovalUpdated  $event
     * @return void
     */
    public function handle(UserApprovalUpdated $event)
    {
        // Recalculate the overall state when a user's decision is updated
        $recalculateAction = new RecalculateApprovalState($event->documentApproval);
        $recalculateAction->execute();
    }
}
