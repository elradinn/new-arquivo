<?php

use App\Workflow\Controllers\WorkflowController;
use Illuminate\Support\Facades\Route;

Route::get('/workflows', [WorkflowController::class, 'index']);
Route::post('/workflows', [WorkflowController::class, 'store']);
