<?php

use App\DocumentApproval\Controllers\DocumentApprovalController;
use App\DocumentUserApproval\Controllers\DocumentUserApprovalController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::prefix('documents/{document}/approval')->group(function () {

        Route::get('/', [DocumentApprovalController::class, 'index']);

        Route::post('/', [DocumentApprovalController::class, 'store']);

        Route::post('/{approval}/reviewal/accept', [DocumentUserApprovalController::class, 'acceptReviewal']);

        Route::post('/{approval}/reviewal/reject', [DocumentUserApprovalController::class, 'rejectReviewal']);

        Route::post('/{approval}/approval/accept', [DocumentUserApprovalController::class, 'acceptApproval']);

        Route::post('/{approval}/approval/reject', [DocumentUserApprovalController::class, 'rejectApproval']);
    });
});
