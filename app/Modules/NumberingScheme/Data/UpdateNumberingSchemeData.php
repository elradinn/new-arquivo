<?php

namespace Modules\NumberingScheme\Data;

use Spatie\LaravelData\Data;

class UpdateNumberingSchemeData extends Data
{
    public function __construct(
        public string $name,
        public string $prefix
    ) {}
}
