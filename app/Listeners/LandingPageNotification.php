<?php

namespace App\Listeners;

use App\Events\LandingPageVisitEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class LandingPageNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public function __construct()
    {
    }
}
