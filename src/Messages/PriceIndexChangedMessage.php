<?php

namespace Muscobytes\OzonSeller\Messages;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\Validation\In;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;

/**
 * Изменение ценового индекса товара
 * https://docs.ozon.ru/api/seller/#section/Izmenenie-cenovogo-indeksa-tovara
 *
 * ```json
 *  {
 *      "message_type": "TYPE_PRICE_INDEX_CHANGED",
 *      "seller_id": 0,
 *      "updated_at":"2022-06-21T05:52:46.648533678Z",
 *      "sku": 0,
 *      "product_id": 0,
 *      "price_index": 0
 *  }
 * ```
 */
class PriceIndexChangedMessage extends Data
{
    public function __construct(
        #[In('TYPE_PRICE_INDEX_CHANGED')]
        public string $message_type,

        public int $seller_id,

        #[WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d\TH:i:s.u???P')]
        public Carbon $updated_at,

        public int $sku,

        public int $product_id,

        public int $price_index
    )
    {

    }


}