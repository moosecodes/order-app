<?php

namespace App\Http\Controllers;

use App\Events\WeatherReadingEvent;
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
    /**
     * Display a listing of the resource.
     *
     * @return Collection
     */
    public function index()
    {
        return WeatherReading::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($zip)
    {
        // TODO Error handling for this method

        $response = Http::get("https://api.weatherapi.com/v1/current.json", [
            'key' => 'c0d5e7fcbbb743359b1190117232901',
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return void
     */
    public function store(Request $request)
    {
        // redis
    }

    /**
     * Display the specified resource.
     *
     * @return Response
     */
    public function show()
    {
        WeatherReadingEvent::dispatch(WeatherReading::orderBy('id', 'DESC')->first()->temp_f);

        return Inertia::render('Weather', [
            'weather' => WeatherReading::orderBy('id', 'DESC')->first()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  WeatherReading  $weatherReading
     * @return Response
     */
    public function update(Request $request, WeatherReading $weatherReading)
    {
        //
    }
}
