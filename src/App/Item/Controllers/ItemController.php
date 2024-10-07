<?php

namespace App\Item\Controllers;

use App\Common\Controllers\Controller;
use Domain\Item\Models\Item;
use Illuminate\Http\JsonResponse;

class ItemController extends Controller
{
    public function index(): JsonResponse
    {
        $items = Item::with(['workspace', 'folder', 'document'])->get();

        return response()->json($items);
    }
}
