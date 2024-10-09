<?php

namespace App\Workspace\Controllers;

use App\Common\Controllers\Controller;
use Domain\Workspace\Models\Workspace;
use Domain\Item\Models\Item;
use Domain\User\Models\User;
use Illuminate\Http\JsonResponse;
use Domain\Workspace\Data\CreateWorkspaceData;
use Illuminate\Support\Facades\Auth;
use Domain\Workspace\Actions\CreateWorkspaceAction;
use Domain\Workspace\Authorization\WorkspaceAuthorization;
use Domain\Workspace\Data\RemoveShareWorkspaceData;
use Domain\Workspace\Data\ShareWorkspaceData;

class WorkspaceController extends Controller
{
    public function __construct(
        protected CreateWorkspaceAction $createWorkspaceAction,
        protected WorkspaceAuthorization $workspaceAuthorization
    ) {}

    public function index(): JsonResponse
    {
        $this->workspaceAuthorization->isAdmin(Auth::user());

        $workspaces = Workspace::all();

        return response()->json($workspaces);
    }

    public function show(Workspace $workspace): JsonResponse
    {
        $this->workspaceAuthorization->canView(Auth::user(), $workspace);

        return response()->json(Item::find($workspace->item->id)->getChildren()->load('folder', 'document'));
    }

    public function store(CreateWorkspaceData $data): JsonResponse
    {
        $workspace = $this->createWorkspaceAction->execute($data);

        return response()->json($workspace, 201);
    }

    public function share(ShareWorkspaceData $data, Workspace $workspace): JsonResponse
    {
        $this->workspaceAuthorization->canShare(Auth::user(), $workspace);

        $user = User::where('email', $data->email)->firstOrFail();

        $workspace->users()->attach($user->id, ['role' => $data->role]);

        return response()->json(['message' => 'Workspace shared successfully.'], 200);
    }

    public function removeShare(RemoveShareWorkspaceData $data, Workspace $workspace): JsonResponse
    {
        $this->workspaceAuthorization->canShare(Auth::user(), $workspace);

        $user = User::where('email', $data->email)->firstOrFail();

        $workspace->users()->detach($user->id);

        return response()->json(['message' => 'Workspace unshared successfully.'], 200);
    }
}
