<?php

namespace Domain\DocumentApproval\Actions;

use Domain\DocumentApproval\Models\DocumentApproval;
use Domain\DocumentApproval\States\Approved;
use Domain\DocumentApproval\States\Pending;
use Domain\DocumentApproval\States\Rejected;
use Domain\DocumentApprovalHasUser\States\Rejected as UserRejected;
use Domain\DocumentApprovalHasUser\States\Approved as UserApproved;
use Domain\DocumentApprovalHasUser\States\Pending as UserPending;


class RecalculateApprovalState
{
    protected $documentApproval;

    public function __construct(DocumentApproval $documentApproval)
    {
        $this->documentApproval = $documentApproval;
    }

    /**
     * Execute the action to recalculate the overall state of the document approval.
     */
    public function execute()
    {
        $documentApprovalUsers = $this->documentApproval->documentApprovalUsers;


        if ($documentApprovalUsers->contains('user_state', UserPending::class)) {
            return;
        }

        if ($documentApprovalUsers->contains('user_state', UserRejected::class)) {
            $this->documentApproval->overall_state->transitionTo(Rejected::class);
        } elseif ($documentApprovalUsers->every('user_state', UserApproved::class)) {
            $this->documentApproval->overall_state->transitionTo(Approved::class);
        }
    }
}
