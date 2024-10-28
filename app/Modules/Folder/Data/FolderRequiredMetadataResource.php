<?php

namespace Modules\Folder\Data;

use Spatie\LaravelData\Data;
use Modules\Metadata\Data\MetadataResourceData;

class FolderRequiredMetadataResource extends Data
{
    public function __construct(
        public int $metadata_id,
        public string $name,
        public string $description
    ) {}
}
