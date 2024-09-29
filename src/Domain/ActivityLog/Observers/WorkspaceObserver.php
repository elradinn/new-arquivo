<?php

namespace Domain\ActivityLog\Observers;

use Domain\Workspace\Models\Workspace;
use Spatie\Activitylog\Models\Activity;

class WorkspaceObserver
{
    public function created(Workspace $workspace)
    {
        activity()
            ->performedOn($workspace)
            ->causedBy(auth()->user())
            ->log("Workspace created: {$workspace->name}");
    }

    public function updated(Workspace $workspace)
    {
        activity()
            ->performedOn($workspace)
            ->causedBy(auth()->user())
            ->log("Workspace updated: {$workspace->name}");
    }

    public function deleted(Workspace $workspace)
    {
        activity()
            ->performedOn($workspace)
            ->causedBy(auth()->user())
            ->log("Workspace deleted: {$workspace->name}");
    }
}
