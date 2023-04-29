<?php

namespace Muscobytes\OzonSeller\Messages;

use Spatie\LaravelData\Attributes\Validation\In;
use Spatie\LaravelData\Data;

class NewPostingMessage extends Data
{
    public function __construct(
        #[In(['TYPE_NEW_POSTING'])]
        public string $message_type,

        public string $posting_number,

        public array $products,

        public int $sku,

        public int $quantity,

        public string $in_process_at,

        public int $warehouse_id,

        public int $seller_id
    ) {
    }
}