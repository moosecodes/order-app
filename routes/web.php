<?php

use App\Http\Controllers\HomepageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ChatMessageController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\NewsAPIController;
use App\Http\Controllers\WeatherController;

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
Route::get('/', [HomepageController::class, 'show'])->name('homepage');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function() {
    Route::get('/dashboard', [DashboardController::class, 'show'])->name('dashboard');
    Route::get('/messages', [ChatMessageController::class, 'show'])->name('messages');
});
