<?php

namespace App\DocumentUserApproval\Controllers;

use App\Common\Controllers\Controller;
use Domain\DocumentApprovalHasUser\Models\DocumentApprovalHasUser;
use Domain\DocumentApprovalHasUser\States\Review\Accept;
use Domain\DocumentApprovalHasUser\States\UserApproved;
use Domain\DocumentApprovalHasUser\States\UserRejected;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DocumentUserApprovalController extends Controller
{
    public function accept(Request $request, $documentApprovalId): JsonResponse
    {
        $userApproval = DocumentApprovalHasUser::where('document_approval_id', $documentApprovalId)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $userApproval->user_state->transitionTo(Accept::class);

        return response()->json(['message' => 'Document approval accepted.']);
    }

    public function reject(Request $request, $documentApprovalId): JsonResponse
    {
        $userApproval = DocumentApprovalHasUser::where('document_approval_id', $documentApprovalId)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $userApproval->user_state->transitionTo(UserRejected::class);

        return response()->json(['message' => 'Document approval rejected.']);
    }
}
