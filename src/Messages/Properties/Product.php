<?php

namespace Muscobytes\OzonSeller\Messages\Properties;

use Spatie\LaravelData\Data;

class Product extends Data
{
    public function __construct(
        public int $sku,
        public int $quantity
    )
    {
    }
}