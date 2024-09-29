<?php

use App\User\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('users')->group(function () {
    Route::post('/register', [UserController::class, 'register']);
});
