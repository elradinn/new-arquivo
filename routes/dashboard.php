<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Modules\Dashboard\Controllers\DashboardController;

Route::middleware('auth')->group(function () {

    Route::prefix('dashboard')->group(function () {

        Route::get('/', [DashboardController::class, 'dashboard']);

        Route::get('/reports', [DashboardController::class, 'showDashboardReport']);
    });
});
