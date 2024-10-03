<?php

namespace App\Folder\Controllers;

use App\Common\Controllers\Controller;
use Domain\Folder\Models\Folder;
use Illuminate\Http\JsonResponse;
use Domain\Folder\Data\CreateFolderData;
use Domain\Folder\Data\UpdateFolderData;
use Domain\Folder\Actions\CreateFolderAction;
use Domain\Folder\Actions\DeleteFolderAction;
use Domain\Folder\Actions\UpdateFolderAction;
use Domain\Folder\Data\FolderResourceData;

class FolderController extends Controller
{
    public function __construct(
        private CreateFolderAction $createFolderAction,
        private UpdateFolderAction $updateFolderAction,
        private DeleteFolderAction $deleteFolderAction,
    ) {}

    public function store(CreateFolderData $data): JsonResponse
    {
        $this->createFolderAction->execute($data);

        return response()->json(['message' => 'Folder created successfully'], 201);
    }

    public function edit(Folder $folder): FolderResourceData
    {
        return FolderResourceData::from($folder);
    }

    public function update(Folder $folder, UpdateFolderData $data): JsonResponse
    {
        $updatedFolder = $this->updateFolderAction->execute($folder, $data);

        return response()->json(['message' => 'Folder updated successfully', 'folder' => $updatedFolder]);
    }

    public function destroy(Folder $folder): JsonResponse
    {
        $this->deleteFolderAction->execute($folder);

        return response()->json(['message' => 'Folder deleted successfully']);
    }
}
