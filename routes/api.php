<?php

use App\Http\Controllers\WeatherController;
use App\Http\Controllers\NewsController;
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
    Route::get('/weather/all', [WeatherController::class, 'index']);
    Route::get('/weather/{zip}', [WeatherController::class, 'create']);
});

Route::middleware([
    'news'
])->group(function() {
    Route::get('/news/top', [NewsController::class, 'index']);
    Route::get('/news/newscatcher/latest', [NewsController::class, 'fetchFromNewsCatcherAPI']);
    Route::get('/news/newscatcher/search', [NewsController::class, 'searchNewsCatcherAPI']);
    Route::get('/news/newsdata/news', [NewsController::class, 'fetchFromNewsDataAPI']);
    Route::put('/news/like', [NewsController::class, 'like']);
    Route::post('/news/search', [NewsController::class, 'search']);
    Route::post('/news/articleViewed', [NewsController::class, 'articleViewed']);
});
