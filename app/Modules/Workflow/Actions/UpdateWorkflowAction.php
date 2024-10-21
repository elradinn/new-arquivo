<?php

namespace Modules\Workflow\Actions;

use Modules\Workflow\Data\UpdateWorkflowData;
use Modules\Workflow\Models\Workflow;
use Modules\Workflow\Models\WorkflowHasUser;
use Modules\User\Models\User;

class UpdateWorkflowAction
{
    public function execute(Workflow $workflow, UpdateWorkflowData $data): array
    {
        // Update workflow details
        $workflow->update($data->toArray());

        // Determine required role based on the new type
        $requiredRole = $this->getRequiredRole($data->type);

        if ($requiredRole) {
            // Filter users based on the required role
            $filteredUsers = User::whereIn('id', array_map(fn($user) => $user->user_id, $data->users))
                ->where('workflow_role', $requiredRole)
                ->get();

            // Remove existing users if the type has changed
            if ($workflow->type !== $data->type) {
                WorkflowHasUser::where('workflow_id', $workflow->id)
                    ->delete();
            }

            // Prepare new user associations, excluding existing ones
            $existingUserIds = $workflow->workflowUsers->pluck('user_id')->toArray();
            $newUsers = $filteredUsers->reject(function ($user) use ($existingUserIds) {
                return in_array($user->id, $existingUserIds);
            })->map(function ($user) use ($workflow) {
                return new WorkflowHasUser([
                    'workflow_id' => $workflow->id,
                    'user_id' => $user->id,
                ]);
            });

            // Associate the filtered users with the workflow
            $workflow->workflowUsers()->saveMany($newUsers);
        }

        return ['workflow' => $workflow->load('workflowUsers')];
    }

    /**
     * Determines the required user role based on the workflow type.
     *
     * @param string $type
     * @return string|null
     */
    private function getRequiredRole(string $type): ?string
    {
        return match ($type) {
            'reviewal' => 'reviewer',
            'approval' => 'approver',
            default => null,
        };
    }
}
