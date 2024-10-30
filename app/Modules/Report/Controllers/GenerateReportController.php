<?php

namespace Modules\Report\Controllers;

use Modules\Common\Controllers\Controller;
use Modules\Report\Actions\GenerateReportAction;
use Modules\Report\Data\ReportParametersData;
use Illuminate\Http\Request;

class GenerateReportController extends Controller
{
    public function __construct(
        protected GenerateReportAction $generateReportAction
    ) {}

    public function generate(ReportParametersData $data)
    {
        $result = $this->generateReportAction->execute($data);

        if (isset($result['error'])) {
            return response()->json(['error' => $result['error']], 404);
        }

        return response()->json([
            'url' => $result['url'],
            'filename' => $result['filename'],
        ]);
    }
}
