<?php

namespace Modules\Folder\Actions;

use Modules\Folder\Data\UpdateFolderData;
use Modules\Folder\Models\Folder;

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
