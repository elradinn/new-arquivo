<?php

namespace App\Modules\ActivityLog\Controllers;

use Inertia\Inertia;
use Spatie\Activitylog\Models\Activity;
use Modules\Common\Controllers\Controller;
use App\Modules\ActivityLog\Data\ActivityLogResourceData;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $activityLogs = Activity::query()
            ->when($search, function ($query, $search) {
                $searchableColumns = ['description'];

                $query->where(function ($query) use ($search, $searchableColumns) {
                    foreach ($searchableColumns as $column) {
                        $query->orWhere($column, 'like', "%{$search}%");
                    }
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('ActivityLog', [
            'activityLogs' => ActivityLogResourceData::collect($activityLogs),
            'filters' => $request->only(['search']),
        ]);
    }
}
