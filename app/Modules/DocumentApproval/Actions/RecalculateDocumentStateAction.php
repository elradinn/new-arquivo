<?php

namespace Modules\DocumentApproval\Actions;

use Modules\DocumentApproval\Models\DocumentApproval;

use Modules\DocumentApproval\States\DocumentApprovalRejected;
use Modules\DocumentApproval\States\DocumentApprovalAccepted;
use Modules\DocumentApproval\States\DocumentReviewalRejected;
use Modules\DocumentApproval\States\DocumentReviewalAccepted;

use Modules\DocumentApprovalHasUser\States\UserReviewalPending;
use Modules\DocumentApprovalHasUser\States\UserReviewalRejected;
use Modules\DocumentApprovalHasUser\States\UserReviewalAccepted;
use Modules\DocumentApprovalHasUser\States\UserApprovalPending;
use Modules\DocumentApprovalHasUser\States\UserApprovalRejected;
use Modules\DocumentApprovalHasUser\States\UserApprovalAccepted;

class RecalculateDocumentStateAction
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

        $documentApproval->document->update([
            'status' => $documentApproval->overall_state->label(),
        ]);
    }
}
