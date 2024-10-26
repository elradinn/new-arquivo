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

class DocumentController extends Controller
{
    public function __construct(
        protected UploadDocumentAction $uploadDocumentAction,
        protected DocumentAuthorization $documentAuthorization,
        protected GetItemDataAction $getItemDataAction,
        protected UpdateDocumentAction $updateDocumentAction
    ) {}

    public function store(UploadDocumentData $data): RedirectResponse
    {
        $this->uploadDocumentAction->execute($data);

        return redirect()->back();
    }

    public function show(Document $document): JsonResponse
    {
        $this->documentAuthorization->canView(Auth::user(), $document);

        $item = Item::find($document->item_id);

        $itemAncestors = $item->ancestorsWithSelf()->get()->load('workspace', 'folder');

        // return Inertia::render('DocumentProperties', [
        //     'activityLog' => ActivityLogResourceData::collect($document->activityLogs),
        //     'itemAncestors' => ItemAncestorsResourceData::collect($itemAncestors, DataCollection::class),
        //     'document' => DocumentResourceData::fromModel($document),
        // ]);

        return response()->json([
            'activityLog' => ActivityLogResourceData::collect($document->activityLogs),
            'itemAncestors' => ItemAncestorsResourceData::collect($itemAncestors, DataCollection::class),
            'document' => DocumentResourceData::fromModel($document),
        ], 200);
    }

    public function edit(Document $document): JsonResponse
    {
        $this->documentAuthorization->canEdit(Auth::user(), $document);

        // return Inertia::render('DocumentEdit', [
        //     'document' => DocumentResourceData::fromModel($document),
        // ]);

        return response()->json([
            'document' => DocumentResourceData::fromModel($document)
        ], 200);
    }

    public function save(Document $document, UpdateDocumentData $data)
    {
        $this->documentAuthorization->canEdit(Auth::user(), $document);

        $updatedDocument = $this->updateDocumentAction->execute($document, $data);

        return response()->json(DocumentResourceData::fromModel($updatedDocument));
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
