<?php

namespace Domain\Folder\Actions;

use Domain\Folder\Data\CreateFolderData;
use Domain\Folder\Models\Folder;
use Domain\Item\Actions\CreateItemAction;
use Illuminate\Support\Facades\Auth;

class CreateFolderAction
{
    protected CreateItemAction $createItemAction;

    public function __construct(CreateItemAction $createItemAction)
    {
        $this->createItemAction = $createItemAction;
    }

    public function execute(CreateFolderData $data)
    {
        // Create the Item first
        $item = $this->createItemAction->execute([
            'parent_id' => $data->parent_id,
            'position' => 0, // or set the appropriate position
        ]);

        // Create the Folder associated with the Item
        $item->folder()->create([
            'name' => $data->name,
            'owned_by' => Auth::id(),
        ]);
    }
}
