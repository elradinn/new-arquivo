<?php

namespace Modules\Document\Controllers;

use Modules\Common\Controllers\Controller;
use Modules\Document\Models\Document;
use Illuminate\Http\JsonResponse;
use Modules\Document\Data\UploadDocumentData;
use Modules\Document\Actions\UploadDocumentAction;
use Modules\Document\Data\DocumentResourceData;

class DocumentController extends Controller
{
    public function __construct(
        protected UploadDocumentAction $uploadDocumentAction
    ) {}

    public function store(UploadDocumentData $data): JsonResponse
    {
        $document = $this->uploadDocumentAction->execute($data);
        return response()->json($document, 201);
    }

    public function show(Document $document): JsonResponse
    {
        $documentResource = DocumentResourceData::fromModel($document);
        return response()->json($documentResource, 200);
    }
}
