<?php

namespace Modules\Item\Actions;

use Modules\Item\Models\Item;
use Modules\Item\Data\RestoreTrashedItemsData;

class RestoreTrashedItemsAction
{
    public function execute(RestoreTrashedItemsData $data): void
    {
        Item::withTrashed()->whereIn('id', $data->ids)->restore();
    }
}
