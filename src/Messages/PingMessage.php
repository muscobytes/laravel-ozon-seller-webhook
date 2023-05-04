<?php

namespace Muscobytes\OzonSeller\Messages;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\Validation\In;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;

/**
 * Запрос для проверки соединения
 * https://docs.ozon.ru/api/seller/#section/Zapros-dlya-proverki-soedineniya
 *
 * ```json
 *  {
 *      "message_type": "string",
 *      "time": "2019-08-24T14:15:22Z"
 *  }
 * ```
 */
class PingMessage extends Data
{
    public function __construct(
        #[In(['TYPE_PING'])]
        public string $message_type,

        #[WithCast(DateTimeInterfaceCast::class)]
        public Carbon $time,
    ) {
    }
}