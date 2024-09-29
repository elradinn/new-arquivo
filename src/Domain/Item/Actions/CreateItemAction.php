<?php

namespace Domain\Item\Actions;

use Domain\Item\Models\Item;

class CreateItemAction
{
    public function execute(array $data): Item
    {
        $item = new Item($data);
        $item->save();

        return $item;
    }
}
