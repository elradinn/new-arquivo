<?php

namespace Modules\User\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Modules\Common\Controllers\Controller;
use Modules\User\Models\User;
use Modules\User\Actions\DeleteUserAction;
use Modules\User\Actions\RegisterUserAction;
use Modules\User\Actions\UpdateUserAction;
use Modules\User\Data\RegisterUserData;
use Modules\User\Data\UpdateUserData;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class UserController extends Controller
{
    public function __construct(
        protected RegisterUserAction $registerUserAction,
        protected UpdateUserAction $updateUserAction,
        protected DeleteUserAction $deleteUserAction
    ) {}

    public function index()
    {
        // $users = User::all();

        // return response()->json($users, Response::HTTP_OK);

        return Inertia::render('User/User.page');
    }

    public function register(RegisterUserData $registerUserData): JsonResponse
    {
        $user = $this->registerUserAction->execute($registerUserData);

        return response()->json($user, Response::HTTP_CREATED);
    }

    public function update(User $user, UpdateUserData $updateUserData): JsonResponse
    {
        $updatedUser = $this->updateUserAction->execute($user, $updateUserData);

        return response()->json($updatedUser, Response::HTTP_OK);
    }

    public function delete(User $user): JsonResponse
    {
        $this->deleteUserAction->execute($user);

        return response()->json(['message' => 'User deleted successfully'], Response::HTTP_NO_CONTENT);
    }
}
