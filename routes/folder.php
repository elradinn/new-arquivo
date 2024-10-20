<?php

use Modules\Folder\Controllers\FolderController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::prefix('folder')->group(function () {

        Route::get('/{folder}', [FolderController::class, 'show'])->name('folder.show');

        Route::post('/', [FolderController::class, 'store'])->name('folder.create');

        Route::get('/{folder}/edit', [FolderController::class, 'edit'])->name('folder.edit');

        Route::put('/{folder}', [FolderController::class, 'update'])->name('folder.update');

        Route::delete('/{folder}', [FolderController::class, 'destroy'])->name('folder.delete');

        Route::post('/{folder}/share', [FolderController::class, 'share'])->name('folder.share');

        Route::delete('/{folder}/share', [FolderController::class, 'removeShare'])->name('folder.removeShare');
    });
});
