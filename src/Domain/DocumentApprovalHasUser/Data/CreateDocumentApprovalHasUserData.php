<?php

namespace Domain\DocumentApprovalHasUser\Data;

use Spatie\LaravelData\Data;

class CreateDocumentApprovalHasUserData extends Data
{
    public function __construct(
        public int $user_id,
    ) {}
}
