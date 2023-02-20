<?php

namespace App\Http\Controllers;
use Illuminate\Foundation\Application;
use Inertia\Inertia;

class ChatMessageController extends Controller
{
    public function show(): \Inertia\Response
    {
        return Inertia::render('ChatPage', [
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    }
}
