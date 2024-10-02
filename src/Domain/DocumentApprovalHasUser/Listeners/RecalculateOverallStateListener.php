<?php

namespace Domain\DocumentApprovalHasUser\Listeners;

use Domain\DocumentApproval\Actions\RecalculateApprovalStateAction;
use Domain\DocumentApprovalHasUser\Events\UserApprovalUpdated;

class RecalculateOverallStateListener
{
    public function __construct(
        protected RecalculateApprovalStateAction $recalculateApprovalStateAction
    ) {}

    /**
     * Handle the event.
     *
     * @param  \Domain\DocumentApprovalHasUser\Events\UserApprovalUpdated  $event
     * @return void
     */
    public function handle(UserApprovalUpdated $event)
    {
        // Recalculate the overall state when a user's decision is updated
        $this->recalculateApprovalStateAction->execute($event->documentApproval);
    }
}
