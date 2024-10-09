<?php

namespace Modules\DocumentApprovalHasUser\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Required;

class CreateDocumentApprovalHasUserData extends Data
{
    public function __construct(
        #[Required()]
        public int $user_id,
    ) {}
}
