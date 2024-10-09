<?php

namespace Modules\Item\Controllers;

use Modules\Common\Controllers\Controller;
use Modules\Item\Models\Item;
use Illuminate\Http\JsonResponse;

class ItemController extends Controller
{
    public function index(): JsonResponse
    {
        $items = Item::with(['workspace', 'folder', 'document'])->get();

        return response()->json($items);
    }
}
