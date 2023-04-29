<?php

namespace Muscobytes\OzonSeller\Messages;

use Spatie\LaravelData\Attributes\Validation\In;
use Spatie\LaravelData\Data;

class PingMessage extends Data
{
    public function __construct(
        #[In(['TYPE_PING'])]
        public string $message_type,

        public string $time
    ) {
    }
}