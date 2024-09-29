<?php

use App\Metadata\Controllers\MetadataController;
use Illuminate\Support\Facades\Route;

// Metadata Routes
Route::get('/metadata', [MetadataController::class, 'index']);
Route::post('/metadata', [MetadataController::class, 'store']);
Route::put('/metadata/{metadata}', [MetadataController::class, 'update']);
Route::delete('/metadata/{metadata}', [MetadataController::class, 'destroy']);
