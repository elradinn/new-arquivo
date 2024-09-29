<?php

use Illuminate\Support\Facades\Route;
use App\Item\Controllers\ItemController;

Route::middleware('auth')->group(function () {
    Route::get('/items', [ItemController::class, 'index']);
    Route::delete('/items', [ItemController::class, 'deleteAll']);
});
