<?php

namespace Domain\Metadata\Actions;

use Domain\Metadata\Data\CreateMetadataData;
use Domain\Metadata\Models\Metadata;

class CreateMetadataAction
{
    public function execute(CreateMetadataData $data): Metadata
    {
        return Metadata::create($data->toArray());
    }
}
