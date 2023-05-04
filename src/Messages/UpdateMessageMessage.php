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
 * Сообщение в чате изменено
 * https://docs.ozon.ru/api/seller/#section/Soobshenie-v-chate-izmeneno
 *
 * ```json
 *  {
 *      "message_type": "TYPE_UPDATE_MESSAGE",
 *      "chat_id": "b646d975-0c9c-4872-9f41-8b1e57181063",
 *      "chat_type": "Buyer_Seller",
 *      "message_id": "3000000000817031942",
 *      "created_at": "2022-07-18T20:58:04.528Z",
 *      "updated_at": "2022-07-18T20:59:04.528Z",
 *      "user": {
 *          "id": "115568",
 *          "type": "Сustomer"
 *      },
 *      "data": [
 *          "Текст сообщения"
 *      ],
 *      "seller_id": "7"
 *  }
 * ```
 */
class UpdateMessageMessage extends Data
{
    public function __construct(
        #[In(['TYPE_UPDATE_MESSAGE'])]
        public string $message_type,

        public string $chat_id,

        #[WithCast(ChatTypeCast::class)]
        public ChatType $chat_type,

        public string $message_id,

        #[WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d\TH:i:s.vP')]
        public Carbon $created_at,

        #[WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d\TH:i:s.vP')]
        public Carbon $updated_at,

        public User $user,

        public array $data,

        public int $seller_id
    )
    {
        //
    }
}