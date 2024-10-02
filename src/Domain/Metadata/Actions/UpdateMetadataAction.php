<?php

namespace Domain\Metadata\Actions;

use Domain\Metadata\Data\UpdateMetadataData;
use Domain\Metadata\Models\Metadata;

class UpdateMetadataAction
{
    public function execute(Metadata $metadata, UpdateMetadataData $data): Metadata
    {
        $metadata->update($data->toArray());
        return $metadata;
    }
}
