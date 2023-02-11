<?php

namespace App\Http\Controllers;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
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
