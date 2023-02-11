<?php

namespace App\Http\Controllers;

use App\Events\WeatherReadingEvent;
use App\Models\WeatherReading;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class WeatherController extends Controller
{
    public function all()
    {
        return WeatherReading::all();
    }

    public function show(): \Inertia\Response
    {
        WeatherReadingEvent::dispatch(WeatherReading::orderBy('id', 'DESC')->first()->temp_f);

        return Inertia::render('WeatherViewer', [
            'weather' => WeatherReading::orderBy('id', 'DESC')->first(),
        ]);
    }

    public function create($zip)
    {
        $response = Http::get(env('WEATHER_API_URL'), [
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
