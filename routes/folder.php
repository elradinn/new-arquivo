<?php

use App\Folder\Controllers\FolderController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::prefix('folders')->group(function () {

        Route::post('/', [FolderController::class, 'store']);

        Route::get('/{folder}/edit', [FolderController::class, 'edit']);

        Route::put('/{folder}', [FolderController::class, 'update']);

        Route::delete('/{folder}', [FolderController::class, 'destroy']);
    });
});
