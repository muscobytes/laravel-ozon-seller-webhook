<?php

namespace Muscobytes\OzonSeller\Messages\Properties;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class Item extends Data
{
    public function __construct(
        public int $product_id,

        public int $sku,

        #[WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d\TH:i:sP')]
        public Carbon $updated_at,

        #[DataCollectionOf(Stock::class)]
        public DataCollection $stocks
    )
    {

    }
}