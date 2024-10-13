<?php

use Illuminate\Support\Facades\Route;
use Modules\Item\Controllers\ItemController;

Route::middleware('auth')->group(function () {

    Route::prefix('item')->group(function () {

        // Testing only. Temporary route to get all items
        Route::get('/', [ItemController::class, 'index']);

        Route::get('/download', [ItemController::class, 'download'])->name('item.download');

        Route::delete('/', [ItemController::class, 'delete'])->name('item.delete');
    });
});
