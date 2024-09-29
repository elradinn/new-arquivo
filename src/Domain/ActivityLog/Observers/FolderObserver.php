<?php

namespace Domain\ActivityLog\Observers;

use Domain\Folder\Models\Folder;
use Spatie\Activitylog\Models\Activity;

class FolderObserver
{
    public function created(Folder $folder)
    {
        activity()
            ->performedOn($folder)
            ->causedBy(auth()->user())
            ->log("Folder created: {$folder->name}");
    }

    public function updated(Folder $folder)
    {
        activity()
            ->performedOn($folder)
            ->causedBy(auth()->user())
            ->log("Folder updated: {$folder->name}");
    }

    public function deleted(Folder $folder)
    {
        activity()
            ->performedOn($folder)
            ->causedBy(auth()->user())
            ->log("Folder deleted: {$folder->name}");
    }
}
