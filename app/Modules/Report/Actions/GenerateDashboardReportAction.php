<?php

namespace Modules\Report\Actions;

use Modules\Dashboard\Data\DashboardReportParametersData;
use Modules\Metadata\Models\Metadata;
use Modules\Dashboard\Helpers\DocumentStatusHelper;
use Modules\Item\Data\ItemContentsResourceData;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Modules\Dashboard\Data\DashboardMetadataResourceData;
use Modules\Item\Models\Item;

class GenerateDashboardReportAction
{
    public function execute(DashboardReportParametersData $data): array
    {
        // Fetch selected metadata
        $selectedMetadataIds = $data->metadata_ids;
        $selectedMetadata = Metadata::whereIn('id', $selectedMetadataIds)->get();

        // Query documents based on filters
        $documentsQuery = Item::query()->with('document')->whereHas('document');

        // Apply document status filter
        if ($data->document_status) {
            $statusClass = DocumentStatusHelper::getStatusClass($data->document_status);
            if ($statusClass) {
                $documentsQuery->whereHas('document', function ($query) use ($statusClass) {
                    $query->where('status', $statusClass);
                });
            }
        }

        // Apply date range filter
        if ($data->start_date && $data->end_date) {
            $documentsQuery->whereHas('document', function ($query) use ($data) {
                $query->whereBetween('updated_at', [$data->start_date, $data->end_date]);
            });
        }

        // Fetch documents
        $documents = $documentsQuery->paginate(15);

        // Render the report view
        $headerPath = public_path() . '/images/report-header.png';
        $footerPath = public_path() . '/images/report-footer.png';

        $headerType = pathinfo($headerPath, PATHINFO_EXTENSION);
        $footerType = pathinfo($footerPath, PATHINFO_EXTENSION);

        $headerData = file_get_contents($headerPath);
        $footerData = file_get_contents($footerPath);

        $headerImage = 'data:image/' . $headerType . ';base64,' . base64_encode($headerData);
        $footerImage = 'data:image/' . $footerType . ';base64,' . base64_encode($footerData);

        $pdf = Pdf::loadView('report.dashboard_report', [
            'items' => ItemContentsResourceData::collect($documents),
            'selectedMetadata' => DashboardMetadataResourceData::collect($selectedMetadata),
            'header' => $headerImage,
            'footer' => $footerImage,
        ])->setPaper('a4');

        // Generate a unique filename
        $filename = 'dashboard_report_' . Str::random(10) . '.pdf';
        $path = 'reports/' . $filename;

        // Save the PDF to storage (e.g., public disk)
        Storage::disk('public')->put($path, $pdf->output());

        // Generate a URL to the stored PDF
        $url = Storage::url($path);

        return [
            'url' => $url,
            'filename' => $filename,
        ];
    }
}
