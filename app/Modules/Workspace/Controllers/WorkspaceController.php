<?php

namespace Modules\Workspace\Controllers;

use Modules\Common\Controllers\Controller;
use Modules\Workspace\Models\Workspace;
use Modules\Item\Models\Item;
use Modules\User\Models\User;
use Illuminate\Http\JsonResponse;
use Modules\Workspace\Data\CreateWorkspaceData;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Modules\Item\Data\ItemAncestorsResourceData;
use Modules\Item\Data\ItemContentsResourceData;
use Modules\Workspace\Actions\CreateWorkspaceAction;
use Modules\Workspace\Authorization\WorkspaceAuthorization;
use Modules\Workspace\Data\RemoveShareWorkspaceData;
use Modules\Workspace\Data\ShareWorkspaceData;
use Spatie\LaravelData\DataCollection;

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

    /**
     * Show contents of workspace
     * @return \Spatie\LaravelData\DataCollection<ItemContentsResourceData>
     */
    public function show(Workspace $workspace): Response
    {
        $this->workspaceAuthorization->canView(Auth::user(), $workspace);

        $items = Item::find($workspace->item->id);

        $itemContents = $items->getChildren()->load('folder', 'document');

        $itemAncestors = $items->getAncestors()->load('workspace', 'folder');

        // return response()->json([
        //     'itemAncestors' => ItemAncestorsResourceData::collect($itemAncestors, DataCollection::class),
        //     'itemContents' => ItemContentsResourceData::collect($itemContents, DataCollection::class)
        // ]);

        return Inertia::render('Item/Item.page', [
            'itemAncestors' => ItemAncestorsResourceData::collect($itemAncestors, DataCollection::class),
            'itemContents' => ItemContentsResourceData::collect($itemContents, DataCollection::class)
        ]);
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

        $workspace->userAccess()->attach($user->id, ['role' => $data->role]);

        return response()->json(['message' => 'Workspace shared successfully.'], 200);
    }

    public function removeShare(RemoveShareWorkspaceData $data, Workspace $workspace): JsonResponse
    {
        $this->workspaceAuthorization->canShare(Auth::user(), $workspace);

        $user = User::where('email', $data->email)->firstOrFail();

        $workspace->userAccess()->detach($user->id);

        return response()->json(['message' => 'Workspace unshared successfully.'], 200);
    }
}
