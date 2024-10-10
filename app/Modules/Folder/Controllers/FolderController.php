<?php

namespace Modules\Folder\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
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
use Modules\Item\Models\Item;
use Modules\User\Models\User;

class FolderController extends Controller
{
    public function __construct(
        private CreateFolderAction $createFolderAction,
        private UpdateFolderAction $updateFolderAction,
        private DeleteFolderAction $deleteFolderAction,
        private FolderAuthorization $folderAuthorization
    ) {}

    public function show(Folder $folder): JsonResponse
    {
        $this->folderAuthorization->canView(Auth::user(), $folder);

        return response()->json(Item::find($folder->item->id)->getChildren()->load('folder', 'document'));
    }

    public function store(CreateFolderData $data): JsonResponse
    {
        $folder = $this->createFolderAction->execute($data);

        return response()->json(['message' => 'Folder created successfully'], 201);
    }

    public function edit(Folder $folder): FolderResourceData
    {
        $this->folderAuthorization->canView(Auth::user(), $folder);

        return FolderResourceData::from($folder);
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
}
