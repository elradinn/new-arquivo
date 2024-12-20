<?php

namespace Modules\DocumentApproval\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Modules\Common\Controllers\Controller;
use Modules\DocumentApproval\Actions\CreateDocumentApprovalAction;
use Modules\DocumentApproval\Data\CreateDocumentApprovalData;
use Modules\DocumentApproval\Data\DocumentApprovalResourceData;
use Modules\DocumentApproval\Models\DocumentApproval;
use Modules\DocumentApproval\Actions\UpdateDocumentApprovalAction;
use Modules\DocumentApproval\Data\UpdateDocumentApprovalData;

class DocumentApprovalController extends Controller
{
    public function __construct(
        protected CreateDocumentApprovalAction $createDocumentApprovalAction,
        protected UpdateDocumentApprovalAction $updateDocumentApprovalAction
    ) {}

    public function show(DocumentApproval $documentApproval): Response
    {
        return Inertia::render('ApproveDocument', [
            'documentApproval' => DocumentApprovalResourceData::fromModel($documentApproval),
        ]);
    }

    public function showToUpdate(DocumentApproval $documentApproval): JsonResponse
    {
        return response()->json(DocumentApprovalResourceData::fromModel($documentApproval));
    }

    public function store(CreateDocumentApprovalData $data): RedirectResponse
    {
        $this->createDocumentApprovalAction->execute($data);

        return redirect()->back();
    }

    public function cancel(DocumentApproval $documentApproval): JsonResponse
    {
        $documentApproval->delete();

        return response()->json(['message' => 'Document approval canceled.']);
    }

    public function update(DocumentApproval $documentApproval, UpdateDocumentApprovalData $data): RedirectResponse
    {
        $this->updateDocumentApprovalAction->execute($documentApproval, $data);

        return redirect()->back();
    }
}
