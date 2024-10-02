<?php

namespace Domain\Item\Actions;

use Domain\Item\Data\CreateItemData;
use Domain\Item\Models\Item;

class CreateItemAction
{
    public function execute(CreateItemData $data): Item
    {
        return Item::create($data->toArray());
    }
}
