<?php

use App\Workspace\Controllers\WorkspaceController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::prefix('workspace')->group(function () {

        Route::get('/', [WorkspaceController::class, 'index']);

        Route::get('/{workspace}', [WorkspaceController::class, 'show']);

        Route::post('/', [WorkspaceController::class, 'store']);

        Route::post('/{workspace}/share', [WorkspaceController::class, 'share']);

        Route::delete('/{workspace}/share', [WorkspaceController::class, 'removeShare']);
    });
});
