<?php

namespace Domain\Item\Actions;

use Domain\Item\Models\Item;

class DeleteItemAction
{
    public function execute(Item $item): void
    {
        $item->delete();
    }
}
