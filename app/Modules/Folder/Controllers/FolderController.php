<?php

namespace Modules\Folder\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Modules\Common\Controllers\Controller;
use Modules\Folder\Models\Folder;
use Modules\Folder\Data\CreateFolderData;
use Modules\Folder\Data\UpdateFolderData;
use Modules\Folder\Actions\CreateFolderAction;
use Modules\Folder\Actions\DeleteFolderAction;
use Modules\Folder\Actions\UpdateFolderAction;
use Modules\Folder\Data\FolderResourceData;
use Modules\Folder\Data\ShareFolderData;
use Modules\Folder\Data\RemoveShareFolderData;
use Modules\Folder\Authorization\FolderAuthorization;
use Modules\Item\Data\ItemAncestorsResourceData;
use Modules\Item\Data\ItemContentsResourceData;
use Modules\Item\Models\Item;
use Modules\User\Models\User;
use Modules\Item\Actions\GetItemDataAction;
use Modules\Folder\Actions\UpdateFolderMetadataAction;
use Modules\Folder\Data\UpdateFolderMetadataData;
use Modules\Folder\Data\FolderRequiredMetadataResource;

class FolderController extends Controller
{
    public function __construct(
        private CreateFolderAction $createFolderAction,
        private UpdateFolderAction $updateFolderAction,
        private DeleteFolderAction $deleteFolderAction,
        private FolderAuthorization $folderAuthorization,
        private GetItemDataAction $getItemDataAction,
        private UpdateFolderMetadataAction $updateFolderMetadataAction
    ) {}

    /**
     * Show contents of folder
     * @return \Spatie\LaravelData\DataCollection<ItemContentsResourceData>
     */
    public function show(Folder $folder)
    {
        $this->folderAuthorization->canView(Auth::user(), $folder);

        $items = Item::find($folder->item->id);

        $data = $this->getItemDataAction->execute($items);

        return Inertia::render('Item', $data);
    }

    public function store(CreateFolderData $data): RedirectResponse
    {
        $this->createFolderAction->execute($data);

        return redirect()->back();
    }

    public function edit(Folder $folder): Response
    {
        $this->folderAuthorization->canView(Auth::user(), $folder);

        $item = Item::find($folder->item_id);

        $data = $this->getItemDataAction->execute($item);

        return Inertia::render('FolderProperties', array_merge($data, [
            'folder' => FolderResourceData::from($folder),
        ]));
    }

    public function update(Folder $folder, UpdateFolderData $data): JsonResponse
    {
        $this->folderAuthorization->canEdit(Auth::user(), $folder);

        $updatedFolder = $this->updateFolderAction->execute($folder, $data);

        return response()->json(['message' => 'Folder updated successfully', 'folder' => $updatedFolder]);
    }

    public function destroy(Folder $folder): JsonResponse
    {
        $this->folderAuthorization->canEdit(Auth::user(), $folder);

        $this->deleteFolderAction->execute($folder);

        return response()->json(['message' => 'Folder deleted successfully']);
    }

    public function share(ShareFolderData $data, Folder $folder): JsonResponse
    {
        $this->folderAuthorization->canShare(Auth::user(), $folder);

        $user = User::where('email', $data->email)->firstOrFail();

        $folder->userAccess()->attach($user->id, ['role' => $data->role]);

        return response()->json(['message' => 'Folder shared successfully.'], 200);
    }

    public function removeShare(RemoveShareFolderData $data, Folder $folder): JsonResponse
    {
        $this->folderAuthorization->canShare(Auth::user(), $folder);

        $user = User::where('email', $data->email)->firstOrFail();

        $folder->userAccess()->detach($user->id);

        return response()->json(['message' => 'Folder unshared successfully.'], 200);
    }

    /**
     * Add required metadata to a folder.
     */
    public function updateFolderRequiredMetadata(Folder $folder, UpdateFolderMetadataData $data)
    {
        $this->updateFolderMetadataAction->execute($folder, $data);
        return redirect()->back();
    }

    /**
     * Show required metadata of a folder.
     */
    public function showFolderRequiredMetadata(Folder $folder)
    {
        $requiredMetadata = $folder->requiredMetadata()->get();

        return response()->json($requiredMetadata);

        // return Inertia::render('FolderMetadata', [
        //     'requiredMetadata' => FolderRequiredMetadataResource::collect($requiredMetadata),
        //     'folder' => FolderResourceData::from($folder),
        // ]);
    }
}
