<?php

namespace App\Document\Controllers;

use App\Common\Controllers\Controller;
use Domain\Document\Models\Document;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Domain\Document\Data\DocumentUploadData;
use Domain\Document\Actions\CreateDocumentAction;

class DocumentController extends Controller
{
    public function index(): JsonResponse
    {
        $documents = Document::all();
        return response()->json($documents, 200);
    }

    public function store(DocumentUploadData $data, CreateDocumentAction $action): JsonResponse
    {
        $action->execute($data);

        return response()->json(['message' => 'Document created successfully'], 201);
    }

    public function deleteAll(): JsonResponse
    {
        Document::query()->delete();
        return response()->json(['message' => 'All documents deleted']);
    }
}
