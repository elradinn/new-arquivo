<?php

use Illuminate\Support\Facades\Route;
use Modules\Report\Controllers\GenerateReportController;

Route::middleware('auth')->group(function () {
    Route::post('/generate-report', [GenerateReportController::class, 'generate'])->name('report.generate');
});
