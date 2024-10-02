<?php

namespace Domain\Workflow\Data;

use Spatie\LaravelData\Data;

class CreateWorkflowData extends Data
{
    public function __construct(
        public int $folder_item_id,
        public ?string $resolution = null,
        public ?int $destination = null,
        public array $users = []
    ) {}
}
