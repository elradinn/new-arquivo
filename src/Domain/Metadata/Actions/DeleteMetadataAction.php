<?php

namespace Domain\Metadata\Actions;

use Domain\Metadata\Models\Metadata;

class DeleteMetadataAction
{
    public function execute(Metadata $metadata): void
    {
        $metadata->delete();
    }
}
