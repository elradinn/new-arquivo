<?php

use Illuminate\Support\Facades\Route;
use Modules\DocumentApprovalHasUser\Controllers\DocumentUserApprovalController;

Route::middleware('auth')->group(function () {

    Route::prefix('user_approval/{userApproval}')->group(function () {

        Route::post('/accept', [DocumentUserApprovalController::class, 'accept'])
            ->name('document_user_approval.accept')
            ->where('userApproval', '[0-9a-fA-F\-]{36}');

        Route::post('/reject', [DocumentUserApprovalController::class, 'reject'])
            ->name('document_user_approval.reject')
            ->where('userApproval', '[0-9a-fA-F\-]{36}');
    });
});
