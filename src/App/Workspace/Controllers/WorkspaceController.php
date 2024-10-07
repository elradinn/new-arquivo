<?php

namespace App\Workspace\Controllers;

use App\Common\Controllers\Controller;
use Domain\Workspace\Models\Workspace;
use Domain\Item\Models\Item;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Domain\Workspace\Data\CreateWorkspaceData;
use Illuminate\Support\Facades\Auth;
use Domain\Workspace\Actions\CreateWorkspaceAction;

class WorkspaceController extends Controller
{
    public function __construct(
        protected CreateWorkspaceAction $createWorkspaceAction
    ) {}

    public function show(Workspace $workspace): JsonResponse
    {
        return response()->json(Item::find($workspace->item->id)->getChildren()->load('folder', 'document'));
    }

    public function index(): JsonResponse
    {
        $workspaces = Workspace::all();
        return response()->json($workspaces);
    }

    public function store(CreateWorkspaceData $data): JsonResponse
    {
        $workspace = $this->createWorkspaceAction->execute($data);
        return response()->json($workspace, 201);
    }
}
