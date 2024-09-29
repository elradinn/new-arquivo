<?php

namespace Domain\Workspace\Actions;

use Domain\Workspace\Data\CreateWorkspaceData;
use Domain\Item\Actions\CreateItemAction;
use Illuminate\Support\Facades\Auth;

class CreateWorkspaceAction
{
    protected CreateItemAction $createItemAction;

    public function __construct(CreateItemAction $createItemAction)
    {
        $this->createItemAction = $createItemAction;
    }

    public function execute(CreateWorkspaceData $data)
    {
        // Create the Item first
        $item = $this->createItemAction->execute([
            'parent_id' => null, // or set the appropriate parent_id
            'position' => 0, // or set the appropriate position
        ]);

        // Create the Workspace associated with the Item
        $item->workspace()->create([
            'name' => $data->name,
            'owned_by' => Auth::id(),
        ]);
    }
}
