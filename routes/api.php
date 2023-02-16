<?php

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
    Route::put('/like', [NewsAPIController::class, 'like']);
    Route::put('/save', [NewsAPIController::class, 'save']);
    Route::post('/articleViewed', [NewsAPIController::class, 'articleViewed']);

    Route::get('/newsapi/fetch', [NewsAPIController::class, 'fetch']);
    Route::get('/newsapi/trending', [NewsAPIController::class, 'trending']);
    Route::post('/newsapi/search', [NewsAPIController::class, 'search']);  // primitive search component

    Route::get('/newscatcher/fetch', [NewsCatcherAPIController::class, 'fetch']);
    Route::get('/newscatcher/search', [NewsCatcherAPIController::class, 'search']);  // not implemented yet

    Route::get('/newsdata/fetch', [NewsDataAPIController::class, 'fetch']);
});
