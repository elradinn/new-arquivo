<?php

namespace Modules\Folder\Actions;

use Modules\Folder\Models\Folder;
use Modules\Item\Actions\DeleteItemAction;

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
