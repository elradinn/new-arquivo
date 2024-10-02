<?php

namespace Domain\Folder\Observers;

use Domain\Folder\Models\Folder;
use Illuminate\Support\Facades\Auth;

class FolderLoggingObserver
{
    public function created(Folder $folder)
    {
        activity()
            ->performedOn($folder)
            ->causedBy(Auth::id())
            ->log("Folder created: {$folder->name}");
    }

    public function updated(Folder $folder)
    {
        activity()
            ->performedOn($folder)
            ->causedBy(Auth::id())
            ->log("Folder updated: {$folder->name}");
    }

    public function deleted(Folder $folder)
    {
        activity()
            ->performedOn($folder)
            ->causedBy(Auth::id())
            ->log("Folder deleted: {$folder->name}");
    }
}
