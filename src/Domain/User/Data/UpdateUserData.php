<?php

namespace Domain\User\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Unique;

class UpdateUserData extends Data
{
    public function __construct(
        #[Required, Max(255)]
        public string $name,
    ) {}
}
