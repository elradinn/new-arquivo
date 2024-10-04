<?php

namespace Domain\Workflow\Actions;

use Domain\Workflow\Data\UpdateWorkflowData;
use Domain\Workflow\Models\Workflow;
use Domain\Workflow\Models\WorkflowHasUser;

class UpdateWorkflowAction
{
    public function execute(Workflow $workflow, UpdateWorkflowData $data): array
    {
        // Update workflow details
        $workflow->update($data->toArray());

        // Remove specified users if any
        if (!empty($data->users_to_remove)) {
            $userIdsToRemove = array_map(fn($user) => $user->user_id, $data->users_to_remove);
            WorkflowHasUser::where('workflow_id', $workflow->id)
                ->whereIn('user_id', $userIdsToRemove)
                ->delete();
        }

        // Add new users if any
        $newUsers = collect($data->users_to_add)->map(function ($user) use ($workflow) {
            return new WorkflowHasUser([
                'workflow_id' => $workflow->id,
                'user_id' => $user->user_id,
            ]);
        });

        $workflow->workflowUsers()->saveMany($newUsers);

        return ['workflow' => $workflow->load('workflowUsers')];
    }
}
