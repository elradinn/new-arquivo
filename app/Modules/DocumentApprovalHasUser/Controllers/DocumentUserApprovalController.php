<?php

namespace Modules\DocumentApprovalHasUser\Controllers;

use Illuminate\Http\RedirectResponse;
use Modules\Common\Controllers\Controller;
use Modules\DocumentApprovalHasUser\Actions\CheckUserApprovalTypeAction;
use Modules\DocumentApprovalHasUser\Models\DocumentApprovalHasUser;

class DocumentUserApprovalController extends Controller
{
    public function __construct(
        protected CheckUserApprovalTypeAction $checkUserApprovalTypeAction,
    ) {}

    public function accept(DocumentApprovalHasUser $userApproval): RedirectResponse
    {
        $this->checkUserApprovalTypeAction->accept($userApproval);

        return redirect()->back();
    }

    public function reject(DocumentApprovalHasUser $userApproval): RedirectResponse
    {
        $this->checkUserApprovalTypeAction->reject($userApproval);

        return redirect()->back();
    }
}
