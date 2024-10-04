<?php

namespace App\DocumentUserApproval\Controllers;

use App\Common\Controllers\Controller;
use Domain\DocumentApprovalHasUser\Models\DocumentApprovalHasUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DocumentUserApprovalController extends Controller
{
    public function accept(Request $request, $documentApprovalId): JsonResponse
    {
        $userApproval = DocumentApprovalHasUser::where('document_approval_id', $documentApprovalId)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $userApproval->user_state->transitionTo(\Domain\DocumentApprovalHasUser\States\UserApproved::class);

        return response()->json(['message' => 'Document approval accepted.']);
    }

    public function reject(Request $request, $documentApprovalId): JsonResponse
    {
        $userApproval = DocumentApprovalHasUser::where('document_approval_id', $documentApprovalId)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $userApproval->user_state->transitionTo(\Domain\DocumentApprovalHasUser\States\UserRejected::class);

        return response()->json(['message' => 'Document approval rejected.']);
    }
}
