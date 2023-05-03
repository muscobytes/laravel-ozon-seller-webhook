<?php

namespace Muscobytes\OzonSeller\Messages\Casts;

use Muscobytes\OzonSeller\Messages\Properties\Reason;
use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\DataProperty;

class ReasonCast implements Cast
{
    public function cast(DataProperty $property, mixed $value, array $context): Reason
    {
        return Reason::from($value);
    }

}