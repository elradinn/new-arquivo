<?php

namespace Modules\Dashboard\Data;

use Spatie\LaravelData\Data;

class DashboardMetadataResourceData extends Data
{
    public function __construct(
        public int $id,
        public string $name,
        public string $type,
    ) {}
}
