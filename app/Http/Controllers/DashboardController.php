<?php

namespace App\Http\Controllers;
use Illuminate\Foundation\Application;
use Inertia\Inertia;
class DashboardController extends Controller
{
    public function show(): \Inertia\Response
    {
        return Inertia::render('Dashboard', [
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    }
}
