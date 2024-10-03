<?php

namespace Domain\NumberingScheme\Data;

use Domain\NumberingScheme\Models\NumberingScheme;
use Spatie\LaravelData\Resource;

class NumberingSchemeResourceData extends Resource
{
    public function __construct(
        public string $prefix,
        public string $name,
        public string $folder_name
    ) {}

    public static function fromModel(NumberingScheme $numberingScheme): self
    {
        return new self(
            prefix: $numberingScheme->prefix,
            name: $numberingScheme->name,
            folder_name: $numberingScheme->folder->name ?? 'No Folder'
        );
    }
}
