<?php

namespace Domain\Workflow\Actions;

use Domain\Workflow\Data\UpdateWorkflowData;
use Domain\Workflow\Models\Workflow;

class UpdateWorkflowAction
{
    public function execute(Workflow $workflow, UpdateWorkflowData $data): Workflow
    {
        // TODO: how about nesting the workflow users in the data?
        $workflow->update($data->toArray());
        return $workflow;
    }
}
