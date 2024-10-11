<?php

namespace Modules\DocumentApprovalHasUser\Controllers;

use Illuminate\Http\JsonResponse;
use Modules\Common\Controllers\Controller;
use Modules\DocumentApprovalHasUser\Actions\CheckUserApprovalTypeAction;
use Modules\DocumentApprovalHasUser\Models\DocumentApprovalHasUser;

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