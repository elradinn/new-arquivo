<?php

namespace Domain\Workflow\Observers;

use Domain\Workflow\Models\Workflow;
use Illuminate\Support\Facades\Auth;

class WorkflowLogObserver
{
    public function created(Workflow $workflow)
    {
        activity()
            ->performedOn($workflow)
            ->causedBy(Auth::id())
            ->log("Workflow created: {$workflow->id}");
    }

    public function updated(Workflow $workflow)
    {
        activity()
            ->performedOn($workflow)
            ->causedBy(Auth::id())
            ->log("Workflow updated: {$workflow->id}");
    }

    public function deleted(Workflow $workflow)
    {
        activity()
            ->performedOn($workflow)
            ->causedBy(Auth::id())
            ->log("Workflow deleted: {$workflow->id}");
    }
}
