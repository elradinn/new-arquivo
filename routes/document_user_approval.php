<?php

use Illuminate\Support\Facades\Route;
use App\DocumentUserApproval\Controllers\DocumentUserApprovalController;

Route::middleware('auth')->group(function () {

    Route::prefix('user_approval/{userApproval}/reviewal')->group(function () {

        Route::post('/accept', [DocumentUserApprovalController::class, 'acceptReviewal']);

        Route::post('/reject', [DocumentUserApprovalController::class, 'rejectReviewal']);
    });

    Route::prefix('user_approval/{userApproval}/approval')->group(function () {

        Route::post('/accept', [DocumentUserApprovalController::class, 'acceptApproval']);

        Route::post('/reject', [DocumentUserApprovalController::class, 'rejectApproval']);
    });
});
