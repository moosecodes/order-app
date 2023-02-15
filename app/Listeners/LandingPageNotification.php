<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LandingPageNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public function __construct()
    {
    }

    public function __invoke()
    {

    }
}
