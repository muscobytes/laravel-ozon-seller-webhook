<?php

namespace Muscobytes\OzonSeller\Messages;

use Carbon\Carbon;
use Muscobytes\OzonSeller\Messages\Casts\ReasonCast;
use Muscobytes\OzonSeller\Messages\Casts\StateCast;
use Muscobytes\OzonSeller\Messages\Properties\Product;
use Muscobytes\OzonSeller\Messages\Properties\Reason;
use Muscobytes\OzonSeller\Messages\Properties\State;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\Validation\In;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;


/**
 * Отмена отправления
 * https://docs.ozon.ru/api/seller/#section/Otmena-otpravleniya
 *
 * ```json
 *  {
 *      "message_type": "TYPE_POSTING_CANCELLED",
 *      "posting_number": "24219509-0020-1",
 *      "products": [
 *          {
 *              "sku": 147451959,
 *              "quantity": 1
 *          }
 *      ],
 *      "old_state": "posting_transferred_to_courier_service",
 *      "new_state": "posting_canceled",
 *      "changed_state_date": "2021-01-26T06:56:36.294Z",
 *      "reason": {
 *          "id": 0,
 *          "message": "string"
 *      },
 *      "warehouse_id": 0,
 *      "seller_id": 15
 *  }
 * ```
 */
class PostingCancelledMessage extends Data
{
    public function __construct(
        #[In('TYPE_POSTING_CANCELLED')]
        public string $message_type,

        public string $posting_number,

        #[DataCollectionOf(Product::class)]
        public DataCollection $products,

        #[WithCast(StateCast::class)]
        public State $old_state,

        #[In('posting_canceled')]
        #[WithCast(StateCast::class)]
        public State $new_state,

        #[WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d\TH:i:s.vP')]
        public Carbon $changed_state_date,

        #[WithCast(ReasonCast::class)]
        public Reason $reason,

        public int $warehouse_id,

        public int $seller_id
    )
    {
    }
}
