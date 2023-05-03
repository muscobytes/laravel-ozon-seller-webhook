<?php

namespace Muscobytes\OzonSeller\Messages\Properties;

use Spatie\LaravelData\Data;

class Reason extends Data
{
    public function __construct(
        public int $id,
        public string $message
    )
    {
    }
}