<?php

namespace App\DocumentApproval\Controllers;

use Illuminate\Http\JsonResponse;
use App\Common\Controllers\Controller;
use Domain\DocumentApproval\Actions\CreateDocumentApprovalAction;
use Domain\DocumentApproval\Events\DocumentApprovalCreated;
use Domain\DocumentApproval\Data\CreateDocumentApprovalData;
use Domain\DocumentApproval\Models\DocumentApproval;
use Domain\DocumentApprovalHasUser\Models\DocumentApprovalHasUser;

class DocumentApprovalController extends Controller
{
    public function index(): JsonResponse
    {
        $approvals = DocumentApproval::with('documentApprovalUsers')->get();
        return response()->json($approvals);
    }

    public function store(
        CreateDocumentApprovalData $data,
        CreateDocumentApprovalAction $createDocumentApprovalAction
    ): JsonResponse {

        $documentApproval = $createDocumentApprovalAction->execute($data);

        event(new DocumentApprovalCreated($documentApproval));

        return response()->json($documentApproval, 201);
    }

    public function deleteAll(): JsonResponse
    {
        DocumentApprovalHasUser::query()->delete();
        DocumentApproval::query()->delete();

        return response()->json(['message' => 'All document approvals deleted']);
    }
}
