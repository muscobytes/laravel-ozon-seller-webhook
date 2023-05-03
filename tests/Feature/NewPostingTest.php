<?php

namespace Muscobytes\OzonSeller\Tests\Feature;

use Illuminate\Support\Facades\Event;
use Muscobytes\OzonSeller\Events\NewPostingEvent;
use Muscobytes\OzonSeller\Tests\TestCase;

class NewPostingTest extends TestCase
{
    public function test_new_posting()
    {
        Event::fake();
        $payload = [
            'message_type'          => 'TYPE_NEW_POSTING',
            'posting_number'        => '24219509-0020-1',
            'products'              => [
                [
                    'sku'                   => 147451959,
                    'quantity'              => 2
                ]
            ],
            'in_process_at'         => '2021-01-26T06:56:36.294Z',
            'warehouse_id'          => 18850503335000,
            'seller_id'             => 15
        ];
        $route = route('ozonseller.webhook', [
            'client_id' => '314159265359'
        ]);
        $response = $this->postJson($route, $payload);
        $response->assertStatus(200);
        Event::assertDispatched(NewPostingEvent::class);
    }

}