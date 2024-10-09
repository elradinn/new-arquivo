<?php

use Modules\Document\Controllers\DocumentController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::prefix('document')->group(function () {

        Route::get('/{document}', [DocumentController::class, 'show']);

        Route::post('/', [DocumentController::class, 'store']);

        Route::post('/{document}/share', [DocumentController::class, 'share']);

        Route::delete('/{document}/share', [DocumentController::class, 'removeShare']);
    });
});
