<?php

namespace Muscobytes\OzonSeller\Tests\Feature;

use Illuminate\Support\Facades\Event;
use Muscobytes\OzonSeller\Events\StateChangedEvent;
use Muscobytes\OzonSeller\Tests\TestCase;

class StateChangedTest extends TestCase
{
    /**
     * @test
     * @dataProvider test_state_changed_is_event_dispatched_data_provider
     */
    public function test_state_changed_is_event_dispatched(string $client_id, array $payload): void
    {
        Event::fake();
        $response = $this->postJson(route('ozonseller.webhook', [
                'client_id' => $client_id
            ]), $payload);
        $response->assertStatus(200);
        Event::assertDispatched(StateChangedEvent::class);
    }


    public static function test_state_changed_is_event_dispatched_data_provider(): array
    {
        /**
         * Workaround on
         * 1) Muscobytes\OzonSeller\Tests\Feature\StateChangedTest::test_state_changed_is_event_dispatched_data_provider
         * This test did not perform any assertions
         * @TODO try to figure out why PHPUnit expects that dataProvider method should perform any assertion
         */
        self::assertTrue(true);

        $client_id = '314159265359';
        return [
            [
                'client_id' => $client_id,
                'payload'   => [
                    'message_type'          => 'TYPE_STATE_CHANGED',
                    'posting_number'        => '24219509-0020-2',
                    'new_state'             => 'posting_delivered',
                    'changed_state_date'    => '2021-02-02T15:07:46.765Z',
                    'warehouse_id'          => 0,
                    'seller_id'             => 15
                ]
            ],
        ];
    }
}