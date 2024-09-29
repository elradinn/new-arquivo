<?php

use App\Folder\Controllers\FolderController;
use Illuminate\Support\Facades\Route;

Route::get('/folders', [FolderController::class, 'index']);
Route::post('/folders', [FolderController::class, 'store']);
Route::delete('/folders', [FolderController::class, 'deleteAll']);
Route::get('/folders/index/{id}', [FolderController::class, 'showChildren']);
