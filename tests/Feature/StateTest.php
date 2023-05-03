<?php

namespace Muscobytes\OzonSeller\Tests\Feature;

use Muscobytes\OzonSeller\Messages\Properties\State;
use Muscobytes\OzonSeller\Tests\TestCase;

class StateTest extends TestCase
{
    /**
     * @test
     * @dataProvider state_provider
     */
    public function state_test($value)
    {
        $state = new State($value);
        $this->assertEquals($value, $state->value);
    }


    public static function state_provider(): array
    {
        return [
            ['posting_acceptance_in_progress'],
            ['posting_created'],
            ['posting_transferring_to_delivery'],
            ['posting_in_carriage'],
            ['posting_not_in_carriage'],
            ['posting_in_client_arbitration'],
            ['posting_on_way_to_city'],
            ['posting_transferred_to_courier_service'],
            ['posting_in_courier_service'],
            ['posting_on_way_to_pickup_point'],
            ['posting_in_pickup_point'],
            ['posting_conditionally_delivered'],
            ['posting_driver_pick_up'],
            ['posting_not_in_sort_center']
        ];
    }
}