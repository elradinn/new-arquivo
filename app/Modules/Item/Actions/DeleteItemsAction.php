<?php

namespace Modules\Item\Actions;

use Modules\Item\Models\Item;
use Modules\Item\Data\DeleteItemsData;

class DeleteItemsAction
{
    public function execute(DeleteItemsData $data): void
    {
        Item::whereIn('id', $data->ids)->delete();
    }
}
