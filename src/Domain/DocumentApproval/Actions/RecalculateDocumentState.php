<?php

namespace Domain\DocumentApproval\Actions;

use Domain\DocumentApproval\Models\DocumentApproval;

use App\Domain\DocumentApproval\States\DocumentApprovalRejected;
use App\Domain\DocumentApproval\States\DocumentApprovalAccepted;
use App\Domain\DocumentApproval\States\DocumentReviewalRejected;
use App\Domain\DocumentApproval\States\DocumentReviewalAccepted;

use Domain\DocumentApprovalHasUser\States\UserReviewalPending;
use Domain\DocumentApprovalHasUser\States\UserReviewalRejected;
use Domain\DocumentApprovalHasUser\States\UserReviewalAccepted;
use Domain\DocumentApprovalHasUser\States\UserApprovalPending;
use Domain\DocumentApprovalHasUser\States\UserApprovalRejected;
use Domain\DocumentApprovalHasUser\States\UserApprovalAccepted;

class RecalculateDocumentState
{
    public function execute(DocumentApproval $documentApproval): void
    {
        $documentApprovalUsers = $documentApproval->documentApprovalUsers;

        if ($documentApproval->type == 'reviewal') {
            if ($documentApprovalUsers->contains('user_state', UserReviewalPending::class)) {
                return;
            }

            if ($documentApprovalUsers->contains('user_state', UserReviewalRejected::class)) {
                $documentApproval->overall_state->transitionTo(DocumentReviewalRejected::class);
            } elseif ($documentApprovalUsers->every('user_state', UserReviewalAccepted::class)) {
                $documentApproval->overall_state->transitionTo(DocumentReviewalAccepted::class);
            }
        } else if ($documentApproval->type == 'approval') {
            if ($documentApprovalUsers->contains('user_state', UserApprovalPending::class)) {
                return;
            }

            if ($documentApprovalUsers->contains('user_state', UserApprovalRejected::class)) {
                $documentApproval->overall_state->transitionTo(DocumentApprovalRejected::class);
            } elseif ($documentApprovalUsers->every('user_state', UserApprovalAccepted::class)) {
                $documentApproval->overall_state->transitionTo(DocumentApprovalAccepted::class);
            }
        }
    }
}
