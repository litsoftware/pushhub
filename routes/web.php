<?php

use App\Http\Controllers\Dashboard\Application;
use App\Http\Controllers\Dashboard\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::any('/', function () {
    return redirect(\route('dash.index'));
});

Route::middleware(['auth:sanctum', 'verified'])
    ->prefix('dashboard')
    ->name('dash.')
    ->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::get('/application', Application::class)->name('application');
    Route::get('/channel', Application::class)->name('channel');
    Route::get('/log', Application::class)->name('log');
});
