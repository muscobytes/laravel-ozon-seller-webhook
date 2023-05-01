<?php

namespace Muscobytes\OzonSeller\Messages;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\Validation\In;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;


class PingMessage extends Data
{
    public function __construct(
        #[In(['TYPE_PING'])]
        public string $message_type,

        #[WithCast(DateTimeInterfaceCast::class)]
        public Carbon $time,
    ) {
    }
}