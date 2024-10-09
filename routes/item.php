<?php

use Illuminate\Support\Facades\Route;
use Modules\Item\Controllers\ItemController;

Route::middleware('auth')->group(function () {

    // Testing only. Temporary route to get all items
    Route::prefix('items')->group(function () {

        Route::get('/', [ItemController::class, 'index']);
    });
});
