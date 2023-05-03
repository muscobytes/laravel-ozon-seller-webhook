<?php

namespace Muscobytes\OzonSeller\Messages;

use Carbon\Carbon;
use Muscobytes\OzonSeller\Messages\Casts\ReasonCast;
use Muscobytes\OzonSeller\Messages\Casts\StateCast;
use Muscobytes\OzonSeller\Messages\Properties\Product;
use Muscobytes\OzonSeller\Messages\Properties\Reason;
use Muscobytes\OzonSeller\Messages\Properties\State;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\Validation\Enum;
use Spatie\LaravelData\Attributes\Validation\In;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class PostingCancelledMessage extends Data
{
    public function __construct(
        #[In('TYPE_POSTING_CANCELLED')]
        public string $message_type,

        public string $posting_number,

        #[DataCollectionOf(Product::class)]
        public DataCollection $products,

        #[WithCast(StateCast::class)]
        public State $old_state,

        #[In('posting_canceled')]
        #[WithCast(StateCast::class)]
        public State $new_state,

        #[WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d\TH:i:s.vP')]
        public Carbon $changed_state_date,

        #[WithCast(ReasonCast::class)]
        public Reason $reason,

        public int $warehouse_id,

        public int $seller_id
    )
    {
    }
}
