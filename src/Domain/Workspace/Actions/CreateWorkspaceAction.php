<?php

namespace Domain\Workspace\Actions;

use Domain\Workspace\Data\CreateWorkspaceData;
use Domain\Item\Actions\CreateItemAction;
use Domain\Item\Data\CreateItemData;
use Domain\Workspace\Models\Workspace;
use Illuminate\Support\Facades\Auth;

class CreateWorkspaceAction
{
    public function __construct(
        protected CreateItemAction $createItemAction
    ) {}

    public function execute(CreateWorkspaceData $data): Workspace
    {
        $item = $this->createItemAction->execute(
            CreateItemData::from([
                'parent_id' => null,
                'position' => 0,
            ])
        );

        return $item->workspace()->create([
            'name' => $data->name,
            'owned_by' => Auth::id(),
        ]);
    }
}
