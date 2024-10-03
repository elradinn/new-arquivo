<?php

namespace Domain\Workspace\Actions;

use Domain\Workspace\Data\UpdateWorkspaceData;
use Domain\Workspace\Models\Workspace;

class UpdateWorkspaceAction
{
    public function execute(Workspace $workspace, UpdateWorkspaceData $data): Workspace
    {
        $workspace->update([
            'name' => $data->name,
        ]);

        return $workspace;
    }
}
