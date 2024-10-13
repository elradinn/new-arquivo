<?php

namespace Modules\Item\Controllers;

use Modules\Common\Controllers\Controller;
use Modules\Item\Models\Item;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Modules\Item\Actions\DeleteItemsAction;
use Modules\Item\Actions\DownloadItemsAction;
use Modules\Item\Data\DeleteItemsData;
use Modules\Item\Data\DownloadItemsData;

class ItemController extends Controller
{
    public function __construct(
        private DownloadItemsAction $downloadItemsAction,
        private DeleteItemsAction $deleteItemsAction,
    ) {}

    public function index(): JsonResponse
    {
        $items = Item::with(['workspace', 'folder', 'document'])->get();

        return response()->json($items);
    }

    public function download(DownloadItemsData $data): JsonResponse
    {
        $result = $this->downloadItemsAction->execute($data);

        return response()->json($result);
    }

    public function delete(DeleteItemsData $data): RedirectResponse
    {
        $this->deleteItemsAction->execute($data);

        return redirect()->back();
    }
}
