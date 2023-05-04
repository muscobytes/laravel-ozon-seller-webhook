<?php

namespace Muscobytes\OzonSeller\Messages;

use Carbon\Carbon;
use Muscobytes\OzonSeller\Messages\Casts\StateCast;
use Muscobytes\OzonSeller\Messages\Properties\State;
use Spatie\LaravelData\Attributes\Validation\In;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;

/**
 * Изменение статуса отправления
 * https://docs.ozon.ru/api/seller/#section/Izmenenie-statusa-otpravleniya
 *
 * ```json
 * {
 *      "message_type": "TYPE_STATE_CHANGED",
 *      "posting_number": "24219509-0020-2",
 *      "new_state": "posting_delivered",
 *      "changed_state_date": "2021-02-02T15:07:46.765Z",
 *      "warehouse_id": 0,
 *      "seller_id": 15
 *  }
 * ```
 */
class StateChangedMessage extends Data
{
    public function __construct(
        #[In('TYPE_STATE_CHANGED')]
        public string $message_type,

        public string $posting_number,

        #[WithCast(StateCast::class)]
        public State $new_state,

        #[WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d\TH:i:s.vP')]
        public Carbon $changed_state_date,

        public int $warehouse_id,

        public int $seller_id
    )
    {
    }
}