<?php

namespace Domain\Workflow\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Uuid;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\Validation\Required;
use Domain\User\Models\User;

class UpdateWorkflowData extends Data
{
    public function __construct(
        public ?string $resolution = null,

        #[Required, Uuid()]
        public ?string $destination = null,

        #[Required, DataCollectionOf(User::class)]
        public array $users = []
    ) {}
}
