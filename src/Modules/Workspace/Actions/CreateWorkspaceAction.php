<?php

namespace Modules\Workspace\Actions;

use Modules\Workspace\Data\CreateWorkspaceData;
use Modules\Item\Actions\CreateItemAction;
use Modules\Item\Data\CreateItemData;
use Modules\Workspace\Models\Workspace;
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

        $workspace = $item->workspace()->create([
            'name' => $data->name,
            'owned_by' => Auth::id(),
        ]);

        activity()
            ->performedOn($workspace)
            ->causedBy(Auth::id())
            ->log("Workspace created");

        return $workspace;
    }
}
