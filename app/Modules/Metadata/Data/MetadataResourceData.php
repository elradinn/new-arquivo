<?php

namespace App\Modules\Metadata\Data;

use Spatie\LaravelData\Data;

class MetadataResourceData extends Data
{
    public function __construct(
        public int $id,
        public string $name,
        public string $type,
    ) {}
}
