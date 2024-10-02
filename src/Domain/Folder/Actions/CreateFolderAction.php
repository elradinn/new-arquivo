<?php

namespace Domain\Folder\Actions;

use Domain\Folder\Data\CreateFolderData;
use Domain\Folder\Models\Folder;
use Domain\Item\Actions\CreateItemAction;
use Domain\Item\Data\CreateItemData;
use Illuminate\Support\Facades\Auth;

class CreateFolderAction
{
    public function __construct(
        protected CreateItemAction $createItemAction
    ) {}

    public function execute(CreateFolderData $data): Folder
    {
        $item = $this->createItemAction->execute(
            CreateItemData::from([
                'parent_id' => $data->parent_id,
            ])
        );

        return $item->folder()->create([
            'name' => $data->name,
            'owned_by' => Auth::id(),
        ]);
    }
}
