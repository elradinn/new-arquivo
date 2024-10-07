<?php

use Illuminate\Support\Facades\Route;
use App\DocumentUserApproval\Controllers\DocumentUserApprovalController;

Route::middleware('auth')->group(function () {

    Route::prefix('user_approval/{userApproval}')->group(function () {

        Route::post('/accept', [DocumentUserApprovalController::class, 'accept']);

        Route::post('/reject', [DocumentUserApprovalController::class, 'reject']);
    });
});
