<?php

namespace Domain\Folder\Actions;

use Domain\Folder\Models\Folder;
use Domain\Item\Actions\DeleteItemAction;

class DeleteFolderAction
{
    public function __construct(
        protected DeleteItemAction $deleteItemAction
    ) {}

    public function execute(Folder $folder): void
    {
        $this->deleteItemAction->execute($folder->item);
    }
}
