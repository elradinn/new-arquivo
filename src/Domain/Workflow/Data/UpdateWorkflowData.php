<?php

namespace Domain\Workflow\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Uuid;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\Validation\Required;
use Domain\User\Models\User;

class UpdateWorkflowData extends Data
{
    /**
     * @param WorkflowHasUserData[] $users_to_add
     * @param WorkflowHasUserData[] $users_to_remove
     */
    public function __construct(

        public ?string $resolution = null,

        #[Uuid()]
        public ?string $destination = null,

        public ?array $users_to_add,

        public ?array $users_to_remove
    ) {}
}
