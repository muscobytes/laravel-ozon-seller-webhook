<?php

namespace Muscobytes\OzonSeller\Messages;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\Validation\In;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;

/**
 * Изменение даты отгрузки отправления
 * https://docs.ozon.ru/api/seller/#section/Izmenenie-daty-otgruzki-otpravleniya
 *
 * ```json
 *  {
 *      "message_type": "TYPE_CUTOFF_DATE_CHANGED",
 *      "posting_number": "24219509-0020-2",
 *      "new_cutoff_date": "2021-11-24T07:00:00Z",
 *      "old_cutoff_date": "2021-11-21T10:00:00Z",
 *      "warehouse_id": 0,
 *      "seller_id": 15
 *  }
 * ```
 */
class CutoffDateChangedMessage extends Data
{
    public function __construct(
        #[In(['TYPE_CUTOFF_DATE_CHANGED'])]
        public string $message_type,

        public string $posting_number,

        #[WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d\TH:i:sP')]
        public Carbon $new_cutoff_date,

        #[WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d\TH:i:sP')]
        public Carbon $old_cutoff_date,

        public int $warehouse_id,

        public int $seller_id
    )
    {
    }
}
