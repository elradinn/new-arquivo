<?php

use Illuminate\Support\Facades\Route;
use App\DocumentUserApproval\Controllers\DocumentUserApprovalController;

Route::middleware('auth')->group(function () {

    Route::prefix('user_approval/{userApproval}')->group(function () {

        Route::get('/', [DocumentUserApprovalController::class, 'show']);

        Route::post('reviewal/accept', [DocumentUserApprovalController::class, 'acceptReviewal']);

        Route::post('reviewal/reject', [DocumentUserApprovalController::class, 'rejectReviewal']);

        Route::post('approval/accept', [DocumentUserApprovalController::class, 'acceptApproval']);

        Route::post('approval/reject', [DocumentUserApprovalController::class, 'rejectApproval']);
    });
});
