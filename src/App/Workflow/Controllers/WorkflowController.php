<?php

namespace App\Workflow\Controllers;

use App\Common\Controllers\Controller;
use Domain\Workflow\Data\CreateWorkflowData;
use Domain\Workflow\Actions\CreateWorkflowAction;
use Domain\Workflow\Models\Workflow;
use Illuminate\Http\JsonResponse;
use Domain\Workflow\Data\UpdateWorkflowData;
use Domain\Workflow\Actions\UpdateWorkflowAction;
use Domain\Workflow\Actions\DeleteWorkflowAction;

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
