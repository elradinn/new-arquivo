<?php

namespace Modules\DocumentApprovalHasUser\Actions;

use Modules\DocumentApprovalHasUser\Models\DocumentApprovalHasUser;
use Modules\DocumentApprovalHasUser\States\UserApprovalAccepted;
use Modules\DocumentApprovalHasUser\States\UserApprovalPending;
use Modules\DocumentApprovalHasUser\States\UserApprovalRejected;
use Modules\DocumentApprovalHasUser\States\UserReviewalAccepted;
use Modules\DocumentApprovalHasUser\States\UserReviewalPending;
use Modules\DocumentApprovalHasUser\States\UserReviewalRejected;

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
