<?php

namespace App\Listeners;

use App\Events\OrderReceivedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrderReceivedNotification
{
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
     * @param  \App\Events\OrderReceivedEvent  $event
     * @return void
     */
    public function handle(OrderReceivedEvent $event)
    {
        //
    }
}
