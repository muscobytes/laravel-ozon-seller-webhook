<?php

namespace Muscobytes\OzonSeller\Messages;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\Validation\In;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;

/**
 * Создание товара
 * https://docs.ozon.ru/api/seller/#section/Sozdanie-tovara
 *
 * ```json
 *  {
 *      "message_type": "string",
 *      "seller_id": 0,
 *      "offer_id": "string",
 *      "product_id": 0,
 *      "is_error": false,
 *      "changed_at": "2021-09-01T14:15:22Z"
 *  }
 */
class CreateItemMessage extends Data
{
    public function __construct(
        #[In(['TYPE_CREATE_ITEM'])]
        public string $message_type,

        public int $seller_id,

        public string $offer_id,

        public int $product_id,

        public bool $is_error,

        #[WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d\TH:i:sP')]
        public Carbon $changed_at,
    )
    {
    }
}
