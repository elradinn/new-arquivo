<?php

use App\Workspace\Controllers\WorkspaceController;
use Illuminate\Support\Facades\Route;

Route::get('/workspaces', [WorkspaceController::class, 'index']);
Route::post('/workspaces', [WorkspaceController::class, 'store']);
Route::delete('/workspaces', [WorkspaceController::class, 'deleteAll']);
