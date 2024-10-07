<?php

use App\Workspace\Controllers\WorkspaceController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::prefix('workspace')->group(function () {

        Route::get('/{workspace}', [WorkspaceController::class, 'show']);

        Route::get('/', [WorkspaceController::class, 'index']);

        Route::post('/', [WorkspaceController::class, 'store']);
    });
});
