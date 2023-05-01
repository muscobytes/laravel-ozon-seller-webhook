<?php

namespace Muscobytes\OzonSeller\Messages;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\Validation\In;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
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

        #[WithCast(DateTimeInterfaceCast::class)]
        public Carbon $in_process_at,

        public int $warehouse_id,

        public int $seller_id
    ) {
    }
}