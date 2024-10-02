<?php

namespace Domain\DocumentApproval\Actions;

use Domain\DocumentApproval\Models\DocumentApproval;

use Domain\DocumentApproval\States\DocumentApproved;
use Domain\DocumentApproval\States\DocumentRejected;

use Domain\DocumentApprovalHasUser\States\UserRejected;
use Domain\DocumentApprovalHasUser\States\UserApproved;
use Domain\DocumentApprovalHasUser\States\UserPending;

class RecalculateApprovalStateAction
{
    protected $documentApproval;

    public function __construct(DocumentApproval $documentApproval)
    {
        $this->documentApproval = $documentApproval;
    }

    /**
     * Execute the action to recalculate the overall state of the document approval.
     */
    public function execute(): void
    {
        $documentApprovalUsers = $this->documentApproval->documentApprovalUsers;


        if ($documentApprovalUsers->contains('user_state', UserPending::class)) {
            return;
        }

        if ($documentApprovalUsers->contains('user_state', UserRejected::class)) {
            $this->documentApproval->overall_state->transitionTo(DocumentRejected::class);
        } elseif ($documentApprovalUsers->every('user_state', UserApproved::class)) {
            $this->documentApproval->overall_state->transitionTo(DocumentApproved::class);
        }
    }
}
