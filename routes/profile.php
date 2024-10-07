<?php

use App\Profile\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::prefix('profile')->group(function () {

        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');

        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');

        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});
