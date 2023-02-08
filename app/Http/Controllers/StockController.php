<?php

namespace App\Http\Controllers;

use App\Models\StockPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class StockController extends Controller
{
    public function stock($date = '2023-01-18')
    {
        $response = Http::get("https://api.polygon.io/v1/open-close/TSLA/{$date}", [
            'apiKey' => env('POLYGON_API_KEY'),
            'adjusted' => true
        ]);

        return $response->json();
    }

    public function show(StockPrice $stockPrice)
    {
        return Inertia::render('Stocks', [
            'stocks' => $this->stock()
        ]);
    }
}
