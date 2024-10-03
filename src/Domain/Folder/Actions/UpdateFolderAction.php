<?php

namespace Domain\Folder\Actions;

use Domain\Folder\Data\UpdateFolderData;
use Domain\Folder\Models\Folder;

class UpdateFolderAction
{
    public function execute(Folder $folder, UpdateFolderData $data): Folder
    {
        $folder->update([
            'name' => $data->name,
        ]);

        return $folder;
    }
}
