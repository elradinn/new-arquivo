<?php

namespace Domain\Workspace\Observers;

use Domain\Workspace\Models\Workspace;
use Illuminate\Support\Facades\Auth;

class WorkspaceLoggingObserver
{
    public function created(Workspace $workspace)
    {
        activity()
            ->performedOn($workspace)
            ->causedBy(Auth::id())
            ->log("Workspace created: {$workspace->id}");
    }

    public function updated(Workspace $workspace)
    {
        activity()
            ->performedOn($workspace)
            ->causedBy(Auth::id())
            ->log("Workspace updated: {$workspace->id}");
    }

    public function deleted(Workspace $workspace)
    {
        activity()
            ->performedOn($workspace)
            ->causedBy(Auth::id())
            ->log("Workspace deleted: {$workspace->id}");
    }
}
