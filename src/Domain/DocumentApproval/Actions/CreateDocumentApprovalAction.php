<?php

namespace Domain\DocumentApproval\Actions;

use Domain\DocumentApproval\Data\CreateDocumentApprovalData;
use Domain\DocumentApproval\Models\DocumentApproval;
use Domain\DocumentApprovalHasUser\Models\DocumentApprovalHasUser;

class CreateDocumentApprovalAction
{
    public function execute(CreateDocumentApprovalData $data): DocumentApproval
    {
        // $data = $data->toArray();

        $documentApproval = DocumentApproval::create([
            'document_id' => $data->document_id,
            'resolution' => $data->resolution,
            'destination' => $data->destination,
        ]);

        $documentApprovalUsers = collect($data->users)->map(function ($user) {
            return new DocumentApprovalHasUser([
                'user_id' => $user->user_id,
            ]);
        });

        $documentApproval->documentApprovalUsers()->saveMany($documentApprovalUsers);

        return $documentApproval;
    }
}
