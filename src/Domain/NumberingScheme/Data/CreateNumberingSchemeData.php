<?php

namespace Domain\NumberingScheme\Data;

use Spatie\LaravelData\Data;

class CreateNumberingSchemeData extends Data
{
    public function __construct(
        public string $folder_item_id,
        public string $name,
        public string $prefix
    ) {}
}
