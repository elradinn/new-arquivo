<?php

namespace Modules\Item\Actions;

use Modules\Item\Models\Item;
use Modules\Item\Data\ItemAncestorsResourceData;
use Modules\Item\Data\ItemContentsResourceData;
use Modules\Item\Data\ItemParentResourceData;
use Spatie\LaravelData\DataCollection;

class GetItemDataAction
{
    public function execute(Item $item): array
    {
        $itemContents = $item->getChildren()->load('folder', 'document');
        $itemAncestors = $item->ancestorsWithSelf()->get()->load('workspace', 'folder');

        return [
            'itemParent' => ItemParentResourceData::fromModel($item),
            'itemAncestors' => ItemAncestorsResourceData::collect($itemAncestors, DataCollection::class),
            'itemContents' => ItemContentsResourceData::collect($itemContents, DataCollection::class),
        ];
    }
}
