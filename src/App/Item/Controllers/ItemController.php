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

        $structuredItems = $this->buildTree($items);

        return response()->json($structuredItems);
    }

    private function buildTree($items, $parentId = null)
    {
        $branch = [];

        foreach ($items as $item) {
            if ($item->parent_id == $parentId) {
                $children = $this->buildTree($items, $item->id);
                $itemable = $this->getItemable($item);
                $type = $this->getItemableType($item);
                $node = [
                    'id' => $item->id,
                    'name' => $itemable->name ?? null,
                    'type' => $type,
                ];

                if ($type !== 'document') {
                    $node['children'] = $children;
                }

                $branch[] = $node;
            }
        }

        return $branch;
    }

    private function getItemable($item)
    {
        if ($item->workspace) {
            return $item->workspace;
        } elseif ($item->folder) {
            return $item->folder;
        } elseif ($item->document) {
            return $item->document;
        }

        return null;
    }

    private function getItemableType($item)
    {
        if ($item->workspace) {
            return 'workspace';
        } elseif ($item->folder) {
            return 'folder';
        } elseif ($item->document) {
            return 'document';
        }

        return 'unknown';
    }

    public function deleteAll(): JsonResponse
    {
        Item::query()->delete();
        return response()->json(['message' => 'All items deleted']);
    }
}
