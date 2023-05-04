<?php

namespace Muscobytes\OzonSeller\Messages;

use Carbon\Carbon;
use Muscobytes\OzonSeller\Messages\Casts\ChatTypeCast;
use Muscobytes\OzonSeller\Messages\Properties\ChatType;
use Muscobytes\OzonSeller\Messages\Properties\User;
use Spatie\LaravelData\Attributes\Validation\In;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;

/**
 * Ваше сообщение прочитано
 * https://docs.ozon.ru/api/seller/#section/Vashe-soobshenie-prochitano
 *
 * ```json
 *  {
 *      "message_type": "TYPE_MESSAGE_READ",
 *      "chat_id": "b646d975-0c9c-4872-9f41-8b1e57181063",
 *      "chat_type": "Buyer_Seller",
 *      "message_id": "3000000000817031942",
 *      "created_at": "2022-07-18T20:58:04.528Z",
 *      "user": {
 *          "id": "115568",
 *          "type": "Сustomer"
 *      },
 *      "last_read_message_id": "3000000000817031942",
 *      "seller_id": "7"
 *  }
 * ```
 */
class MessageReadMessage extends Data
{
    public function __construct(
        #[In(['TYPE_MESSAGE_READ'])]
        public string $message_type,

        public string $chat_id,

        #[WithCast(ChatTypeCast::class)]
        public ChatType $chat_type,

        public string $message_id,

        #[WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d\TH:i:s.vP')]
        public Carbon $created_at,

        public User $user,

        public string $last_read_message_id,

        public int $seller_id
    )
    {
        //
    }
}