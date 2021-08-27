<?php

use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\WebhookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::any('health-check', function () {
    return 'ok';
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1', 'name' => 'api.', 'middleware' => ['auth:sanctum']], function () {
    Route::post('/webhook', [WebhookController::class, 'index'])->name('webhook');
    Route::post('/upload', [FileUploadController::class, 'store'])->name('media.upload');
});
