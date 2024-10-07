<?php

namespace App\DocumentApproval\Controllers;

use Illuminate\Http\JsonResponse;
use App\Common\Controllers\Controller;
use Domain\DocumentApproval\Actions\CreateDocumentApprovalAction;
use Domain\DocumentApproval\Data\CreateDocumentApprovalData;
use Domain\DocumentApproval\Data\DocumentApprovalResourceData;
use Domain\DocumentApproval\Models\DocumentApproval;

class DocumentApprovalController extends Controller
{
    public function show(DocumentApproval $documentApproval): JsonResponse
    {
        return response()->json(DocumentApprovalResourceData::fromModel($documentApproval));
    }

    public function store(
        CreateDocumentApprovalData $data,
        CreateDocumentApprovalAction $createDocumentApprovalAction
    ): JsonResponse {

        $documentApproval = $createDocumentApprovalAction->execute($data);

        return response()->json($documentApproval, 201);
    }
}
