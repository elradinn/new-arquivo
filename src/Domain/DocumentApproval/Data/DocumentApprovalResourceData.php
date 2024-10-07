<?php

namespace Domain\DocumentApproval\Data;

use Domain\DocumentApproval\Models\DocumentApproval;
use Illuminate\Support\Facades\Log;
use Spatie\LaravelData\Resource;

class DocumentApprovalResourceData extends Resource
{
    public function __construct(
        public string $id,

        public string $document_id,

        public string $type,

        public ?string $destination,

        public ?string $resolution,

        public string $overall_state,

        public array $document_user_approvals,

        public string $created_at,

        public string $updated_at
    ) {}

    public static function fromModel(DocumentApproval $documentApproval): self
    {
        Log::info($documentApproval->documentApprovalUsers);

        return new self(
            id: $documentApproval->id,
            document_id: $documentApproval->document_id,
            type: $documentApproval->type,
            destination: $documentApproval->destination,
            resolution: $documentApproval->resolution,
            overall_state: $documentApproval->overall_state,
            document_user_approvals: $documentApproval->documentApprovalUsers->map(fn($documentUserApproval) => [
                'id' => $documentUserApproval->id,
                'user_id' => $documentUserApproval->user_id,
                'user_state' => $documentUserApproval->user_state,
                'comment' => $documentUserApproval->comment,
                'created_at' => $documentUserApproval->created_at,
                'updated_at' => $documentUserApproval->updated_at,
            ])->toArray(),
            created_at: $documentApproval->created_at,
            updated_at: $documentApproval->updated_at,
        );
    }
}
