<?php

namespace App\Http\Controllers;
use Illuminate\Foundation\Application;
use Inertia\Inertia;

class ChatMessageController extends Controller
{
    public function show(): \Inertia\Response
    {
        return Inertia::render('ChatMessaging', [
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    }
}
