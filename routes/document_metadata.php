<?php

use Illuminate\Support\Facades\Route;
use App\Document\Controllers\DocumentMetadataController;

Route::middleware('auth')->group(function () {

    Route::prefix('documents/{document}/metadata')->group(function () {

        Route::post('/', [DocumentMetadataController::class, 'attach']);

        Route::put('/{metadata}', [DocumentMetadataController::class, 'update']);

        Route::delete('/{metadata}', [DocumentMetadataController::class, 'detach']);
    });
});
