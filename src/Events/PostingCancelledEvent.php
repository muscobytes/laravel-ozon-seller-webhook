<?php

namespace Muscobytes\OzonSeller\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Muscobytes\OzonSeller\Messages\PostingCancelledMessage;

class PostingCancelledEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public PostingCancelledMessage $message
    )
    {
        //
    }
}