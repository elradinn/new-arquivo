<?php

namespace Modules\Dashboard\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;
use Modules\Common\Controllers\Controller;
use Modules\Metadata\Models\Metadata;
use Modules\Document\Models\Document;
use Modules\Dashboard\Helpers\DocumentStatusHelper;
use Modules\Document\Data\DocumentResourceData;
use Modules\Item\Data\ItemContentsResourceData;
use Modules\Item\Models\Item;

class DashboardController extends Controller
{
    public function dashboard()
    {
        return Inertia::render('Dashboard');
    }

    /**
     * Display the Dashboard Report page.
     *
     * @param Request $request
     * @return Response
     */
    public function showDashboardReport(Request $request)
    {
        // Extract filters from query parameters
        $documentStatus = $request->query('document_status'); // e.g., reviewal_pending, approval_accepted, etc.
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        // Get selected metadata columns from the dashboard_report_metadata_columns table
        $selectedMetadataIds = DB::table('dashboard_report_metadata_columns')->pluck('metadata_id')->toArray();
        $selectedMetadata = Metadata::whereIn('id', $selectedMetadataIds)->get();

        // Query documents based on filters
        $documentsQuery = Item::query()->with('document')->whereHas('document');

        // Apply document status filter
        if ($documentStatus) {
            $statusClass = DocumentStatusHelper::getStatusClass($documentStatus);
            if ($statusClass) {
                $documentsQuery->whereHas('document', function ($query) use ($statusClass) {
                    $query->where('status', $statusClass);
                });
            }
        }

        // Apply date range filter
        if ($startDate && $endDate) {
            $documentsQuery->whereHas('document', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('updated_at', [$startDate, $endDate]);
            });
        }

        // Eager load metadata if needed
        if ($selectedMetadata->isNotEmpty()) {
            $documentsQuery->with(['metadata' => function ($query) use ($selectedMetadataIds) {
                $query->whereIn('metadata_id', $selectedMetadataIds);
            }]);
        }

        // Paginate results
        $documents = $documentsQuery->paginate(15);

        // Pass data to Inertia
        return Inertia::render('DashboardReport', [
            'documents' => ItemContentsResourceData::collect($documents),
            'filters' => [
                'document_status' => $documentStatus,
                'start_date' => $startDate,
                'end_date' => $endDate,
            ],
            'selectedMetadata' => $selectedMetadata,
        ]);
    }
}
