<?php

use App\DocumentApproval\Controllers\DocumentApprovalController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::prefix('document_approval')->group(function () {

        Route::get('/{documentApproval}', [DocumentApprovalController::class, 'show']);

        Route::post('/', [DocumentApprovalController::class, 'store']);

        Route::delete('/{documentApproval}', [DocumentApprovalController::class, 'cancel']);
    });
});
