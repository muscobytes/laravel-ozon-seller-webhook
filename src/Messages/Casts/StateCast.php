<?php

namespace Muscobytes\OzonSeller\Messages\Casts;

use Muscobytes\OzonSeller\Messages\Properties\State;
use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\DataProperty;

class StateCast implements Cast
{
    public function cast(DataProperty $property, mixed $value, array $context): State
    {
        return State::from($value);
    }
}