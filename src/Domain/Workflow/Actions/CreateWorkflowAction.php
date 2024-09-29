<?php

namespace Domain\Workflow\Actions;

use Domain\Workflow\Data\CreateWorkflowData;
use Domain\Workflow\Models\Workflow;
use Domain\Workflow\Models\WorkflowHasUser;

class CreateWorkflowAction
{
    public function execute(CreateWorkflowData $data): Workflow
    {
        $workflow = Workflow::create([
            'folder_id' => $data->folder_id,
            'resolution' => $data->resolution,
            'destination' => $data->destination,
        ]);

        $workflowUsers = collect($data->users)->map(function ($user) {
            return new WorkflowHasUser([
                'user_id' => $user['user_id'],
            ]);
        });

        $workflow->workflowUsers()->saveMany($workflowUsers);

        return $workflow;
    }
}
