<?php

namespace App\Folder\Controllers;

use App\Common\Controllers\Controller;
use Domain\Folder\Models\Folder;
use Domain\Item\Models\Item;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Domain\Folder\Data\CreateFolderData;
use Illuminate\Support\Facades\Auth;
use Domain\Folder\Actions\CreateFolderAction;

class FolderController extends Controller
{
    public function index(): JsonResponse
    {
        $folders = Folder::all();
        return response()->json($folders);
    }

    public function store(CreateFolderData $data, CreateFolderAction $action): JsonResponse
    {
        $action->execute($data);

        return response()->json(['message' => 'Folder created successfully'], 201);
    }

    public function deleteAll(): JsonResponse
    {
        Folder::query()->delete();
        return response()->json(['message' => 'All folders deleted']);
    }

    public function showChildren($id): JsonResponse
    {
        $items = Item::find($id)->getDescendants();

        $structuredItems = $items->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->itemable->name ?? null,
                'type' => $item->itemable_type,
                'document_number' => $item->itemable->document_number,
            ];
        });

        return response()->json($structuredItems);
    }
}
