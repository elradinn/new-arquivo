<?php

namespace Modules\Metadata\Actions;

use Modules\Metadata\Data\UpdateMetadataData;
use Modules\Metadata\Models\Metadata;

class UpdateMetadataAction
{
    public function execute(Metadata $metadata, UpdateMetadataData $data): Metadata
    {
        $metadata->update($data->toArray());
        return $metadata;
    }
}
