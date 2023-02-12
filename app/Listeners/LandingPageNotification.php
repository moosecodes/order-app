<?php

namespace App\Listeners;

use App\Events\LandingPageVisitEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LandingPageNotification implements ShouldQueue
{
    use InteractsWithQueue;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\LandingPageVisitEvent  $event
     * @return void
     */
    public function handle(LandingPageVisitEvent $event)
    {
        Http::withHeaders(['Content-type' => 'application/json'])->post(
            env('SLACK_WEBHOOK_JETSTORM'),
            ['text' => $event->order->message]
        );
    }
}
