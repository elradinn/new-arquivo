<?php

namespace Modules\DocumentApproval\Controllers;

use Illuminate\Http\JsonResponse;
use Inertia\Inertia;
use Inertia\Response;
use Modules\Common\Controllers\Controller;
use Modules\DocumentApproval\Actions\CreateDocumentApprovalAction;
use Modules\DocumentApproval\Data\CreateDocumentApprovalData;
use Modules\DocumentApproval\Data\DocumentApprovalResourceData;
use Modules\DocumentApproval\Models\DocumentApproval;

class DocumentApprovalController extends Controller
{
    public function show(DocumentApproval $documentApproval): Response
    {
        // return response()->json(DocumentApprovalResourceData::fromModel($documentApproval));

        return Inertia::render('ApproveDocument/ApproveDocument.page', [
            'documentApproval' => DocumentApprovalResourceData::fromModel($documentApproval),
        ]);
    }

    public function store(
        CreateDocumentApprovalData $data,
        CreateDocumentApprovalAction $createDocumentApprovalAction
    ): JsonResponse {

        $documentApproval = $createDocumentApprovalAction->execute($data);

        return response()->json($documentApproval, 201);
    }

    public function cancel(DocumentApproval $documentApproval): JsonResponse
    {
        $documentApproval->delete();

        return response()->json(['message' => 'Document approval canceled.']);
    }
}
