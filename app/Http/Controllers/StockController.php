<?php

namespace App\Http\Controllers;

use App\Models\StockPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;
use Inertia\Response;

class StockController extends Controller
{
    public function stock()
    {
        $date = date('2023-02-10');

        $response = Http::get("https://api.polygon.io/v1/open-close/TSLA/{$date}", [
            'apiKey' => env('POLYGON_API_KEY'),
            'adjusted' => true
        ]);

        return $response->json();
    }

    public function show(StockPrice $stockPrice): Response
    {
        return Inertia::render('Stocks', [
            'stocks' => $this->stock()
        ]);
    }
}
