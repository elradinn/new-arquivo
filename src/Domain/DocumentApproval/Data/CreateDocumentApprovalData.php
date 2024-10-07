<?php

namespace Domain\DocumentApproval\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\In;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Uuid;
use Domain\DocumentApprovalHasUser\Data\CreateDocumentApprovalHasUserData;

class CreateDocumentApprovalData extends Data
{
    /**
     * @param CreateDocumentApprovalHasUserData[] $users
     */
    public function __construct(
        #[Required, Uuid()]
        public string $document_id,

        #[Required, In(['reviewal', 'approval'])]
        public string $type,

        public ?string $resolution = null,

        #[Uuid()]
        public ?string $destination = null,

        #[Required]
        public array $users
    ) {}
}
