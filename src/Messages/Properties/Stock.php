<?php

namespace Muscobytes\OzonSeller\Messages\Properties;

use Spatie\LaravelData\Data;

class Stock extends Data
{
    public function __construct(
        public int $warehouse_id,

        public int $present,

        public int $reserved,
    )
    {

    }
}