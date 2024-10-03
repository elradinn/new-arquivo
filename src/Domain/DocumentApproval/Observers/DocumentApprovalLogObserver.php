<?php

namespace Domain\DocumentApproval\Observers;

use Domain\DocumentApproval\Models\DocumentApproval;
use Illuminate\Support\Facades\Auth;

class DocumentApprovalLogObserver
{
    public function created(DocumentApproval $documentApproval)
    {
        activity()
            ->performedOn($documentApproval)
            ->causedBy(Auth::id())
            ->log("Document Approval created: {$documentApproval->id}");
    }

    public function updated(DocumentApproval $documentApproval)
    {
        activity()
            ->performedOn($documentApproval)
            ->causedBy(Auth::id())
            ->log("Document Approval updated: {$documentApproval->id}");
    }

    public function deleted(DocumentApproval $documentApproval)
    {
        activity()
            ->performedOn($documentApproval)
            ->causedBy(Auth::id())
            ->log("Document Approval deleted: {$documentApproval->id}");
    }
}
