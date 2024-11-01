<?php

namespace Modules\Dashboard\Controllers;

use Modules\Dashboard\Data\DashboardMetadataResourceData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;
use Modules\Common\Controllers\Controller;
use Modules\Dashboard\Actions\SelectDashboardReportMetadataColumnAction;
use Modules\Dashboard\Data\SelectDashboardMetadataColumnData;
use Modules\Metadata\Models\Metadata;
use Modules\Document\Models\Document;
use Modules\Dashboard\Helpers\DocumentStatusHelper;
use Modules\Document\Data\DocumentResourceData;
use Modules\Item\Data\ItemContentsResourceData;
use Modules\Item\Models\Item;

class DashboardController extends Controller
{
    public function __construct(
        protected SelectDashboardReportMetadataColumnAction $selectDashboardReportMetadataColumnAction
    ) {}

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

        // Get all available metadata
        $availableMetadata = Metadata::all();

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

        // The metadata filtering section has been removed

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
            'selectedMetadata' => DashboardMetadataResourceData::collect($selectedMetadata),
            'availableMetadata' => DashboardMetadataResourceData::collect($availableMetadata),
            'existingMetadataIds' => $selectedMetadataIds,
        ]);
    }

    public function selectDashboardMetadataColumn(SelectDashboardMetadataColumnData $data)
    {
        $this->selectDashboardReportMetadataColumnAction->execute($data);

        return redirect()->back();
    }
}
