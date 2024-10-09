<?php

namespace Modules\Workspace\Controllers;

use Modules\Common\Controllers\Controller;
use Modules\Workspace\Models\Workspace;
use Modules\Item\Models\Item;
use Modules\User\Models\User;
use Illuminate\Http\JsonResponse;
use Modules\Workspace\Data\CreateWorkspaceData;
use Illuminate\Support\Facades\Auth;
use Modules\Workspace\Actions\CreateWorkspaceAction;
use Modules\Workspace\Authorization\WorkspaceAuthorization;
use Modules\Workspace\Data\RemoveShareWorkspaceData;
use Modules\Workspace\Data\ShareWorkspaceData;

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
