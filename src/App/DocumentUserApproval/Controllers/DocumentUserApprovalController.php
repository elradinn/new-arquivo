<?php

namespace App\DocumentUserApproval\Controllers;

use Illuminate\Http\JsonResponse;
use App\Common\Controllers\Controller;
use Domain\DocumentApproval\Data\DocumentApprovalResourceData;
use Domain\DocumentApprovalHasUser\Models\DocumentApprovalHasUser;
use Domain\DocumentApprovalHasUser\States\UserApprovalAccepted;
use Domain\DocumentApprovalHasUser\States\UserApprovalRejected;
use Domain\DocumentApprovalHasUser\States\UserReviewalAccepted;
use Domain\DocumentApprovalHasUser\States\UserReviewalRejected;

class DocumentUserApprovalController extends Controller
{
    public function show(DocumentApprovalHasUser $userApproval): JsonResponse
    {
        return response()->json(DocumentApprovalResourceData::fromModel($userApproval->documentApproval));
    }

    public function acceptReviewal(DocumentApprovalHasUser $userApproval): JsonResponse
    {
        $userApproval->user_state->transitionTo(UserReviewalAccepted::class);

        return response()->json($userApproval);
    }

    public function rejectReviewal(DocumentApprovalHasUser $userApproval): JsonResponse
    {
        $userApproval->user_state->transitionTo(UserReviewalRejected::class);

        return response()->json($userApproval);
    }

    public function acceptApproval(DocumentApprovalHasUser $userApproval): JsonResponse
    {
        $userApproval->user_state->transitionTo(UserApprovalAccepted::class);

        return response()->json($userApproval);
    }

    public function rejectApproval(DocumentApprovalHasUser $userApproval): JsonResponse
    {
        $userApproval->user_state->transitionTo(UserApprovalRejected::class);

        return response()->json($userApproval);
    }
}
