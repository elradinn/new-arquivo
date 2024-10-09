<?php

namespace Modules\Workflow\Controllers;

use Modules\Common\Controllers\Controller;
use Modules\Workflow\Data\CreateWorkflowData;
use Modules\Workflow\Actions\CreateWorkflowAction;
use Modules\Workflow\Models\Workflow;
use Illuminate\Http\JsonResponse;
use Modules\Workflow\Data\UpdateWorkflowData;
use Modules\Workflow\Actions\UpdateWorkflowAction;
use Modules\Workflow\Actions\DeleteWorkflowAction;

class WorkflowController extends Controller
{
    public function __construct(
        protected CreateWorkflowAction $createWorkflowAction,
        protected UpdateWorkflowAction $updateWorkflowAction,
        protected DeleteWorkflowAction $deleteWorkflowAction
    ) {}

    public function index(): JsonResponse
    {
        $workflows = Workflow::with('workflowUsers')->get();
        return response()->json($workflows);
    }

    public function store(CreateWorkflowData $data): JsonResponse
    {
        $workflow = $this->createWorkflowAction->execute($data);

        return response()->json(['message' => 'Workflow created successfully', 'workflow' => $workflow], 201);
    }

    public function update(Workflow $workflow, UpdateWorkflowData $data): JsonResponse
    {
        $updatedWorkflow = $this->updateWorkflowAction->execute($workflow, $data);
        return response()->json($updatedWorkflow, 200);
    }

    public function destroy(Workflow $workflow): JsonResponse
    {
        $this->deleteWorkflowAction->execute($workflow);
        return response()->json(['message' => 'Workflow deleted successfully.'], 200);
    }
}
