<?php

use App\NumberingScheme\Controllers\NumberingSchemeController;
use Illuminate\Support\Facades\Route;

Route::post('/numbering-schemes', [NumberingSchemeController::class, 'store']);
Route::put('/numbering-schemes/{numberingScheme}', [NumberingSchemeController::class, 'update']);
Route::delete('/numbering-schemes/{numberingScheme}', [NumberingSchemeController::class, 'destroy']);
