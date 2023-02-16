<?php

use App\Http\Controllers\NewsBaseController;
use App\Http\Controllers\NewsCatcherAPIController;
use App\Http\Controllers\NewsDataAPIController;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\NewsAPIController;
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

Route::middleware([
    'weather'
])->group(function() {
    Route::get('/weather/all', [WeatherController::class, 'show']);
    Route::get('/weather/{zip}', [WeatherController::class, 'create']);
});

Route::middleware([
    'news'
])->group(function() {
    Route::put('/all', [NewsBaseController::class, 'all']);
    Route::put('/like', [NewsBaseController::class, 'like']);
    Route::put('/save', [NewsBaseController::class, 'save']);
    Route::post('/viewed', [NewsBaseController::class, 'viewed']);
    Route::post('/search', [NewsBaseController::class, 'search']);  // primitive search component

    Route::get('/newsapi/fetch', [NewsAPIController::class, 'fetch']);
    Route::get('/newscatcher/fetch', [NewsCatcherAPIController::class, 'fetch']);
    Route::get('/newsdata/fetch', [NewsDataAPIController::class, 'fetch']);
});
