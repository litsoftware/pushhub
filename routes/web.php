<?php

use App\Http\Livewire\Application;
use App\Http\Livewire\Channel;
use App\Http\Livewire\Log;
use App\Http\Controllers\Dashboard\DashboardController;
use Illuminate\Support\Facades\Route;

Route::any('/', function () {
    return redirect(\route('dash.index'));
});

Route::middleware(['auth:sanctum', 'verified'])
    ->prefix('dashboard')
    ->name('dash.')
    ->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::get('/channels', \App\Http\Livewire\ChannelManagement::class)->name('channel');
    Route::get('/logs', \App\Http\Livewire\SendLogs::class)->name('log');
});
