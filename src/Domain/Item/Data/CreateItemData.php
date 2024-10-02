<?php

namespace Domain\Item\Data;

use Spatie\LaravelData\Data;

class CreateItemData extends Data
{
    public function __construct(
        public ?int $parent_id = null,
    ) {}
}
