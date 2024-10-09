<?php

namespace Modules\Document\Controllers;

use Modules\Common\Controllers\Controller;
use Modules\Document\Models\Document;
use Illuminate\Http\JsonResponse;
use Modules\Document\Data\UploadDocumentData;
use Illuminate\Support\Facades\Auth;
use Modules\Document\Actions\UploadDocumentAction;
use Modules\Document\Authorization\DocumentAuthorization;
use Modules\Document\Data\ShareDocumentData;
use Modules\Document\Data\RemoveShareDocumentData;
use Modules\User\Models\User;

class DocumentController extends Controller
{
    public function __construct(
        protected UploadDocumentAction $uploadDocumentAction,
        protected DocumentAuthorization $documentAuthorization
    ) {}

    public function store(UploadDocumentData $data): JsonResponse
    {
        $document = $this->uploadDocumentAction->execute($data);

        return response()->json($document, 201);
    }

    public function show(Document $document): JsonResponse
    {
        $this->documentAuthorization->canView(Auth::user(), $document);

        return response()->json($document);
    }

    public function share(ShareDocumentData $data, Document $document): JsonResponse
    {
        $this->documentAuthorization->canShare(Auth::user(), $document);

        $user = User::where('email', $data->email)->firstOrFail();

        $document->userAccess()->attach($user->id, ['role' => $data->role]);

        return response()->json(['message' => 'Document shared successfully.'], 200);
    }

    public function removeShare(RemoveShareDocumentData $data, Document $document): JsonResponse
    {
        $this->documentAuthorization->canShare(Auth::user(), $document);

        $user = User::where('email', $data->email)->firstOrFail();

        $document->userAccess()->detach($user->id);

        return response()->json(['message' => 'Document unshared successfully.'], 200);
    }
}
