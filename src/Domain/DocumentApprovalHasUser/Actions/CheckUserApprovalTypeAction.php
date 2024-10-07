<?php

namespace Domain\DocumentApprovalHasUser\Actions;

use Domain\DocumentApprovalHasUser\Models\DocumentApprovalHasUser;
use Domain\DocumentApprovalHasUser\States\UserApprovalAccepted;
use Domain\DocumentApprovalHasUser\States\UserApprovalPending;
use Domain\DocumentApprovalHasUser\States\UserApprovalRejected;
use Domain\DocumentApprovalHasUser\States\UserReviewalAccepted;
use Domain\DocumentApprovalHasUser\States\UserReviewalPending;
use Domain\DocumentApprovalHasUser\States\UserReviewalRejected;

class CheckUserApprovalTypeAction
{
    public function accept(DocumentApprovalHasUser $userApproval): void
    {
        if ($userApproval->user_state instanceof UserReviewalPending) {
            $userApproval->user_state->transitionTo(UserReviewalAccepted::class);
        } else if ($userApproval->user_state instanceof UserApprovalPending) {
            $userApproval->user_state->transitionTo(UserApprovalAccepted::class);
        }
    }

    public function reject(DocumentApprovalHasUser $userApproval): void
    {
        if ($userApproval->user_state instanceof UserReviewalPending) {
            $userApproval->user_state->transitionTo(UserReviewalRejected::class);
        } else if ($userApproval->user_state instanceof UserApprovalPending) {
            $userApproval->user_state->transitionTo(UserApprovalRejected::class);
        }
    }
}
