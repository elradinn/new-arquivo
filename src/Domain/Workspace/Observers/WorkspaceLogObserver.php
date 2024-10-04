<?php

namespace Domain\Workspace\Observers;

use Domain\Workspace\Models\Workspace;
use Illuminate\Support\Facades\Auth;

class WorkspaceLogObserver
{
    public function created(Workspace $workspace)
    {
        activity()
            ->performedOn($workspace)
            ->causedBy(Auth::id())
            ->log("Workspace created: {$workspace->name}");
    }

    public function updated(Workspace $workspace)
    {
        activity()
            ->performedOn($workspace)
            ->causedBy(Auth::id())
            ->log("Workspace updated: {$workspace->name}");
    }

    public function deleted(Workspace $workspace)
    {
        activity()
            ->performedOn($workspace)
            ->causedBy(Auth::id())
            ->log("Workspace deleted: {$workspace->name}");
    }
}
