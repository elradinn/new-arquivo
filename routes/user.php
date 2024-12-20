<?php

use Modules\User\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::prefix('users')->group(function () {

        Route::get('/', [UserController::class, 'index']);

        Route::post('/register', [UserController::class, 'register']);

        Route::put('/{user}', [UserController::class, 'update']);

        Route::delete('/{user}', [UserController::class, 'delete']);

        Route::get('/get-users-approval-role/{type}', [UserController::class, 'getUsersApprovalRole']);
    });
});
