<?php

use Modules\Metadata\Controllers\MetadataController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::prefix('metadata')->group(function () {

        Route::get('/', [MetadataController::class, 'index'])->name('metadata.index');

        Route::post('/', [MetadataController::class, 'store'])->name('metadata.store');

        Route::put('/{metadata}', [MetadataController::class, 'update'])->name('metadata.update');

        Route::delete('/{metadata}', [MetadataController::class, 'destroy'])->name('metadata.destroy');
    });
});
