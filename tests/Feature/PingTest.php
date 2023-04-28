<?php

namespace Muscobytes\OzonSeller\Tests\Feature;

use Illuminate\Support\Facades\Event;
use Muscobytes\OzonSeller\Events\PingEvent;
use Muscobytes\OzonSeller\Tests\BaseTestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class PingTest extends BaseTestCase
{
    /** @test */
    function test_a_basic_request(): void
    {
        $payload = [
            'message_type' => 'TYPE_PING',
            'time' => '2019-08-24T14:15:22Z'
        ];
        $response = $this->postJson(route('ozonseller.webhook'), $payload);
//        $response->dd();
        $response->assertStatus(200);
    }


//    /** @test */
//    function test_post_ping_message()
//    {
//        Event::fake();
//        $payload = [
//            'message_type' => 'TYPE_PING',
//            'time' => '2019-08-24T14:15:22Z'
//        ];
//        $this->postJson(route('ozonseller.webhook'), $payload);
//        Event::assertDispatched(PingEvent::class, function($event) use ($payload) {
//            return $payload['message_type'] == $event->type;
//        });
//
//    }
}