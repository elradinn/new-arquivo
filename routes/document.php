<?php

use Modules\Document\Controllers\DocumentController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::prefix('document')->group(function () {

        Route::get('/{document}', [DocumentController::class, 'show'])->name('document.show');

        Route::get('/{document}/edit', [DocumentController::class, 'edit'])->name('document.edit');

        Route::put('/{document}/save', [DocumentController::class, 'save'])->name('document.save');

        Route::post('/', [DocumentController::class, 'store'])->name('document.store');

        Route::post('/{document}/share', [DocumentController::class, 'share'])->name('document.share');

        Route::delete('/{document}/share', [DocumentController::class, 'removeShare'])->name('document.remove-share');

        Route::post('/{document}/versions', [DocumentController::class, 'uploadDocumentVersion'])->name('document.upload_version');

        Route::post('/versions/{version}/restore', [DocumentController::class, 'restoreDocumentVersion'])->name('document.restore_version');

        Route::delete('/versions/{version}', [DocumentController::class, 'deleteDocumentVersion'])->name('document.delete_version');
    });
});
