<?php

namespace App\Document\Controllers;

use App\Common\Controllers\Controller;
use Domain\Document\Models\Document;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Domain\Document\Data\DocumentUploadData;
use Domain\Document\Actions\UploadDocumentAction;
use Domain\Document\Events\DocumentUploaded;
use App\Document\Resource\DocumentResourceData;

class DocumentController extends Controller
{
    public function __construct(
        protected UploadDocumentAction $uploadDocumentAction
    ) {}

    public function index(): JsonResponse
    {
        $documents = Document::all();
        return response()->json($documents, 200);
    }

    public function store(DocumentUploadData $data): JsonResponse
    {
        $document = $this->uploadDocumentAction->execute($data);

        event(new DocumentUploaded($document));

        return response()->json(['message' => 'Document created successfully'], 201);
    }

    public function show(Document $document): JsonResponse
    {
        $documentResource = DocumentResourceData::fromModel($document);
        return response()->json($documentResource, 200);
    }
}
