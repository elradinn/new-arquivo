<?php

use App\Document\Controllers\DocumentController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::prefix('documents')->group(function () {

        Route::get('/', [DocumentController::class, 'index']);

        Route::get('/{document}', [DocumentController::class, 'show']);

        Route::post('/', [DocumentController::class, 'store']);
    });
});
