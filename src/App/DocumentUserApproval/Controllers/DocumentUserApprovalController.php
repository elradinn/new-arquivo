<?php

namespace App\DocumentUserApproval\Controllers;

use Illuminate\Http\JsonResponse;
use App\Common\Controllers\Controller;
use Domain\DocumentApprovalHasUser\Models\DocumentApprovalHasUser;
use Domain\DocumentApprovalHasUser\States\UserApprovalAccepted;
use Domain\DocumentApprovalHasUser\States\UserApprovalPending;
use Domain\DocumentApprovalHasUser\States\UserApprovalRejected;
use Domain\DocumentApprovalHasUser\States\UserReviewalAccepted;
use Domain\DocumentApprovalHasUser\States\UserReviewalPending;
use Domain\DocumentApprovalHasUser\States\UserReviewalRejected;

class DocumentUserApprovalController extends Controller
{
    public function accept(DocumentApprovalHasUser $userApproval): JsonResponse
    {
        if ($userApproval->user_state instanceof UserReviewalPending) {
            $userApproval->user_state->transitionTo(UserReviewalAccepted::class);
        } else if ($userApproval->user_state instanceof UserApprovalPending) {
            $userApproval->user_state->transitionTo(UserApprovalAccepted::class);
        }

        return response()->json($userApproval);
    }

    public function reject(DocumentApprovalHasUser $userApproval): JsonResponse
    {
        if ($userApproval->user_state instanceof UserReviewalPending) {
            $userApproval->user_state->transitionTo(UserReviewalRejected::class);
        } else if ($userApproval->user_state instanceof UserApprovalPending) {
            $userApproval->user_state->transitionTo(UserApprovalRejected::class);
        }

        return response()->json($userApproval);
    }
}
