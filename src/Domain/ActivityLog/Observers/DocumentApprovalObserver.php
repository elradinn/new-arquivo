<?php

namespace Domain\ActivityLog\Observers;

use Domain\DocumentApproval\Models\DocumentApproval;
use Spatie\Activitylog\Models\Activity;

class DocumentApprovalObserver
{
    public function created(DocumentApproval $documentApproval)
    {
        activity()
            ->performedOn($documentApproval)
            ->causedBy(auth()->user())
            ->log("Document Approval created: {$documentApproval->id}");
    }

    public function updated(DocumentApproval $documentApproval)
    {
        activity()
            ->performedOn($documentApproval)
            ->causedBy(auth()->user())
            ->log("Document Approval updated: {$documentApproval->id}");
    }

    public function deleted(DocumentApproval $documentApproval)
    {
        activity()
            ->performedOn($documentApproval)
            ->causedBy(auth()->user())
            ->log("Document Approval deleted: {$documentApproval->id}");
    }
}
