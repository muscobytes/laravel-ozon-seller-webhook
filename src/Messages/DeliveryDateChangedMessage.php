<?php

namespace Muscobytes\OzonSeller\Messages;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\Validation\In;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;

/**
 * Изменение даты доставки отправления
 * https://docs.ozon.ru/api/seller/#section/Izmenenie-daty-dostavki-otpravleniya
 *
 * ```json
 *  {
 *      "message_type": "TYPE_DELIVERY_DATE_CHANGED",
 *      "posting_number": "24219509-0020-2",
 *      "new_delivery_date_begin": "2021-11-24T07:00:00Z",
 *      "new_delivery_date_end": "2021-11-24T16:00:00Z",
 *      "old_delivery_date_begin": "2021-11-21T10:00:00Z",
 *      "old_delivery_date_end": "2021-11-21T19:00:00Z",
 *      "warehouse_id": 0,
 *      "seller_id": 15
 *  }
 * ```
 */
class DeliveryDateChangedMessage extends Data
{
    public function __construct(
        #[In(['TYPE_DELIVERY_DATE_CHANGED'])]
        public string $message_type,

        public string $posting_number,

        #[WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d\TH:i:sP')]
        public Carbon $new_delivery_date_begin,

        #[WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d\TH:i:sP')]
        public Carbon $new_delivery_date_end,

        #[WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d\TH:i:sP')]
        public Carbon $old_delivery_date_begin,

        #[WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d\TH:i:sP')]
        public Carbon $old_delivery_date_end,

        public int $warehouse_id,

        public int $seller_id
    )
    {

    }
}
