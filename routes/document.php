<?php

use App\Document\Controllers\DocumentController;
use App\Document\Controllers\DocumentMetadataController;
use App\DocumentApproval\Controllers\DocumentApprovalController;
use App\DocumentUserApproval\Controllers\DocumentUserApprovalController;
use App\Document\Controllers\RelatedDocumentController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/documents', [DocumentController::class, 'index']);
    Route::post('/documents', [DocumentController::class, 'store']);
    Route::delete('/documents', [DocumentController::class, 'deleteAll']);
});

Route::get('/document-approvals', [DocumentApprovalController::class, 'index']);
Route::post('/document-approvals', [DocumentApprovalController::class, 'store']);

Route::post('/document-approvals/{documentApprovalId}/accept', [DocumentUserApprovalController::class, 'accept']);
Route::post('/document-approvals/{documentApprovalId}/reject', [DocumentUserApprovalController::class, 'reject']);

Route::delete('/document-approvals', [DocumentApprovalController::class, 'deleteAll']);

// Document Metadata Routes
Route::post('/documents/{document}/metadata', [DocumentMetadataController::class, 'attach']);
Route::put('/documents/{document}/metadata/{metadata}', [DocumentMetadataController::class, 'update']);
Route::delete('/documents/{document}/metadata/{metadata}', [DocumentMetadataController::class, 'detach']);
Route::get('/documents/{document}/metadata', [DocumentMetadataController::class, 'list']);

Route::prefix('documents/{document}')->group(function () {
    // List related documents
    Route::get('related', [RelatedDocumentController::class, 'index'])->name('documents.related.index');

    // Attach a related document
    Route::post('related', [RelatedDocumentController::class, 'attach'])->name('documents.related.attach');

    // Detach a related document
    Route::delete('related/{relatedDocumentId}', [RelatedDocumentController::class, 'detach'])->name('documents.related.detach');
});
