<?php

use App\Document\Controllers\DocumentController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::prefix('document')->group(function () {

        Route::get('/{document}', [DocumentController::class, 'show']);

        Route::post('/', [DocumentController::class, 'store']);
    });
});
