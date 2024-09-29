<?php

namespace Domain\DocumentApproval\Data;

use Domain\DocumentApprovalHasUser\Data\CreateDocumentApprovalHasUserData;
use Domain\Folder\Data\CreateFolderData;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class CreateDocumentApprovalData extends Data
{
    public function __construct(
        public int $document_id,
        public ?string $resolution = null,
        public ?int $destination = null,

        // #[DataCollectionOf(CreateDocumentApprovalHasUserData::class)]
        // public DataCollection $users

        /** @var CreateDocumentApprovalHasUserData[] */
        public array $users

        // #[DataCollectionOf(CreateDocumentApprovalHasUserData::class)]
        // public DataCollection $users
    ) {}
}
