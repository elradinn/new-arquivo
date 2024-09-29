<?php

namespace App\User\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Common\Controllers\Controller;
use Domain\User\Models\User;
use Domain\User\Actions\DeleteUserAction;
use Domain\User\Actions\RegisterUserAction;
use Domain\User\Actions\UpdateUserAction;
use Domain\User\Data\RegisterUserData;
use Domain\User\Data\UpdateUserData;

class UserController extends Controller
{
    protected RegisterUserAction $registerUserAction;
    protected UpdateUserAction $updateUserAction;
    protected DeleteUserAction $deleteUserAction;

    public function __construct(
        RegisterUserAction $registerUserAction,
        UpdateUserAction $updateUserAction,
        DeleteUserAction $deleteUserAction
    ) {
        $this->registerUserAction = $registerUserAction;
        $this->updateUserAction = $updateUserAction;
    }

    public function index(): JsonResponse
    {
        $users = User::all();

        return response()->json($users, Response::HTTP_OK);
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

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
