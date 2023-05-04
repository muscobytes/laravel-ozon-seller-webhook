<?php

namespace Muscobytes\OzonSeller\Messages;

use Muscobytes\OzonSeller\Messages\Properties\Item;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\Validation\In;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

/**
 * Изменение остатков на складах продавца
 * https://docs.ozon.ru/api/seller/#section/Izmenenie-ostatkov-na-skladah-prodavca
 *
 * ```json
 *  {
 *      "message_type": "string",
 *      "seller_id": 0,
 *      "items": [
 *          {
 *              "product_id": 0,
 *              "sku": 0,
 *              "updated_at": "2021-09-01T14:15:22Z",
 *              "stocks": [
 *                  {
 *                      "warehouse_id": 0,
 *                      "present": 0,
 *                      "reserved": 0
 *                  }
 *              ]
 *          }
 *      ]
 *  }
 */
class StocksChangedMessage extends Data
{
    public function __construct(
        #[In('TYPE_STOCKS_CHANGED')]
        public string $message_type,

        public int $seller_id,

        #[DataCollectionOf(Item::class)]
        public DataCollection $items
    )
    {
    }
}