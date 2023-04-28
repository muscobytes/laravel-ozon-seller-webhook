<?php

namespace Muscobytes\OzonSeller\Events;

use Muscobytes\OzonSellerWebhook\EventType;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class NewPostingEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public EventType $type,
        public Carbon $time
    )
    {
        //
    }
}
