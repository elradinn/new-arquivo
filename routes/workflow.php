<?php

use Modules\Workflow\Controllers\WorkflowController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::prefix('workflows')->group(function () {

        Route::get('/', [WorkflowController::class, 'index']);

        Route::post('/', [WorkflowController::class, 'store']);

        Route::put('/{workflow}', [WorkflowController::class, 'update']);

        Route::delete('/{workflow}', [WorkflowController::class, 'destroy']);
    });
});
