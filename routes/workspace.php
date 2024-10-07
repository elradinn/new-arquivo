<?php

use App\Workspace\Controllers\WorkspaceController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::prefix('workspaces')->group(function () {

        Route::get('/', [WorkspaceController::class, 'index']);

        Route::post('/', [WorkspaceController::class, 'store']);
    });
});
