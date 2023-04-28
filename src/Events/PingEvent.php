<?php

namespace Muscobytes\OzonSeller\Events;

use Muscobytes\OzonSellerWebhook\EventType;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class PingEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public string $type,
        public Carbon $time
    )
    {
        //
    }
}
