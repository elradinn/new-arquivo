<?php

namespace Domain\Document\Observers;

use Domain\Document\Models\Document;
use Illuminate\Support\Facades\Auth;

class DocumentLogObserver
{
    public function created(Document $document)
    {
        activity()
            ->performedOn($document)
            ->causedBy(Auth::id())
            ->log("Document created: {$document->name}");
    }

    public function updated(Document $document)
    {
        activity()
            ->performedOn($document)
            ->causedBy(Auth::id())
            ->log("Document updated: {$document->name}");
    }

    public function deleted(Document $document)
    {
        activity()
            ->performedOn($document)
            ->causedBy(Auth::id())
            ->log("Document deleted: {$document->name}");
    }
}
