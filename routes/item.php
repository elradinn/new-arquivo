<?php

use Illuminate\Support\Facades\Route;
use App\Item\Controllers\ItemController;

Route::middleware('auth')->group(function () {

    Route::prefix('items')->group(function () {

        Route::get('/', [ItemController::class, 'index']);
    });
});
