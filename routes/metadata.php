<?php

use Modules\Metadata\Controllers\MetadataController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::prefix('metadata')->group(function () {

        Route::get('/', [MetadataController::class, 'index']);

        Route::post('/', [MetadataController::class, 'store']);

        Route::put('/{metadata}', [MetadataController::class, 'update']);

        Route::delete('/{metadata}', [MetadataController::class, 'destroy']);
    });
});
