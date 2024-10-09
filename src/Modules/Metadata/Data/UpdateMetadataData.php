<?php

namespace Modules\Metadata\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Attributes\Validation\In;
use Spatie\LaravelData\Attributes\Validation\Sometimes;

class UpdateMetadataData extends Data
{
    public function __construct(
        #[Sometimes, Required, StringType, Unique('metadata', 'name')]
        public ?string $name = null,

        #[Sometimes, Required, StringType, In(['string', 'integer', 'float', 'boolean', 'date', 'datetime'])]
        public ?string $type = null
    ) {}
}
