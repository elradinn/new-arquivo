<?php

namespace Modules\Document\Controllers;

use Modules\Common\Controllers\Controller;
use Modules\Document\Models\Document;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Modules\Document\Data\UploadDocumentData;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
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

    public function store(UploadDocumentData $data): RedirectResponse
    {
        $this->uploadDocumentAction->execute($data);

        return redirect()->back();
    }

    public function show(Document $document): Response
    {
        $this->documentAuthorization->canView(Auth::user(), $document);

        return Inertia::render('DocumentProperties/DocumentProperties.page', [
            'document' => $document,
        ]);
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
