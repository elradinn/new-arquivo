<?php

namespace Domain\Workspace\Actions;

use Domain\Workspace\Models\Workspace;
use Domain\Item\Actions\DeleteItemAction;

class DeleteWorkspaceAction
{
    public function __construct(
        protected DeleteItemAction $deleteItemAction
    ) {}

    public function execute(Workspace $workspace): void
    {
        $this->deleteItemAction->execute($workspace->item);
    }
}
