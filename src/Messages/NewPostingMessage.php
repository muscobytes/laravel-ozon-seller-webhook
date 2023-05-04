<?php

namespace Muscobytes\OzonSeller\Messages;

use Carbon\Carbon;
use Muscobytes\OzonSeller\Messages\Properties\Product;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\Validation\In;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

/**
 * Новое отправление
 * https://docs.ozon.ru/api/seller/#section/Novoe-otpravlenie
 *
 * ```json
 *  {
 *      "message_type": "TYPE_NEW_POSTING",
 *      "posting_number": "24219509-0020-1",
 *      "products": [
 *          {
 *              "sku": 147451959,
 *              "quantity": 2
 *          }
 *      ],
 *      "in_process_at": "2021-01-26T06:56:36.294Z",
 *      "warehouse_id": 18850503335000,
 *      "seller_id": 15
 *  }
 * ```
 */
class NewPostingMessage extends Data
{
    public function __construct(
        #[In(['TYPE_NEW_POSTING'])]
        public string $message_type,

        public string $posting_number,

        #[DataCollectionOf(Product::class)]
        public DataCollection $products,

        #[WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d\TH:i:s.vP')]
        public Carbon $in_process_at,

        public int $warehouse_id,

        public int $seller_id
    ) {
    }
}