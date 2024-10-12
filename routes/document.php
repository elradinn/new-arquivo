<?php

use Modules\Document\Controllers\DocumentController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::prefix('document')->group(function () {

        Route::get('/{document}', [DocumentController::class, 'show'])->name('document.show');

        Route::post('/', [DocumentController::class, 'store'])->name('document.store');

        Route::post('/{document}/share', [DocumentController::class, 'share'])->name('document.share');

        Route::delete('/{document}/share', [DocumentController::class, 'removeShare'])->name('document.remove-share');
    });
});
