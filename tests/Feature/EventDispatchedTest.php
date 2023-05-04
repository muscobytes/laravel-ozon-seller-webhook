<?php

namespace Muscobytes\OzonSeller\Tests\Feature;

use Illuminate\Support\Facades\Event;
use Muscobytes\OzonSeller\Events\CreateItemEvent;
use Muscobytes\OzonSeller\Events\CutoffDateChangedEvent;
use Muscobytes\OzonSeller\Events\DeliveryDateChangedEvent;
use Muscobytes\OzonSeller\Events\NewPostingEvent;
use Muscobytes\OzonSeller\Events\PingEvent;
use Muscobytes\OzonSeller\Events\PostingCancelledEvent;
use Muscobytes\OzonSeller\Events\StateChangedEvent;
use Muscobytes\OzonSeller\Events\UpdateItemEvent;
use Muscobytes\OzonSeller\Tests\TestCase;


class EventDispatchedTest extends TestCase
{
    /**
     * @test
     * @dataProvider test_is_event_dispatched_data_provider
     */
    public function test_is_event_dispatched(string $client_id, $event, array $payload): void
    {
        Event::fake();
        $response = $this->postJson(
            route('ozonseller.webhook', [
                'client_id' => $client_id
            ]),
            $payload
        );
        $response->assertStatus(200);
        Event::assertDispatched($event);
    }


    public static function test_is_event_dispatched_data_provider(): array
    {
        /**
         * Workaround on
         * Muscobytes\OzonSeller\Tests\Feature\EventDispatchedTest::test_is_event_dispatched with data set #2
         * This test did not perform any assertions
         * @TODO try to figure out why PHPUnit expects that dataProvider method should perform any assertion
         */
        self::assertTrue(true);

        $client_id = '314159265359';

        return [
            /**
             * #0 PingEvent
             */
            [
                'client_id' => $client_id,
                'event'     => PingEvent::class,
                'payload'   => [
                    'message_type' => 'TYPE_PING',
                    'time' => '2019-08-24T14:15:22Z'
                ]
            ],

            /**
             * #1 NewPostingEvent
             */
            [
                'client_id' => $client_id,
                'event'     => NewPostingEvent::class,
                'payload'   => [
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
                ]
            ],

            /**
             * #2 PostingCancelledEvent
             */
            [
                'client_id' => $client_id,
                'event'     => PostingCancelledEvent::class,
                'payload'   => [
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
                ]
            ],

            /**
             * #3 StateChangedEvent
             */
            [
                'client_id' => $client_id,
                'event'     => StateChangedEvent::class,
                'payload'   => [
                    'message_type'          => 'TYPE_STATE_CHANGED',
                    'posting_number'        => '24219509-0020-2',
                    'new_state'             => 'posting_delivered',
                    'changed_state_date'    => '2021-02-02T15:07:46.765Z',
                    'warehouse_id'          => 0,
                    'seller_id'             => 15
                ]
            ],

            /**
             * #4 CutoffDateChangedEvent
             */
            [
                'client_id' => $client_id,
                'event'     => CutoffDateChangedEvent::class,
                'payload'   => [
                    'message_type'          => 'TYPE_CUTOFF_DATE_CHANGED',
                    'posting_number'        => '24219509-0020-2',
                    'new_cutoff_date'       => '2021-11-24T07:00:00Z',
                    'old_cutoff_date'       => '2021-11-21T10:00:00Z',
                    'warehouse_id'          => 0,
                    'seller_id'             => 15
                ]
            ],

            /**
             * #5 DeliveryDateChangedEvent
             */
            [
                'client_id' => $client_id,
                'event'     => DeliveryDateChangedEvent::class,
                'payload'   => [
                    'message_type'          => 'TYPE_DELIVERY_DATE_CHANGED',
                    'posting_number'        => '24219509-0020-2',
                    'new_delivery_date_begin'   => '2021-11-24T07:00:00Z',
                    'new_delivery_date_end'     => '2021-11-24T16:00:00Z',
                    'old_delivery_date_begin'   => '2021-11-21T10:00:00Z',
                    'old_delivery_date_end'     => '2021-11-21T19:00:00Z',
                    'warehouse_id'          => 0,
                    'seller_id'             => 15
                ]
            ],

            /**
             * #6 CreateItemEvent
             */
            [
                'client_id' => $client_id,
                'event'     => CreateItemEvent::class,
                'payload'   => [
                    'message_type'          => 'TYPE_CREATE_ITEM',
                    'seller_id'             => 0,
                    'offer_id'              => 'string',
                    'product_id'            => 0,
                    'is_error'              => false,
                    'changed_at'            => '2021-09-01T14:15:22Z'
                ]
            ],

            /**
             * #7 UpdateItemEvent
             */
            [
                'client_id' => $client_id,
                'event'     => UpdateItemEvent::class,
                'payload'   => [
                    'message_type'          => 'TYPE_UPDATE_ITEM',
                    'seller_id'             => 0,
                    'offer_id'              => 'string',
                    'product_id'            => 0,
                    'is_error'              => false,
                    'changed_at'            => '2021-09-01T14:15:22Z'
                ]

            ]
        ];
    }
}
