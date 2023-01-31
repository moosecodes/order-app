<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\WeatherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->post('/order', [OrderController::class, 'create']);
Route::middleware('auth:sanctum')->get('/order/status/{id}', [OrderController::class, 'status']);


Route::get('/weather', [WeatherController::class, 'index']);
Route::get('/weather/all', [WeatherController::class, 'show']);
Route::get('/weather/{zip}', [WeatherController::class, 'create']);
