<?php

namespace Muscobytes\OzonSeller\Messages\Properties;

use Muscobytes\OzonSeller\Messages\Casts\TypeCast;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Data;

class User extends Data
{
    public function __construct(
        public string $id,

        #[WithCast(TypeCast::class)]
        public Type $type
    )
    {
        //
    }
}