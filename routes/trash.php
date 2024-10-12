<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Item\Controllers\TrashController;

Route::middleware('auth')->group(function () {

    Route::prefix('trash')->group(function () {

        Route::get('/', [TrashController::class, 'index'])->name('trash');
    });
});
