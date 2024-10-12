<?php

use Modules\NumberingScheme\Controllers\NumberingSchemeController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::prefix('numbering-scheme')->group(function () {

        Route::get('/', [NumberingSchemeController::class, 'index']);

        Route::get('/{numberingScheme}', [NumberingSchemeController::class, 'show']);

        Route::post('/create', [NumberingSchemeController::class, 'store']);

        Route::put('/{numberingScheme}', [NumberingSchemeController::class, 'update']);

        Route::delete('/{numberingScheme}', [NumberingSchemeController::class, 'destroy']);
    });
});
