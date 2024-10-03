<?php

namespace Domain\Metadata\Observers;

use Domain\Metadata\Models\Metadata;
use Illuminate\Support\Facades\Auth;

class MetadataLogObserver
{
    public function created(Metadata $metadata)
    {
        activity()
            ->performedOn($metadata)
            ->causedBy(Auth::id())
            ->log("Metadata created: {$metadata->name}");
    }

    public function updated(Metadata $metadata)
    {
        activity()
            ->performedOn($metadata)
            ->causedBy(Auth::id())
            ->log("Metadata updated: {$metadata->name}");
    }

    public function deleted(Metadata $metadata)
    {
        activity()
            ->performedOn($metadata)
            ->causedBy(Auth::id())
            ->log("Metadata deleted: {$metadata->name}");
    }
}
