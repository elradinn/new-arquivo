<?php

namespace App\User\Controllers;

use App\Common\Controllers\Controller;
use Domain\User\Actions\RegisterUserAction;
use Domain\User\Data\RegisterUserData;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UserController extends Controller
{
    protected RegisterUserAction $registerUserAction;

    public function __construct(RegisterUserAction $registerUserAction)
    {
        $this->registerUserAction = $registerUserAction;
    }

    public function register(RegisterUserData $registerUserData): JsonResponse
    {
        $user = $this->registerUserAction->execute($registerUserData);

        return response()->json($user, Response::HTTP_CREATED);
    }
}
