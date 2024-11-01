<?php

namespace Modules\Document\Controllers;

use App\Modules\ActivityLog\Data\ActivityLogResourceData;
use Modules\Common\Controllers\Controller;
use Modules\Document\Models\Document;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Modules\Document\Data\UploadDocumentData;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Modules\Document\Actions\UpdateDocumentAction;
use Modules\Document\Actions\UploadDocumentAction;
use Modules\Document\Authorization\DocumentAuthorization;
use Modules\Document\Data\DocumentResourceData;
use Modules\Document\Data\ShareDocumentData;
use Modules\Document\Data\RemoveShareDocumentData;
use Modules\Document\Data\UpdateDocumentData;
use Modules\Item\Actions\GetItemDataAction;
use Modules\Item\Data\ItemAncestorsResourceData;
use Modules\Item\Models\Item;
use Modules\User\Models\User;
use Spatie\LaravelData\DataCollection;
use Modules\Document\Actions\UploadDocumentVersionAction;
use Modules\Document\Actions\RestoreDocumentVersionAction;
use Modules\Document\Actions\DeleteDocumentVersionAction;
use Modules\Document\Data\DocumentVersionResourceData;
use Modules\Document\Data\UploadDocumentVersionData;

class DocumentController extends Controller
{
    public function __construct(
        protected UploadDocumentAction $uploadDocumentAction,
        protected DocumentAuthorization $documentAuthorization,
        protected GetItemDataAction $getItemDataAction,
        protected UpdateDocumentAction $updateDocumentAction,
        protected UploadDocumentVersionAction $uploadDocumentVersionAction,
        protected RestoreDocumentVersionAction $restoreDocumentVersionAction,
        protected DeleteDocumentVersionAction $deleteDocumentVersionAction
    ) {}

    public function store(UploadDocumentData $data): RedirectResponse
    {
        $this->uploadDocumentAction->execute($data);

        return redirect()->back();
    }

    public function show(Document $document)
    {
        $this->documentAuthorization->canView(Auth::user(), $document);

        $item = Item::find($document->item_id);

        $itemAncestors = $item->ancestorsWithSelf()->get()->load('workspace', 'folder');

        return Inertia::render('DocumentProperties', [
            'activityLog' => ActivityLogResourceData::collect($document->activityLogs),
            'itemAncestors' => ItemAncestorsResourceData::collect($itemAncestors, DataCollection::class),
            'document' => DocumentResourceData::fromModel($document),
        ]);

        // return response()->json([
        //     'activityLog' => ActivityLogResourceData::collect($document->activityLogs),
        //     'itemAncestors' => ItemAncestorsResourceData::collect($itemAncestors, DataCollection::class),
        //     'document' => DocumentResourceData::fromModel($document),
        // ], 200);
    }

    public function edit(Document $document)
    {
        $this->documentAuthorization->canEdit(Auth::user(), $document);

        return Inertia::render('DocumentEdit', [
            'document' => DocumentResourceData::fromModel($document),
        ]);

        // return response()->json([
        //     'document' => DocumentResourceData::fromModel($document)
        // ], 200);
    }

    public function save(Document $document, UpdateDocumentData $data): RedirectResponse
    {
        $this->documentAuthorization->canEdit(Auth::user(), $document);

        $this->updateDocumentAction->execute($document, $data);

        return redirect()->back();
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

    public function uploadDocumentVersion(UploadDocumentVersionData $data): RedirectResponse
    {
        $this->uploadDocumentVersionAction->execute($data);

        return redirect()->back();
    }

    public function restoreDocumentVersion(string $versionId): RedirectResponse
    {
        $this->restoreDocumentVersionAction->execute($versionId);

        return redirect()->back();
    }

    public function deleteDocumentVersion(string $versionId): RedirectResponse
    {
        $this->deleteDocumentVersionAction->execute($versionId);

        return redirect()->back();
    }
}
