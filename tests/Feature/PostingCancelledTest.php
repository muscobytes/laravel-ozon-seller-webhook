<?php

namespace Muscobytes\OzonSeller\Tests\Feature;

use Illuminate\Support\Facades\Event;
use Muscobytes\OzonSeller\Events\PostingCancelledEvent;
use Muscobytes\OzonSeller\Messages\PostingCancelledMessage;
use Muscobytes\OzonSeller\Tests\TestCase;

class PostingCancelledTest extends TestCase
{

    public function test_posting_cancelled()
    {
        Event::fake();
        $payload = [
            'message_type'          => 'TYPE_POSTING_CANCELLED',
            'posting_number'        => '24219509-0020-1',
            'products'              => [
                [
                    'sku'                   => 147451959,
                    'quantity'              => 1
                ]
            ],
            'old_state'             => 'posting_transferred_to_courier_service',
            'new_state'             => 'posting_canceled',
            'changed_state_date'    => '2021-01-26T06:56:36.294Z',
            'reason'                => [
                'id'                    => 0,
                'message'               => 'string'
            ],
            'warehouse_id'          => 0,
            'seller_id'             => 15
        ];
        $route = route('ozonseller.webhook', [
            'client_id' => '314159265359'
        ]);
        $response = $this->postJson($route, $payload);
        $response->assertStatus(200);
        Event::assertDispatched(PostingCancelledEvent::class);
    }
}