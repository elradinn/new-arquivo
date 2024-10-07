<?php

namespace App\DocumentUserApproval\Controllers;

use Illuminate\Http\JsonResponse;
use App\Common\Controllers\Controller;
use Domain\DocumentApprovalHasUser\Actions\CheckUserApprovalTypeAction;
use Domain\DocumentApprovalHasUser\Models\DocumentApprovalHasUser;

class DocumentUserApprovalController extends Controller
{
    public function __construct(
        protected CheckUserApprovalTypeAction $checkUserApprovalTypeAction,
    ) {}

    public function accept(DocumentApprovalHasUser $userApproval): JsonResponse
    {
        $this->checkUserApprovalTypeAction->accept($userApproval);

        return response()->json($userApproval);
    }

    public function reject(DocumentApprovalHasUser $userApproval): JsonResponse
    {
        $this->checkUserApprovalTypeAction->reject($userApproval);

        return response()->json($userApproval);
    }
}
