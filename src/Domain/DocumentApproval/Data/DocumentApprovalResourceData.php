<?php

namespace Domain\DocumentApproval\Data;

use Domain\DocumentApproval\Models\DocumentApproval;
use Spatie\LaravelData\Resource;

class DocumentApprovalResourceData extends Resource
{
    /**
     * @param DocumentUserApprovalResourceData[] $document_user_approvals
     */
    public function __construct(
        public int $id,

        public string $type,

        public string $overall_state,

        public array $document_user_approvals,

        public string $created_at,

        public string $updated_at
    ) {}

    public static function fromModel(DocumentApproval $documentApproval): self
    {
        return new self(
            id: $documentApproval->id,
            type: $documentApproval->type,
            overall_state: $documentApproval->overall_state,
            document_user_approvals: $documentApproval->documentUserApprovals,
            created_at: $documentApproval->created_at,
            updated_at: $documentApproval->updated_at,
        );
    }
}
