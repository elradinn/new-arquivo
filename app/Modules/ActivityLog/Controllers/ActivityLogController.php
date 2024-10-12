<?php

namespace App\Modules\ActivityLog\Controllers;

use Inertia\Inertia;
use Modules\Common\Controllers\Controller;

class ActivityLogController extends Controller
{
    public function index()
    {
        return Inertia::render('ActivityLog/ActivityLog.page');
    }
}
