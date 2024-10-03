<?php

namespace Domain\NumberingScheme\Observers;

use Domain\NumberingScheme\Models\NumberingScheme;
use Illuminate\Support\Facades\Auth;

class NumberingSchemeLogObserver
{
    public function created(NumberingScheme $numberingScheme)
    {
        activity()
            ->performedOn($numberingScheme)
            ->causedBy(Auth::id())
            ->log("Numbering Scheme created: {$numberingScheme->id}");
    }

    public function updated(NumberingScheme $numberingScheme)
    {
        activity()
            ->performedOn($numberingScheme)
            ->causedBy(Auth::id())
            ->log("Numbering Scheme updated: {$numberingScheme->id}");
    }

    public function deleted(NumberingScheme $numberingScheme)
    {
        activity()
            ->performedOn($numberingScheme)
            ->causedBy(Auth::id())
            ->log("Numbering Scheme deleted: {$numberingScheme->id}");
    }
}
