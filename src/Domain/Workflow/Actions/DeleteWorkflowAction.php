<?php

namespace Domain\Workflow\Actions;

use Domain\Workflow\Models\Workflow;

class DeleteWorkflowAction
{
    public function execute(Workflow $workflow): void
    {
        $workflow->delete();
    }
}
