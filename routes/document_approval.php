<?php

use App\DocumentApproval\Controllers\DocumentApprovalController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::prefix('documents/{document}/approval')->group(function () {

        Route::get('/', [DocumentApprovalController::class, 'index']);

        Route::post('/', [DocumentApprovalController::class, 'store']);
    });
});
