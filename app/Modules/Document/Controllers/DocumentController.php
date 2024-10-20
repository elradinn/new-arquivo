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
use Modules\Document\Data\DocumentResourceData;
use Modules\Document\Data\ShareDocumentData;
use Modules\Document\Data\RemoveShareDocumentData;
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
        protected GetItemDataAction $getItemDataAction
    ) {}

    public function store(UploadDocumentData $data): RedirectResponse
    {
        $this->uploadDocumentAction->execute($data);

        return redirect()->back();
    }

    public function show(Document $document): Response
    {
        $this->documentAuthorization->canView(Auth::user(), $document);

        $item = Item::find($document->item_id);

        $itemAncestors = $item->ancestorsWithSelf()->get()->load('workspace', 'folder');

        return Inertia::render('DocumentProperties', array_merge([
            // 'itemAncestors' => ItemAncestorsResourceData::collect($itemAncestors, DataCollection::class),
            'document' => DocumentResourceData::fromModel($document),
        ]));
    }

    public function edit(Document $document): Response
    {
        $this->documentAuthorization->canEdit(Auth::user(), $document);

        return Inertia::render('DocumentProperties', [
            'document' => DocumentResourceData::fromModel($document),
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
