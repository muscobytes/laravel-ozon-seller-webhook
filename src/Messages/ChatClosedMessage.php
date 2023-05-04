<?php

namespace Muscobytes\OzonSeller\Messages;

use Muscobytes\OzonSeller\Messages\Casts\ChatTypeCast;
use Muscobytes\OzonSeller\Messages\Properties\ChatType;
use Muscobytes\OzonSeller\Messages\Properties\User;
use Spatie\LaravelData\Attributes\Validation\In;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Data;

/**
 * Чат закрыт
 * https://docs.ozon.ru/api/seller/#section/Chat-zakryt
 *
 * ```json
 *  {
 *      "message_type": "TYPE_CHAT_CLOSED",
 *      "chat_id": "b646d975-0c9c-4872-9f41-8b1e57181063",
 *      "chat_type": "Buyer_Seller",
 *      "user": {
 *          "id": "115568",
 *          "type": "Сustomer"
 *      },
 *      "seller_id": "7"
 *  }
 * ```
 */
class ChatClosedMessage extends Data
{
    public function __construct(
        #[In(['TYPE_CHAT_CLOSED'])]
        public string $message_type,

        public string $chat_id,

        #[WithCast(ChatTypeCast::class)]
        public ChatType $chat_type,

        public User $user,

        public int $seller_id
    )
    {
        //
    }
}