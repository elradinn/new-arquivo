<?php

use Illuminate\Support\Facades\Route;
use App\Document\Controllers\RelatedDocumentController;

Route::middleware('auth')->group(function () {

    Route::prefix('documents/{document}/related/{relatedDocument}')->group(function () {

        Route::put('/', [RelatedDocumentController::class, 'attach']);

        Route::delete('/', [RelatedDocumentController::class, 'detach']);
    });
});
