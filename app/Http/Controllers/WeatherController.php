<?php

namespace App\Http\Controllers;

use App\Events\WeatherReadingEvent;
use App\Models\TopHeadline;
use App\Models\WeatherReading;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class WeatherController extends Controller
{
    public function index()
    {
        return WeatherReading::all();
    }

    public function show()
    {
        WeatherReadingEvent::dispatch(WeatherReading::orderBy('id', 'DESC')->first()->temp_f);

        return Inertia::render('Weather', [
            'weather' => WeatherReading::orderBy('id', 'DESC')->first(),
        ]);
    }

    public function create($zip)
    {
        $response = Http::get("https://api.weatherapi.com/v1/current.json", [
            'key' => env('WEATHER_API_KEY'),
            'q' => $zip
        ]);
        $reading = $response->json();

        $weatherReading = new WeatherReading;

        $weatherReading->temp_f = $reading['current']['temp_f'];
        $weatherReading->temp_c = $reading['current']['temp_c'];
        $weatherReading->city = $reading['location']['name'];
        $weatherReading->region = $reading['location']['region'];
        $weatherReading->save();

        return $weatherReading->orderBy('id', 'DESC')->first();
    }
}
