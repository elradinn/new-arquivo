<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::get('/admin-tools', function () {
        return Inertia::render('AdminTools');
    })->name('admin.tools');
});
