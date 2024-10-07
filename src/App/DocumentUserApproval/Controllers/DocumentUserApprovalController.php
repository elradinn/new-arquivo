<?php

namespace App\DocumentUserApproval\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Common\Controllers\Controller;
use Domain\DocumentApprovalHasUser\Models\DocumentApprovalHasUser;
use Domain\DocumentApprovalHasUser\States\UserApprovalAccepted;
use Domain\DocumentApprovalHasUser\States\UserApprovalRejected;
use Domain\DocumentApprovalHasUser\States\UserReviewalAccepted;
use Domain\DocumentApprovalHasUser\States\UserReviewalRejected;

class DocumentUserApprovalController extends Controller
{
    public function acceptReviewal(Request $request, $documentApprovalId): JsonResponse
    {
        $userApproval = DocumentApprovalHasUser::where('document_approval_id', $documentApprovalId)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $userApproval->user_state->transitionTo(UserReviewalAccepted::class);

        return response()->json(['message' => 'Document approval accepted.']);
    }

    public function rejectReviewal(Request $request, $documentApprovalId): JsonResponse
    {
        $userApproval = DocumentApprovalHasUser::where('document_approval_id', $documentApprovalId)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $userApproval->user_state->transitionTo(UserReviewalRejected::class);

        return response()->json(['message' => 'Document approval rejected.']);
    }

    public function acceptApproval(Request $request, $documentApprovalId): JsonResponse
    {
        $userApproval = DocumentApprovalHasUser::where('document_approval_id', $documentApprovalId)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $userApproval->user_state->transitionTo(UserApprovalAccepted::class);

        return response()->json(['message' => 'Document approval accepted.']);
    }

    public function rejectApproval(Request $request, $documentApprovalId): JsonResponse
    {
        $userApproval = DocumentApprovalHasUser::where('document_approval_id', $documentApprovalId)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $userApproval->user_state->transitionTo(UserApprovalRejected::class);

        return response()->json(['message' => 'Document approval rejected.']);
    }
}
