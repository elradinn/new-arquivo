<?php

namespace App\Workflow\Controllers;

use App\Common\Controllers\Controller;
use Domain\Workflow\Data\CreateWorkflowData;
use Domain\Workflow\Actions\CreateWorkflowAction;
use Domain\Workflow\Models\Workflow;
use Illuminate\Http\JsonResponse;

class WorkflowController extends Controller
{
    public function index(): JsonResponse
    {
        $workflows = Workflow::with('workflowUsers')->get();
        return response()->json($workflows);
    }

    public function store(CreateWorkflowData $data, CreateWorkflowAction $action): JsonResponse
    {
        $workflow = $action->execute($data);

        return response()->json(['message' => 'Workflow created successfully', 'workflow' => $workflow], 201);
    }
}
