<?php

namespace App\Modules\Item\Actions;

use Modules\Item\Data\TrashedItemsResourceData;
use Modules\Item\Models\Item;
use Spatie\LaravelData\DataCollection;

class GetTrashedItemAction
{
    public function execute()
    {
        return [
            'trashedItems' => TrashedItemsResourceData::collect(Item::onlyTrashed()->get(), DataCollection::class),
        ];
    }
}
