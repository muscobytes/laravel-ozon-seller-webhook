<?php

namespace Muscobytes\OzonSeller\Messages\Casts;

use Muscobytes\OzonSeller\Messages\Properties\ChatType;
use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\DataProperty;

class ChatTypeCast implements Cast
{
    public function cast(DataProperty $property, mixed $value, array $context): ChatType
    {
        return ChatType::from($value);
    }
}
